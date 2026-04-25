<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

function checkImage($model, $id, $raw, $field) {
    if (!$raw) return;
    if (strpos($raw, 'http') === 0) return;
    
    $orig = $raw;
    $raw = str_replace('\\', '/', trim((string) $raw));
    $raw = ltrim($raw, '/');
    if (strpos($raw, 'storage/') === 0) {
        $raw = substr($raw, strlen('storage/'));
    } elseif (strpos($raw, 'public/') === 0) {
        $raw = substr($raw, strlen('public/'));
    }

    $path = storage_path('app/public/' . ltrim($raw, '/'));
    if (!file_exists($path)) {
        echo "Missing $model#$id $field => $orig (expected at $path)\n";
    }
}

foreach(App\Models\Product::all() as $m) checkImage('Product', $m->id, $m->animal_image_url, 'animal_image_url');
foreach(App\Models\ProductVariant::all() as $m) checkImage('ProductVariant', $m->id, $m->image_url, 'image_url');
foreach(App\Models\Brand::all() as $m) checkImage('Brand', $m->id, $m->logo_path, 'logo_path');
foreach(App\Models\Category::all() as $m) checkImage('Category', $m->id, $m->image_url, 'image_url');
foreach(App\Models\AnimalType::all() as $m) checkImage('AnimalType', $m->id, $m->image_url, 'image_url');
