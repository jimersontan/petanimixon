<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->nullable();
            $table->string('store_email')->nullable();
            $table->string('store_phone')->nullable();
            $table->string('store_url')->nullable();
            $table->text('store_description')->nullable();
            $table->string('store_logo_path')->nullable();
            $table->string('timezone')->default('Asia/Manila');
            $table->string('default_currency', 10)->default('PHP');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('store_settings');
    }
}
