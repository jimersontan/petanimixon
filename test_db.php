<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$out = "";
$products = App\Models\Product::where('brand_name', 'Royal Canin')->get();
foreach ($products as $p) {
    $hasVariants = $p->variants()->exists();
    $out .= "ID: {$p->id} | Name: {$p->product_name} | is_featured: {$p->is_featured} | status: {$p->product_status} | category: {$p->animal_category_id} | animal_type: {$p->animal_type} | Variants: " . ($hasVariants ? 'Yes' : 'No') . "\n";
}
file_put_contents(__DIR__ . '/test_db_out.txt', $out);
