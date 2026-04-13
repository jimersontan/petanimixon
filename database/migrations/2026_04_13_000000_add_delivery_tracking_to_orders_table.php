<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('rider_lat', 10, 7)->nullable()->after('rider_notes');
            $table->decimal('rider_lng', 10, 7)->nullable()->after('rider_lat');
            $table->integer('estimated_delivery_minutes')->nullable()->after('rider_lng');
            $table->dateTime('delivery_started_at')->nullable()->after('estimated_delivery_minutes');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['rider_lat', 'rider_lng', 'estimated_delivery_minutes', 'delivery_started_at']);
        });
    }
};
