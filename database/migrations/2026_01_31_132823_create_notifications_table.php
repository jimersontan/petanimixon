<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('notification_type');
            $table->string('title');
            $table->text('message');
            $table->string('action_url')->nullable();
            $table->string('is_read')->default('N');
            $table->string('notification_medium')->nullable();
            $table->string('admin_user_notification_id')->nullable();
            $table->text('email');
            $table->text('ent_admin');
            $table->text('display_location');
            $table->text('display_order')->nullable();
            $table->text('last_time');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
