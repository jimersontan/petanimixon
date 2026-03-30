<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$products = App\Models\Product::select('id','product_name','animal_image_url')->get();
foreach ($products as $p) {
    $img = $p->animal_image_url ?? 'NULL';
    echo $p->id . ' | ' . substr($p->product_name, 0, 35) . ' | ' . $img . "\n";
}
