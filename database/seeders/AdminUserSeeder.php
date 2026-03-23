<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This class exists so that the command
     * `php artisan db:seed --class=AdminUserSeeder`
     * works while reusing the existing CreateAdminSeeder logic.
     */
    public function run()
    {
        (new CreateAdminSeeder())->run();
    }
}

