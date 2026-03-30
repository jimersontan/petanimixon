<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeOrderItemIdNullableOnReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('order_item_id')->nullable()->change();
            $table->text('review_title')->nullable()->change();
            $table->text('review_text')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('order_item_id')->nullable(false)->change();
            $table->text('review_title')->nullable(false)->change();
            $table->text('review_text')->nullable(false)->change();
        });
    }
}
