<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo_url')->nullable();
            $table->string('tracking_url');
            $table->boolean('is_active')->default(true);
            $table->integer('deliveries_count')->default(0);
            $table->timestamps();
        });

        // Seed J&T Express as the default courier
        DB::table('couriers')->insert([
            'name' => 'J&T Express',
            'logo_url' => '/images/couriers/jt-express.png',
            'tracking_url' => 'https://www.jtexpress.ph/trajectoryQuery?awbs=',
            'is_active' => true,
            'deliveries_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
