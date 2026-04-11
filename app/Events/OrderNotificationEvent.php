<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Dispatched when a customer-facing order lifecycle event should create an in-app notification.
 */
class OrderNotificationEvent
{
    use Dispatchable, SerializesModels;

    /** @var Order */
    public $order;

    /** @var string */
    public $type;

    public function __construct(Order $order, string $type)
    {
        $this->order = $order;
        $this->type = $type;
    }
}
