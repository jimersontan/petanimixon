<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MakeSellerIdNullableOnOrderItems extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (\DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['seller_id']);
            }
            $table->unsignedBigInteger('seller_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('seller_id')->nullable(false)->change();
            if (\DB::getDriverName() !== 'sqlite') {
                $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('restrict');
            }
        });
    }
}
