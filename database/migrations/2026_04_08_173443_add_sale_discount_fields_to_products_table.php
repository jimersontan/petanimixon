<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaleDiscountFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('discount_type')->nullable()->after('is_reduced');
            $table->decimal('discount_amount', 10, 2)->nullable()->after('discount_type');
            $table->dateTime('sale_valid_from')->nullable()->after('discount_amount');
            $table->dateTime('sale_valid_until')->nullable()->after('sale_valid_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['discount_type', 'discount_amount', 'sale_valid_from', 'sale_valid_until']);
        });
    }
}
