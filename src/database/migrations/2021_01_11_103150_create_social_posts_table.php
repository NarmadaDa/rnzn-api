<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialPostsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("social_posts", function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->softDeletes();

      $table->uuid("uuid")->unique();
      $table->unsignedBigInteger("social_account_id");
      $table->string("post_id", 64);
      $table->string("post_url", 1024)->nullable();
      $table->text("content")->nullable();
      $table->string("type", 64);
      $table->timestamp("posted_at")->nullable();

      $table
        ->foreign("social_account_id")
        ->references("id")
        ->on("social_accounts")
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
    Schema::dropIfExists("social_posts");
  }
}
