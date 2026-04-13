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
        'rider_id',
        'order_id',
        'order_number',
        'order_status',
        'order_amount',
        'tax_amount',
        'total_amount',
        'discount_amount',
        'shipping_fee',
        'shipping_method',
        'voucher_code',
        'payment_method',
        'payment_status',
        'shipping_address_id',
        'billing_address_id',
        'tracking_number',
        'customer_notes',
        'rider_picked_up_at',
        'rider_delivered_at',
        'rider_notes',
        'rider_lat',
        'rider_lng',
        'estimated_delivery_minutes',
        'delivery_started_at',
    ];

    protected $casts = [
        'order_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'rider_lat' => 'decimal:7',
        'rider_lng' => 'decimal:7',
        'rider_picked_up_at' => 'datetime',
        'rider_delivered_at' => 'datetime',
        'delivery_started_at' => 'datetime',
    ];

    /**
     * Order status values for filtering.
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';

    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_PENDING = 'pending';
    public const PAYMENT_FAILED = 'failed';

    /**
     * Get estimated arrival time as a Carbon instance.
     */
    public function getEstimatedArrivalAttribute()
    {
        if (!$this->delivery_started_at || !$this->estimated_delivery_minutes) {
            return null;
        }
        return $this->delivery_started_at->addMinutes($this->estimated_delivery_minutes);
    }

    /**
     * Get delivery progress as a percentage (0–100).
     */
    public function getDeliveryProgressPercent(): int
    {
        if ($this->order_status === self::STATUS_DELIVERED) return 100;
        if (!$this->delivery_started_at || !$this->estimated_delivery_minutes) return 0;

        $elapsed = now()->diffInSeconds($this->delivery_started_at);
        $total = $this->estimated_delivery_minutes * 60;
        if ($total <= 0) return 0;

        return min(95, max(0, (int) round(($elapsed / $total) * 100)));
    }

    /**
     * Human-readable ETA string.
     */
    public function getFormattedEtaAttribute(): string
    {
        if ($this->order_status === self::STATUS_DELIVERED) return 'Delivered!';
        if (!$this->delivery_started_at || !$this->estimated_delivery_minutes) return 'Calculating...';

        $arrival = $this->estimated_arrival;
        if (!$arrival) return 'Calculating...';

        $minutesLeft = (int) now()->diffInMinutes($arrival, false);

        if ($minutesLeft <= 0) return 'Arriving now!';
        if ($minutesLeft <= 2) return 'Almost there!';
        if ($minutesLeft <= 5) return 'Arriving soon!';
        if ($minutesLeft > 60) {
            $h = intdiv($minutesLeft, 60);
            $m = $minutesLeft % 60;
            return "~{$h}h {$m}m";
        }
        return "~{$minutesLeft} min";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(UserAddress::class, 'shipping_address_id');
    }

    /**
     * The rider assigned to deliver this order.
     */
    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
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
        return 'P' . number_format((float) $this->total_amount, 0);
    }

    /**
     * Trigger notification when order is placed
     */
    public function notifyOrderPlaced(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'order_placed');
    }

    /**
     * Trigger notification when order is confirmed
     */
    public function notifyOrderConfirmed(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'order_confirmed');
    }

    /**
     * Trigger notification when order starts processing
     */
    public function notifyOrderProcessing(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'order_processing');
    }

    /**
     * Trigger notification when order is ready
     */
    public function notifyOrderReady(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'order_ready');
    }

    /**
     * Trigger notification when rider is assigned
     */
    public function notifyRiderAssigned(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'rider_assigned');
    }

    /**
     * Trigger notification when rider is out for delivery
     */
    public function notifyRiderOutForDelivery(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'rider_out_for_delivery');
    }

    /**
     * Trigger notification when rider arrives
     */
    public function notifyRiderArrived(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'rider_arrived');
    }

    /**
     * Trigger notification when order is delivered
     */
    public function notifyOrderDelivered(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'order_delivered');
    }

    /**
     * Trigger notification when payment is received
     */
    public function notifyPaymentReceived(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'payment_received');
    }

    /**
     * Trigger notification when order is cancelled
     */
    public function notifyOrderCancelled(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'order_cancelled');
    }

    /**
     * Trigger notification when refund is processed
     */
    public function notifyRefundProcessed(): void
    {
        \App\Events\OrderNotificationEvent::dispatch($this, 'refund_processed');
    }
}
