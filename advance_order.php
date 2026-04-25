<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Advance Order #1 to "assigned_to_rider" (Ready for Dispatch) so the rider can see it
$order = \App\Models\Order::find(1);
if ($order) {
    $order->update([
        'order_status' => 'assigned_to_rider',
    ]);
    echo "Order #1 advanced to 'assigned_to_rider' (Ready for Dispatch)\n";
    echo "Status: {$order->order_status}\n";
    echo "Shipping type: {$order->shipping_type}\n";
    echo "Rider ID: " . ($order->rider_id ?? 'NULL (in pool)') . "\n";
} else {
    echo "Order #1 not found\n";
}
