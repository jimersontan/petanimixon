<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = App\Models\Product::where('is_reduced', true)->get();
foreach ($products as $p) {
    echo "ID: {$p->id}\n";
    echo "  Name: {$p->product_name}\n";
    echo "  is_reduced: {$p->is_reduced}\n";
    echo "  discount_type: {$p->discount_type}\n";
    echo "  discount_amount: {$p->discount_amount}\n";
    echo "  sale_valid_from: {$p->sale_valid_from}\n";
    echo "  sale_valid_until: {$p->sale_valid_until}\n";
    echo "  price: {$p->price}\n";
    echo "  sale_price: {$p->sale_price}\n";
    echo "  is_sale_active: " . ($p->is_sale_active ? 'YES' : 'NO') . "\n";
    echo "  now: " . now() . "\n";
    echo "---\n";
}
