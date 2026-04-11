<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;

DB::table('users')->where('email', 'admin@petverse.com')
    ->orWhere('email', 'admin@petverseccom')
    ->update(['email' => 'admin@petmarkt-ph.com']);

echo "Updated admin email to admin@petmarkt-ph.com\n";
