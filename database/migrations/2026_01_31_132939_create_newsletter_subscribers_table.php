<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('subscriber_id');
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('subscription_status')->default('active');
            $table->string('subscription_source')->nullable();
            $table->string('unsubscribed_date')->nullable();
            $table->string('user_id')->nullable();
            $table->string('subscription_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_subscribers');
    }
}
