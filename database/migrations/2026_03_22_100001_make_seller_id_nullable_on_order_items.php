<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MakeSellerIdNullableOnOrderItems extends Migration
{
    public function up()
    {
        // Drop the foreign key first, then make nullable
        Schema::table('order_items', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['seller_id']);
        });

        // Now alter column to nullable
        DB::statement('ALTER TABLE order_items MODIFY seller_id BIGINT UNSIGNED NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE order_items MODIFY seller_id BIGINT UNSIGNED NOT NULL');

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('restrict');
        });
    }
}
