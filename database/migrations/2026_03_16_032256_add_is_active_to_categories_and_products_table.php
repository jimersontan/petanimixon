<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToCategoriesAndProductsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('categories') && !Schema::hasColumn('categories', 'is_active')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('category_name');
            });
        }

        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'is_active')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('is_featured');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('categories', 'is_active')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
        if (Schema::hasColumn('products', 'is_active')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
}
