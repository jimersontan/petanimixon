<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->string('product_name');
            $table->unsignedBigInteger('animal_type_id');
            $table->unsignedBigInteger('animal_category_id');
            $table->text('animal_description')->nullable();
            $table->string('animal_image_url')->nullable();
            $table->text('animal_specifications')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('cost_price')->nullable();
            $table->integer('cost_plus_price')->nullable();
            $table->string('sku')->unique();
            $table->text('short_description');
            $table->text('full_description')->nullable();
            $table->string('brand_name');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_reduced')->default(false);
            $table->decimal('weight_in_grams', 8, 2)->nullable();
            $table->integer('low_stock_threshold')->nullable();
            $table->string('product_status')->default('active');
            $table->timestamps();
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('animal_type_id')->references('id')->on('animal_types')->onDelete('restrict');
            $table->foreign('animal_category_id')->references('id')->on('categories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
