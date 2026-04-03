<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Update password and ensure admin flags
DB::table('users')->where('email', 'admin@petverse.com')->update([
    'password'          => Hash::make('admin123'),
    'user_type'         => 'admin',
    'email_verified_at' => now(),
    'updated_at'        => now(),
]);

// Try to set is_admin if column exists
try {
    DB::table('users')->where('email', 'admin@petverse.com')->update(['is_admin' => 1]);
} catch (\Exception $e) {}

$user = DB::table('users')->where('email', 'admin@petverse.com')->first();

// Ensure admin_users profile exists
$profile = DB::table('admin_users')->where('user_id', $user->id)->first();
if (!$profile) {
    DB::table('admin_users')->insert([
        'user_id'    => $user->id,
        'admin_type' => 'super_admin',
        'is_active'  => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Admin profile created.\n";
} else {
    echo "Admin profile already exists.\n";
}

echo "\n=== Admin Account Ready ===\n";
echo "Email:    admin@petverse.com\n";
echo "Password: admin123\n";
