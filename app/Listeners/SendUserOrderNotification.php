<?php

namespace App\Listeners;

use App\Events\OrderNotificationEvent;
use App\Models\UserNotification;
use App\Services\NotificationService;

class SendUserOrderNotification
{
    public function handle(OrderNotificationEvent $event): void
    {
        $order = $event->order;
        $order->loadMissing('rider');

        $userId = $order->user_id;
        if (!$userId) {
            return;
        }

        $riderLabel = trim(
            ($order->rider->first_name ?? '') . ' ' . ($order->rider->last_name ?? '')
        ) ?: 'Your rider';

        switch ($event->type) {
            case 'order_placed':
                NotificationService::notifyOrderPlaced($userId, $order->id, $order->display_id);

                // Notify all admins of the new order with a direct link target.
                $adminIds = \App\Models\User::where('is_admin', true)->pluck('id')->toArray();
                foreach ($adminIds as $adminId) {
                    UserNotification::createNotification(
                        $adminId,
                        'system',
                        'New Order Received',
                        "Order {$order->display_id} was just placed.",
                        '🛒',
                        '#10b981',
                        $order->id,
                        'Order',
                        ['source' => 'customer_checkout']
                    );
                }
                break;

            case 'order_confirmed':
                NotificationService::notifyOrderStatusChange($userId, $order->id, 'confirmed');
                break;

            case 'order_processing':
                NotificationService::notifyOrderStatusChange($userId, $order->id, 'processing');
                break;

            case 'order_ready':
                NotificationService::notifyOrderStatusChange($userId, $order->id, 'ready_for_delivery');
                break;

            case 'rider_assigned':
                NotificationService::notifyRiderAssigned($userId, $order->id, $riderLabel);
                break;

            case 'rider_out_for_delivery':
                NotificationService::notifyOrderStatusChange($userId, $order->id, 'out_for_delivery');
                break;

            case 'rider_arrived':
                NotificationService::notifyRiderArrived($userId, $order->id, $riderLabel);
                break;

            case 'order_delivered':
                NotificationService::notifyOrderStatusChange($userId, $order->id, 'delivered');
                break;

            case 'payment_received':
                NotificationService::notifyPaymentReceived(
                    $userId,
                    $order->id,
                    (float) $order->total_amount
                );
                break;

            case 'order_cancelled':
                NotificationService::notifyOrderStatusChange($userId, $order->id, 'cancelled');
                break;

            case 'refund_processed':
                NotificationService::notifyRefundProcessed($userId, $order->id);
                break;

            default:
                break;
        }
    }
}
