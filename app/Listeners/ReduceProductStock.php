<?php

namespace App\Listeners;

use App\Events\OrderDelivered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReduceProductStock implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * Stock is now deducted at order placement (CheckoutController::process).
     * This listener is intentionally left empty to avoid double-deduction.
     *
     * @param  \App\Events\OrderDelivered  $event
     * @return void
     */
    public function handle(OrderDelivered $event)
    {
        // Stock already deducted at checkout — no action needed here.
    }
}
