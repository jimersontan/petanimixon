<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('order_id')->unique();
            $table->string('order_number');
            $table->string('order_status')->default('pending');
            $table->decimal('order_amount', 12, 2);
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->string('payment_method');
            $table->string('payment_status')->default('pending');

            // Link to saved addresses instead of plain strings
            $table->unsignedBigInteger('shipping_address_id');
            $table->unsignedBigInteger('billing_address_id')->nullable();

            $table->string('tracking_number')->nullable();
            $table->dateTime('estimated_delivery_date')->nullable();
            $table->dateTime('actual_delivery_date')->nullable();
            $table->text('customer_notes')->nullable();
            $table->text('delivery_instructions')->nullable();
            $table->text('special_requests')->nullable();
            $table->string('item_status')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shipping_address_id')->references('id')->on('user_addresses')->onDelete('restrict');
            $table->foreign('billing_address_id')->references('id')->on('user_addresses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
