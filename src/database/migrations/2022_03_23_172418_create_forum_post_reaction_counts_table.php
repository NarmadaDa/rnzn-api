<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumPostReactionCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_post_reaction_counts', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->integer('like_count');
            $table->integer('haha_count');
            $table->integer('wow_count');
            $table->integer('sad_count');
            $table->integer('angry_count');
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
        Schema::dropIfExists('forum_post_reaction_counts');
    }
}
