<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// Update Admin
DB::table('users')->whereIn('email', [
    'admin@petmarkt-ph.com',
    'admin@petmarkt-ph.com',
    'admin@petmarkt-ph.com'
])->update(['email' => 'admin@petmrkt.com']);

// Update Rider
DB::table('users')->whereIn('email', [
    'jimersontan@petmarkt-ph.com',
    'jimersontan@petmarkt-ph.com'
])->update(['email' => 'jimersontan@petmarkt.com']);

// Update Customer/User
DB::table('users')->whereIn('email', [
    'user@petmarkt-ph.com',
    'user@petmarkt-ph.com',
    'user@petmarkt-ph.com'
])->update(['email' => 'user@petmarkt.com']);

echo "Database emails updated according to user request.\n";
