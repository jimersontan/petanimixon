<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsSystem extends Migration
{
    public function up()
    {
        // Add 'comment' and 'images' JSON column to existing reviews table
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'comment')) {
                $table->text('comment')->nullable()->after('rating');
            }
            if (!Schema::hasColumn('reviews', 'images')) {
                $table->json('images')->nullable()->after('comment');
            }
        });

        // Review replies
        if (!Schema::hasTable('review_replies')) {
            Schema::create('review_replies', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('review_id');
                $table->unsignedBigInteger('user_id');
                $table->text('reply');
                $table->timestamps();

                $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // Review likes
        if (!Schema::hasTable('review_likes')) {
            Schema::create('review_likes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('review_id');
                $table->unsignedBigInteger('user_id');
                $table->timestamps();

                $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->unique(['review_id', 'user_id']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('review_likes');
        Schema::dropIfExists('review_replies');
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['comment', 'images']);
        });
    }
}
