<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraToStoreSettings extends Migration
{
    public function up()
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->json('extra')->nullable()->after('default_currency');
        });
    }

    public function down()
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->dropColumn('extra');
        });
    }
}
