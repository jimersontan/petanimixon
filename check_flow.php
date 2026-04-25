<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$out = "";

// 1. Check orders table columns
$out .= "=== ORDERS TABLE COLUMNS ===\n";
$cols = Illuminate\Support\Facades\Schema::getColumnListing('orders');
$out .= implode(', ', $cols) . "\n\n";

// 2. Check all orders and their key fields
$out .= "=== ALL ORDERS ===\n";
$orders = \App\Models\Order::select('id','order_status','shipping_type','shipping_method','rider_id','user_id')->orderByDesc('id')->get();
foreach ($orders as $o) {
    $out .= "ID:{$o->id} | Status:{$o->order_status} | ship_type:{$o->shipping_type} | ship_method:{$o->shipping_method} | rider:{$o->rider_id} | user:{$o->user_id}\n";
}
$out .= "Total orders: " . $orders->count() . "\n\n";

// 3. Check riders
$out .= "=== RIDER ACCOUNTS ===\n";
$riders = \App\Models\User::where('user_type', 'rider')->get();
foreach ($riders as $r) {
    $out .= "ID:{$r->id} | {$r->first_name} {$r->last_name} | type:{$r->user_type} | status:{$r->account_status} | email:{$r->email}\n";
}
$out .= "Total riders: " . $riders->count() . "\n\n";

// 4. Check pool query result
$out .= "=== POOL QUERY (status=assigned_to_rider, type=local, rider_id=NULL) ===\n";
$pool = \App\Models\Order::where('order_status', 'assigned_to_rider')
    ->where('shipping_type', 'local')
    ->whereNull('rider_id')
    ->get();
$out .= "Pool count: " . $pool->count() . "\n\n";

// 5. Check without shipping_type filter
$out .= "=== POOL QUERY WITHOUT SHIPPING_TYPE FILTER ===\n";
$pool2 = \App\Models\Order::where('order_status', 'assigned_to_rider')
    ->whereNull('rider_id')
    ->get();
$out .= "Pool count (no type filter): " . $pool2->count() . "\n\n";

// 6. Check distinct shipping_type values
$out .= "=== DISTINCT shipping_type VALUES ===\n";
$types = \App\Models\Order::select('shipping_type')->distinct()->pluck('shipping_type');
$out .= implode(', ', $types->toArray()) . "\n\n";

// 7. Check distinct shipping_method values
$out .= "=== DISTINCT shipping_method VALUES ===\n";
$methods = \App\Models\Order::select('shipping_method')->distinct()->pluck('shipping_method');
$out .= implode(', ', $methods->toArray()) . "\n";

file_put_contents('flow_report.txt', $out);
echo "Done. Check flow_report.txt";
