<?php

namespace App\Services;

use App\Models\UserNotification;

class NotificationService
{
    /**
     * Notify user that their order was placed successfully.
     */
    public static function notifyOrderPlaced($userId, $orderId, string $displayRef): ?UserNotification
    {
        return UserNotification::createNotification(
            $userId,
            'order_status',
            'Order received',
            "We've received your order {$displayRef}. Thank you for shopping with us!",
            '🛒',
            '#ea580c',
            $orderId,
            'Order'
        );
    }

    /**
     * Notify user that a rider has arrived.
     */
    public static function notifyRiderArrived($userId, $orderId, string $riderLabel): ?UserNotification
    {
        return UserNotification::createNotification(
            $userId,
            'delivery',
            'Rider arrived',
            "{$riderLabel} has arrived with your order.",
            '📍',
            '#8b5cf6',
            $orderId,
            'Order'
        );
    }

    /**
     * Notify user that a refund was processed.
     */
    public static function notifyRefundProcessed($userId, $orderId): ?UserNotification
    {
        return UserNotification::createNotification(
            $userId,
            'payment',
            'Refund processed',
            'Your refund for this order has been processed.',
            '💸',
            '#10b981',
            $orderId,
            'Order'
        );
    }

    /**
     * Notify user about order status change
     */
    public static function notifyOrderStatusChange($userId, $orderId, $newStatus)
    {
        $statusMessages = [
            'pending' => '⏳ Your order is pending confirmation',
            'confirmed' => '✅ Your order has been confirmed',
            'processing' => '📦 Your order is being prepared',
            'ready_for_delivery' => '🚗 Your order is ready for delivery',
            'out_for_delivery' => '🚙 Your order is out for delivery',
            'delivered' => '📬 Your order has been delivered',
            'cancelled' => '❌ Your order has been cancelled',
        ];

        $icons = [
            'pending' => '⏳',
            'confirmed' => '✅',
            'processing' => '📦',
            'ready_for_delivery' => '🚗',
            'out_for_delivery' => '🚙',
            'delivered' => '📬',
            'cancelled' => '❌',
        ];

        $colors = [
            'pending' => '#f59e0b',
            'confirmed' => '#10b981',
            'processing' => '#3b82f6',
            'ready_for_delivery' => '#8b5cf6',
            'out_for_delivery' => '#ec4899',
            'delivered' => '#06b6d4',
            'cancelled' => '#ef4444',
        ];

        $message = $statusMessages[$newStatus] ?? 'Order status updated';
        $icon = $icons[$newStatus] ?? '📦';
        $color = $colors[$newStatus] ?? '#ea580c';

        return UserNotification::createNotification(
            $userId,
            'order_status',
            'Order Status Update',
            $message,
            $icon,
            $color,
            $orderId,
            'Order'
        );
    }

    /**
     * Notify user about rider assignment
     */
    public static function notifyRiderAssigned($userId, $orderId, $riderName)
    {
        return UserNotification::createNotification(
            $userId,
            'delivery',
            'Rider Assigned',
            "🚴 {$riderName} has been assigned to deliver your order",
            '🚴',
            '#3b82f6',
            $orderId,
            'Order'
        );
    }

    /**
     * Notify user about payment received
     */
    public static function notifyPaymentReceived($userId, $orderId, $amount)
    {
        return UserNotification::createNotification(
            $userId,
            'payment',
            'Payment Received',
            "💰 We received your payment of ₱" . number_format($amount, 2),
            '💰',
            '#10b981',
            $orderId,
            'Order'
        );
    }

    /**
     * Notify user about promotion
     */
    public static function notifyPromotion($userId, $title, $message)
    {
        return UserNotification::createNotification(
            $userId,
            'promotion',
            $title,
            $message,
            '🎉',
            '#ec4899'
        );
    }

    /**
     * Notify user about system message
     */
    public static function notifySystemMessage($userId, $title, $message)
    {
        return UserNotification::createNotification(
            $userId,
            'system',
            $title,
            $message,
            '🔔',
            '#6b7280'
        );
    }

    /**
     * Notify user about low stock item
     */
    public static function notifyLowStock($userId, $productName, $currentStock)
    {
        return UserNotification::createNotification(
            $userId,
            'stock_alert',
            'Stock Alert',
            "{$productName} is running low (only {$currentStock} left)",
            '⚠️',
            '#f59e0b'
        );
    }

    /**
     * Notify user about item back in stock
     */
    public static function notifyBackInStock($userId, $productName)
    {
        return UserNotification::createNotification(
            $userId,
            'stock_alert',
            'Back in Stock',
            "{$productName} is now back in stock!",
            '📦',
            '#10b981'
        );
    }

    /**
     * Bulk notify multiple users
     */
    public static function bulkNotify($userIds, $type, $title, $message, $icon = '🔔', $color = '#ea580c')
    {
        $notifications = [];
        foreach ($userIds as $userId) {
            $notifications[] = UserNotification::createNotification(
                $userId,
                $type,
                $title,
                $message,
                $icon,
                $color
            );
        }
        return $notifications;
    }
}
