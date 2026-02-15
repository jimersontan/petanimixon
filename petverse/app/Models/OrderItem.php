<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'seller_id',
        'quantity',
        'unit_price',
        'total_amount',
        'order_status',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Summary for table cell: "Product Name, Category · x2"
     * Safe when product/category tables or relations are missing.
     */
    public function getSummaryAttribute(): string
    {
        try {
            $quantity = (int) $this->quantity;
            $name = 'Product #' . $this->product_id;
            $category = '—';

            if ($this->relationLoaded('product') && $this->product instanceof \App\Models\Product) {
                $name = $this->product->getAttribute('product_name') ?: $name;
                if ($this->product->relationLoaded('category') && $this->product->category) {
                    $category = $this->product->category->getAttribute('category_name') ?: '—';
                }
            }

            return $name . ', ' . $category . ' · x' . $quantity;
        } catch (\Throwable $e) {
            return 'Product #' . $this->product_id . ' · x' . (int) $this->quantity;
        }
    }
}
