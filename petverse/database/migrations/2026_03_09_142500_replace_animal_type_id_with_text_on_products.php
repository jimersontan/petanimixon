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
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key and column if they still exist, then add a plain text animal_type
            if (Schema::hasColumn('products', 'animal_type_id')) {
                $table->dropForeign(['animal_type_id']);
                $table->dropColumn('animal_type_id');
            }

            if (!Schema::hasColumn('products', 'animal_type')) {
                $table->string('animal_type')->nullable()->after('product_name');
            }
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

