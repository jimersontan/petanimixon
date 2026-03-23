<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'variant_name',
        'variant_quantity',
        'uom',
        'variant_price',
        'sku',
        'specifications',
        'low_stock_threshold',
        'product_status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
