<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = App\Models\Product::all();
echo "Total Products: " . count($products) . "\n";
foreach($products as $p) {
    echo "Product " . $p->id . ": " . $p->animal_image_url . "\n";
}
