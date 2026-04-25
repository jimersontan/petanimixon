<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$models = [
    App\Models\StoreSetting::class => ['store_name', 'store_description'],
    App\Models\Category::class => ['category_name', 'description'],
    App\Models\Brand::class => ['name', 'description'],
    App\Models\Product::class => ['product_name', 'short_description', 'full_description', 'animal_description', 'brand_name'],
];

$changes = 0;

foreach ($models as $modelClass => $fields) {
    if (!class_exists($modelClass)) continue;
    $records = $modelClass::all();
    foreach ($records as $record) {
        $updated = false;
        foreach ($fields as $field) {
            $val = $record->$field;
            if (!$val) continue;
            
            $newVal = str_ireplace(['Animixon', 'Petverse', 'Pet Animixon', 'animixon'], ['Markt-PH', 'Pet Markt-PH', 'Pet Markt-PH', 'markt-ph'], $val);
            if ($newVal !== $val) {
                $record->$field = $newVal;
                $updated = true;
            }
        }
        if ($updated) {
            $record->save();
            $changes++;
        }
    }
}

echo "Database updates complete. Replaced in $changes records.\n";
