<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->date('expiry_date')->nullable()->after('product_status');
        });

        // Seed realistic expiry dates across the 3 tiers for existing products
        $products = DB::table('products')->get();
        $now = Carbon::now();

        foreach ($products as $i => $product) {
            $mod = $i % 3;
            if ($mod === 0) {
                // URGENT: expires within 1-7 days
                $expiry = $now->copy()->addDays(rand(1, 7));
            } elseif ($mod === 1) {
                // WARNING: expires within 8-30 days
                $expiry = $now->copy()->addDays(rand(8, 30));
            } else {
                // SAFE: expires beyond 30 days
                $expiry = $now->copy()->addDays(rand(45, 180));
            }

            DB::table('products')->where('id', $product->id)->update([
                'expiry_date' => $expiry->toDateString(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('expiry_date');
        });
    }
};
