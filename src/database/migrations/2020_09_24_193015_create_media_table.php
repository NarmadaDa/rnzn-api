<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("media", function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->softDeletes();

      $table->uuid("uuid")->unique();
      $table->unsignedBigInteger("mediable_id")->index();
      $table->enum("mediable_type", [
        "article",
        "menu",
        "menu_item",
        "post",
        "social_post",
      ]);
      $table->string("type", 64);
      $table->string("thumbnail_url", 1024)->nullable();
      $table->string("url", 1024);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists("media");
  }
}
