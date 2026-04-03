<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertDefaultSystemSeller extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Many applications use seller_id = 0 for admin products
        // This ensures the foreign key constraint isn't violated, particularly in SQLite.
        \Illuminate\Support\Facades\DB::table('sellers')->updateOrInsert(
            ['id' => 0],
            [
                'business_name' => 'System Admin',
                'business_email' => 'admin@petanimixon.local',
                'business_phone' => '0000000000',
                'business_registration_number' => 'SYS-000',
                'business_registration_number_type' => 'System',
                'store_name' => 'System Store',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('sellers')->where('id', 0)->delete();
    }
}
