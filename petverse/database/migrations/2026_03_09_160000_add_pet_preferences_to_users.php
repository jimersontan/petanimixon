<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPetPreferencesToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'pet_type')) {
                $table->string('pet_type')->nullable()->after('user_type');
            }
            if (!Schema::hasColumn('users', 'wants_promos')) {
                $table->boolean('wants_promos')->default(false)->after('pet_type');
            }
            if (!Schema::hasColumn('users', 'wants_tips')) {
                $table->boolean('wants_tips')->default(false)->after('wants_promos');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pet_type', 'wants_promos', 'wants_tips']);
        });
    }
}
