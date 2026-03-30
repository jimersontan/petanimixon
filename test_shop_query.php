<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$query = App\Models\Product::where('product_status', 'active');
$query->where('brand_name', 'Royal Canin');

// sorting: default
$query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');

echo "Count query: " . $query->count() . "\n";
$products = $query->paginate(24);
echo "Paginate total: " . $products->total() . "\n";

