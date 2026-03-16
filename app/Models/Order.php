<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_id',
        'order_number',
        'order_status',
        'order_amount',
        'tax_amount',
        'total_amount',
        'discount_amount',
        'payment_method',
        'payment_status',
        'shipping_address_id',
        'billing_address_id',
        'tracking_number',
        'customer_notes',
    ];

    protected $casts = [
        'order_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Order status values for filtering.
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';

    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_PENDING = 'pending';
    public const PAYMENT_FAILED = 'failed';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Display ID for admin (e.g. #12456).
     */
    public function getDisplayIdAttribute(): string
    {
        return '#' . ($this->order_number ?? $this->id);
    }

    /**
     * Format total for display (e.g. P2,450).
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'P' . number_format($this->total_amount, 0);
    }
}
