<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_posts', function (Blueprint $table) {
            $table->unsignedBigInteger("channel_id");
            $table->unsignedBigInteger("forum_normal_post_id");
            $table->primary(["channel_id", "forum_normal_post_id"]);
            $table->timestamps();
    
            $table
            ->foreign("channel_id")
            ->references("id")
            ->on("channels")
            ->onDelete("cascade");
    
            $table
            ->foreign("forum_normal_post_id")
            ->references("id")
            ->on("forum_normal_posts")
            ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_posts');
    }
}
