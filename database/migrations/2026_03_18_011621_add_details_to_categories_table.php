<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->nullable()->after('category_name');
            $table->string('image_url')->nullable()->after('description');
            $table->integer('sort_order')->default(0)->after('image_url');
            $table->boolean('is_featured')->default(0)->after('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['description', 'image_url', 'sort_order', 'is_featured']);
        });
    }
}
