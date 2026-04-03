<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceAnimalTypeIdWithTextOnProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('products', 'animal_type_id')) {
            Schema::table('products', function (Blueprint $table) {
                if (\DB::getDriverName() !== 'sqlite') {
                    $table->dropForeign(['animal_type_id']);
                }
                $table->dropColumn('animal_type_id');
            });
        }

        if (!Schema::hasColumn('products', 'animal_type')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('animal_type')->nullable()->after('product_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'animal_type')) {
                $table->dropColumn('animal_type');
            }

            if (!Schema::hasColumn('products', 'animal_type_id')) {
                $table->unsignedBigInteger('animal_type_id')->nullable();
                $table->foreign('animal_type_id')
                    ->references('id')
                    ->on('animal_types')
                    ->onDelete('restrict');
            }
        });
    }
}

