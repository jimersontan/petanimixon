<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_item_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('return_refund_id')->unique();
            $table->string('return_reason');
            $table->text('return_reason_description')->nullable();
            $table->string('return_type');
            $table->string('refund_amount');
            $table->string('refund_status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->text('received_at')->nullable();
            $table->text('proof_of_delivery_url')->nullable();
            $table->text('return_shipping_address_url')->nullable();
            $table->text('seller_response')->nullable();
            $table->text('seller_response_date')->nullable();
            $table->timestamps();
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_refunds');
    }
}
