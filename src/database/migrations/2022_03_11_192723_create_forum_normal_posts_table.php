<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumNormalPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_normal_posts', function (Blueprint $table) { 
            $table->id();
            $table->string("post"); 
            $table->string('image', 1024)->nullable(); 
            $table->boolean('inappropriate')->default(false);
            $table->uuid("uuid")->unique(); 
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
        Schema::dropIfExists('forum_normal_posts');
    }
}
