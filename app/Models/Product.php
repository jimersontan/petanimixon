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
        'animal_category_id',
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
        'weight_in_grams',
        'low_stock_threshold',
        'product_status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'animal_category_id');
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
        return $this->variants->sum('variant_quantity');
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
        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            return $raw;
        }

        // Local storage path
        return asset('storage/' . $raw);
    }
}
