<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForumPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_posts', function (Blueprint $table) { 
            $table->boolean('pin_post')->default(false)->after("post");
            $table->integer('channel_id')->after("id");
            $table->unsignedInteger('user_id')->after("uuid"); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropColumn(['pin_post']);
            $table->dropColumn(['channel_id']);
            $table->dropColumn(['user_id']);
        });
    }
}
