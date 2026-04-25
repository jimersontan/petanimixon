<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'seller_id',
        'product_name',
        'animal_type',
        'life_stage',
        'animal_category_id',
        'wet_or_dry',
        'animal_description',
        'animal_image_url',
        'animal_specifications',
        'price',
        'cost_price',
        'cost_plus_price',
        'sku',
        'short_description',
        'full_description',
        'brand_name',
        'is_featured',
        'is_reduced',
        'discount_type',
        'discount_amount',
        'sale_valid_from',
        'sale_valid_until',
        'weight_in_grams',
        'low_stock_threshold',
        'product_status',
        'expiry_date',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'sale_valid_from' => 'datetime',
        'sale_valid_until' => 'datetime',
        'expiry_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'animal_category_id');
    }

    /**
     * Animal types this product applies to (many-to-many via product_animal_types pivot).
     */
    public function animalTypes()
    {
        return $this->belongsToMany(AnimalType::class, 'product_animal_types')
                    ->withPivot('life_stage')
                    ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAvgRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getTotalSoldAttribute()
    {
        return $this->orderItems()->sum('quantity');
    }

    /**
     * Variants associated with the product (different quantities/prices).
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Sum of all variant quantities; used as a computed stock value.
     */
    public function getStockAttribute()
    {
        return $this->variants()->sum('variant_quantity');
    }

    /**
     * Full public URL for the product image.
     * Handles paths stored by the admin (e.g. "products/abc.jpg") via asset('storage/...')
     * as well as external URLs (http/https).
     */
    public function getImageUrlAttribute()
    {
        $raw = $this->animal_image_url;

        if (empty($raw)) {
            return asset('images/placeholder.png');
        }

        // External URL – return as-is
        if (strpos($raw, 'http://') === 0 || strpos($raw, 'https://') === 0) {
            return $raw;
        }

        // Normalize legacy values like "/storage/products/x.jpg" or "public/products/x.jpg"
        $raw = str_replace('\\', '/', trim((string) $raw));
        $raw = ltrim($raw, '/');

        if (strpos($raw, 'storage/') === 0) {
            $raw = substr($raw, strlen('storage/'));
        } elseif (strpos($raw, 'public/') === 0) {
            $raw = substr($raw, strlen('public/'));
        }

        return asset('storage/' . ltrim($raw, '/'));
    }

    /**
     * Whether this product has an active sale discount right now.
     */
    public function isSaleActive(): bool
    {
        if (!$this->is_reduced || !$this->discount_type || !$this->discount_amount) {
            return false;
        }

        $now = now();
        if ($this->sale_valid_from && $this->sale_valid_from->gt($now)) {
            return false;
        }
        if ($this->sale_valid_until && $this->sale_valid_until->lt($now)) {
            return false;
        }

        return true;
    }

    /**
     * Attribute accessor version for Blade/property usage.
     */
    public function getIsSaleActiveAttribute(): bool
    {
        return $this->isSaleActive();
    }

    /**
     * Final price shown to users (discounted when sale is active).
     */
    public function getSalePriceAttribute(): float
    {
        $base = (float) $this->price;
        if (!$this->isSaleActive()) {
            return $base;
        }

        $discount = (float) $this->discount_amount;
        $type = strtolower((string) $this->discount_type);

        if (in_array($type, ['percent', 'percentage'], true)) {
            return max(0, round($base * (1 - ($discount / 100)), 2));
        }

        if ($type === 'fixed') {
            return max(0, round($base - $discount, 2));
        }

        return $base;
    }
}
