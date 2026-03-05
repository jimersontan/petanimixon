<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_id');
            $table->string('coupon_code')->unique();
            $table->string('coupon_name');
            $table->text('description')->nullable();
            $table->string('discount_type');
            $table->decimal('discount_amount', 10, 2);
            $table->integer('usage_limit_per_user')->nullable();
            $table->integer('max_usage_limit')->nullable();
            $table->dateTime('valid_from');
            $table->dateTime('valid_until');
            $table->boolean('is_active')->default(true);
            $table->string('applicable_categories')->nullable();
            $table->decimal('min_order_value', 10, 2)->nullable();
            $table->string('usage_limit_per_user_max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
