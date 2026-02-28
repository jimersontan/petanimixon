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
        'animal_type_id',
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
}
