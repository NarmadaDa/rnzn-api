<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string("name");  
            $table->string("initial_post")->nullable(); 
            $table->boolean('post_pin')->default(false);
            $table->boolean('channel_active')->default(true);
            $table->string('image', 1024)->nullable(); 
            $table->unsignedBigInteger('user_id');  
            $table->uuid("uuid")->unique(); 
            $table->timestamps();

            $table
            ->foreign("user_id")
            ->references("id")
            ->on("users")
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
        Schema::dropIfExists('channels');
    }
}
