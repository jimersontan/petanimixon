<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

$password = Hash::make('password123');

DB::table('users')->whereIn('email', [
    'admin@petmarkt-ph.com',
    'user@petmarkt-ph.com',
    'jimersontan@petmarkt-ph.com'
])->update(['password' => $password]);

echo "Passwords set to 'password123' for standard accounts.\n";
