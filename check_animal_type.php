<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$products = App\Models\Product::where('brand_name', 'Royal Canin')->get();
foreach($products as $p) {
    echo $p->id . " - " . $p->product_name . " - " . $p->animal_type . "\n";
}
