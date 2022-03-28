<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumPostReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_post_reactions', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->uuid("uuid");   // user uuid
            $table->integer('user_id');
            $table->string('likes');
            $table->string('haha');
            $table->string('wow');
            $table->string('sad');
            $table->string('angry');
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
        Schema::dropIfExists('forum_post_reactions');
    }
}
