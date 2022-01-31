<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleRolesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("article_roles", function (Blueprint $table) {
      $table->unsignedBigInteger("article_id");
      $table->unsignedBigInteger("role_id");
      $table->primary(["article_id", "role_id"]);
      $table->timestamps();

      $table
        ->foreign("article_id")
        ->references("id")
        ->on("articles")
        ->onDelete("cascade");

      $table
        ->foreign("role_id")
        ->references("id")
        ->on("roles")
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
    Schema::dropIfExists("article_roles");
  }
}
