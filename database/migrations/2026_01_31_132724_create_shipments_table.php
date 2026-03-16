<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('shipment_id');
            $table->string('seller_id');
            $table->string('tracking_number')->nullable();
            $table->string('courier_name');
            $table->string('shipping_address_id');
            $table->string('destination_address');
            $table->string('proof_of_delivery_url')->nullable();
            $table->string('shipment_status')->default('pending');
            $table->dateTime('estimated_delivery_date')->nullable();
            $table->dateTime('actual_delivery_date')->nullable();
            $table->text('shipping_notes')->nullable();
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
}
