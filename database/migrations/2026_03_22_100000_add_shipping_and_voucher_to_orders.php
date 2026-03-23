<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingAndVoucherToOrders extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_fee', 10, 2)->default(0)->after('discount_amount');
            $table->string('shipping_method')->nullable()->after('shipping_fee');
            $table->string('voucher_code')->nullable()->after('shipping_method');
        });

        Schema::table('user_addresses', function (Blueprint $table) {
            $table->string('region')->nullable()->after('zip_code');
            $table->string('barangay')->nullable()->after('region');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_fee', 'shipping_method', 'voucher_code']);
        });

        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn(['region', 'barangay']);
        });
    }
}
