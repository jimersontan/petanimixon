<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$cols = Illuminate\Support\Facades\Schema::getColumnListing('users');
print_r($cols);
