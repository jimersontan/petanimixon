<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('business_email');
            $table->string('business_phone');
            $table->string('business_registration_number');
            $table->string('business_registration_number_type');
            $table->text('business_description')->nullable();
            $table->string('store_name');
            $table->string('store_banner_url')->nullable();
            $table->text('store_description')->nullable();
            $table->string('verification_status')->default('pending');
            $table->text('verification_documents_url')->nullable();
            $table->string('rating_average')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('sellers');
    }
}
