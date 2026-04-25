<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$settings = App\Models\StoreSetting::first();
if ($settings) { 
    echo json_encode($settings->toArray(), JSON_PRETTY_PRINT); 
}
