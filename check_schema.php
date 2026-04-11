<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Show columns
$cols = Schema::getColumnListing('users');
echo "Users columns: " . implode(', ', $cols) . "\n";

// Check if admin already exists
$existing = DB::table('users')->where('email', 'admin@petmarkt-ph.com')->first();
if ($existing) {
    echo "Admin already exists with ID: " . $existing->id . "\n";
} else {
    echo "No admin found yet.\n";
}
