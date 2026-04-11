<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$users = \Illuminate\Support\Facades\DB::table('users')->select('email', 'user_type', 'is_admin')->get();
foreach($users as $user) {
    if (in_array($user->user_type, ['admin', 'rider']) || in_array($user->email, ['user@petmarkt-ph.com', 'user@petmarkt-ph.com'])) {
        echo strtoupper($user->user_type) . " - " . $user->email . "\n";
    }
}
