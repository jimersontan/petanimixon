<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_animal_types', function (Blueprint $table) {
            if (!Schema::hasColumn('product_animal_types', 'life_stage')) {
                $table->string('life_stage')->nullable()->after('animal_type_id');
            }
        });
    }

    public function down()
    {
        Schema::table('product_animal_types', function (Blueprint $table) {
            $table->dropColumn('life_stage');
        });
    }
};
