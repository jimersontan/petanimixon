<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'title', 'message', 'icon', 'color',
        'data', 'related_id', 'related_type', 'read', 'read_at'
    ];

    protected $casts = [
        'data' => 'json',
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Get unread notifications count for user
     */
    public static function getUnreadCount($userId)
    {
        return self::where('user_id', $userId)->where('read', false)->count();
    }

    /**
     * Create a notification
     */
    public static function createNotification($userId, $type, $title, $message, $icon = '🔔', $color = '#ea580c', $relatedId = null, $relatedType = null, $data = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'color' => $color,
            'related_id' => $relatedId,
            'related_type' => $relatedType,
            'data' => $data,
        ]);
    }

    /**
     * Human-friendly notification type label for the UI.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'order_status' => 'Order update',
            'delivery' => 'Delivery',
            'payment' => 'Payment',
            'promotion' => 'Promo',
            'support' => 'Support',
            'stock_alert' => 'Stock alert',
            'system' => 'System',
            default => ucfirst(str_replace('_', ' ', (string) $this->type)),
        };
    }

    /**
     * Decide where a notification should open based on the signed-in user's role.
     */
    public function resolveActionUrlFor(User $user): ?string
    {
        $orderId = $this->related_type === 'Order' ? $this->related_id : null;

        if ($user->isAdmin()) {
            if ($orderId && Route::has('admin.orders.show')) {
                return route('admin.orders.show', $orderId);
            }

            return Route::has('dashboard') ? route('dashboard') : null;
        }

        if ($user->isRider()) {
            if (! $orderId) {
                return Route::has('rider.dashboard') ? route('rider.dashboard') : null;
            }

            $order = Order::find($orderId);
            if (! $order) {
                return Route::has('rider.dashboard') ? route('rider.dashboard') : null;
            }

            if (in_array($order->order_status, [Order::STATUS_RIDER_CONFIRMED, Order::STATUS_OUT_FOR_DELIVERY], true)) {
                return Route::has('rider.active') ? route('rider.active') : null;
            }

            if ($order->order_status === Order::STATUS_ASSIGNED_TO_RIDER) {
                return Route::has('rider.available') ? route('rider.available') : null;
            }

            return Route::has('rider.history') ? route('rider.history') : null;
        }

        if ($orderId && Route::has('order.track')) {
            return route('order.track', $orderId);
        }

        if ($this->type === 'support') {
            return Route::has('profile.edit') ? route('profile.edit') : null;
        }

        return Route::has('user.notifications') ? route('user.notifications') : null;
    }

    /**
     * Short CTA shown beside the notification.
     */
    public function resolveActionLabelFor(User $user): string
    {
        if ($user->isAdmin()) {
            return $this->related_type === 'Order' ? 'Open order' : 'Open dashboard';
        }

        if ($user->isRider()) {
            if ($this->related_type !== 'Order') {
                return 'Open dashboard';
            }

            $order = Order::find($this->related_id);
            if ($order && in_array($order->order_status, [Order::STATUS_RIDER_CONFIRMED, Order::STATUS_OUT_FOR_DELIVERY], true)) {
                return 'View delivery';
            }

            if ($order && $order->order_status === Order::STATUS_ASSIGNED_TO_RIDER) {
                return 'View queue';
            }

            return 'View history';
        }

        if ($this->related_type === 'Order') {
            return 'Track order';
        }

        if ($this->type === 'support') {
            return 'Open account';
        }

        return 'Open';
    }
}
