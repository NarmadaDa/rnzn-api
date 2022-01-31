<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleFeedbackTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("article_feedback", function (Blueprint $table) {
      $table->unsignedBigInteger("article_id");
      $table->unsignedBigInteger("user_id");
      $table->primary(["article_id", "user_id"]);
      $table->timestamps();
      $table->tinyInteger("rating");

      $table
        ->foreign("article_id")
        ->references("id")
        ->on("articles")
        ->onDelete("cascade");

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
    Schema::dropIfExists("article_feedback");
  }
}
