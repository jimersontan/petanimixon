<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$visible = App\Models\Product::with('variants')->find(16)->toArray();
$hidden = App\Models\Product::with('variants')->find(15)->toArray();

echo "--- VISIBLE (16) ---\n";
print_r($visible);

echo "\n--- HIDDEN (15) ---\n";
print_r($hidden);
