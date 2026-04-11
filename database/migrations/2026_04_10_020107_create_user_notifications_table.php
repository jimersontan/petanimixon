<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('type'); // 'order_status', 'delivery', 'payment', 'promotion', 'system'
            $table->string('title');
            $table->text('message');
            $table->string('icon')->nullable(); // emoji or icon identifier
            $table->string('color')->nullable(); // color for badge/icon
            $table->json('data')->nullable(); // additional data (order_id, rider_id, etc)
            $table->unsignedBigInteger('related_id')->nullable()->index(); // order_id, rider_id, etc
            $table->string('related_type')->nullable(); // Order, Rider, Product, etc
            $table->boolean('read')->default(false)->index();
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('user_notifications');
    }
}
