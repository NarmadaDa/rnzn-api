<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFeedbackTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("user_feedback", function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->softDeletes();

      $table->unsignedBigInteger("user_id");
      $table->tinyInteger("rating");
      $table->tinyInteger("recommendation");
      $table->string("positives")->nullable();
      $table->string("improvements")->nullable();

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
    Schema::dropIfExists("user_feedback");
  }
}
