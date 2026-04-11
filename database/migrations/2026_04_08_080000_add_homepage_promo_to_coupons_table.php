<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHomepagePromoToCouponsTable extends Migration
{
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->unsignedBigInteger('featured_product_id')->nullable()->after('min_order_value');
            $table->boolean('show_on_homepage')->default(false)->after('featured_product_id');
        });
    }

    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['featured_product_id', 'show_on_homepage']);
        });
    }
}
