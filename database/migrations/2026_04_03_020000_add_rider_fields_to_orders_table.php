<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('rider_id')->nullable()->after('user_id');
            $table->dateTime('rider_picked_up_at')->nullable()->after('actual_delivery_date');
            $table->dateTime('rider_delivered_at')->nullable()->after('rider_picked_up_at');
            $table->text('rider_notes')->nullable()->after('rider_delivered_at');

            $table->foreign('rider_id')->references('id')->on('users')->onDelete('set null');
            $table->index('rider_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['rider_id']);
            $table->dropIndex(['rider_id']);
            $table->dropColumn(['rider_id', 'rider_picked_up_at', 'rider_delivered_at', 'rider_notes']);
        });
    }
};
