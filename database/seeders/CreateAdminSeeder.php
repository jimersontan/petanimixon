<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    public function run()
    {
        $now = now();

        // Admin user data
        $adminData = [
            'first_name' => 'Admin',
            'last_name' => 'User',
            'password' => Hash::make('password123'),
            'user_type' => 'admin',
            'is_admin' => true,
            'email_verified_at' => $now,
        ];

        // Test user data
        $userData = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'password' => Hash::make('User@123456'),
            'user_type' => 'customer',
            'is_admin' => false,
            'email_verified_at' => $now,
        ];

        // Add name field if column exists
        if (\Schema::hasColumn('users', 'name')) {
            $adminData['name'] = 'Admin User';
            $userData['name'] = 'Test User';
        }

        // Update or create admin user - forces is_admin = true
        $admin = User::where('email', 'admin@petmrkt.com')->first();
        if ($admin) {
            $admin->update($adminData);
        } else {
            $adminData['email'] = 'admin@petmrkt.com';
            $admin = User::create($adminData);
        }

        // Ensure admin_users row exists for this admin user
        if ($admin) {
            AdminUser::updateOrCreate(
                ['user_id' => (string) $admin->id],
                [
                    'admin_user_id' => (string) $admin->id,
                    'admin_type'    => 'super_admin',
                    'permissions'   => 'all',
                    // database column is boolean, use true/false or 1/0
                    'is_active'     => true,
                    'description'   => 'Primary application administrator',
                ]
            );
        }

        // Update or create test user - forces is_admin = false
        $user = User::where('email', 'user@petmarkt.com')->first();
        if ($user) {
            $user->update($userData);
        } else {
            $userData['email'] = 'user@petmarkt.com';
            User::create($userData);
        }

        // Test rider data
        $riderData = [
            'first_name' => 'Test',
            'last_name' => 'Rider',
            'password' => Hash::make('Rider@123456'),
            'user_type' => 'rider',
            'is_admin' => false,
            'email_verified_at' => $now,
        ];
        
        if (\Schema::hasColumn('users', 'name')) {
            $riderData['name'] = 'Test Rider';
        }

        // Update or create test rider
        $rider = User::where('email', 'rider@petmarkt.com')->first();
        if ($rider) {
            $rider->update($riderData);
        } else {
            $riderData['email'] = 'rider@petmarkt.com';
            User::create($riderData);
        }

        echo "Admin user seeded successfully!" . PHP_EOL;
        echo "Admin: admin@petmrkt.com | Password: password123" . PHP_EOL;
        echo "Test User: user@petmarkt.com | Password: User@123456" . PHP_EOL;
        echo "Test Rider: rider@petmarkt.com | Password: Rider@123456" . PHP_EOL;
    }
}
