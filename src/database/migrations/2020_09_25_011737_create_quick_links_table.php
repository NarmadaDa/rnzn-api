<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickLinksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("quick_links", function (Blueprint $table) {
      $table->uuid("uuid")->primary();
      $table->timestamps();

      $table->unsignedBigInteger("user_id")->index();
      $table->unsignedBigInteger("menu_item_id")->index();
      $table->unsignedSmallInteger("sort_order")->default(0);

      $table
        ->foreign("user_id")
        ->references("id")
        ->on("users")
        ->onDelete("cascade");

      $table
        ->foreign("menu_item_id")
        ->references("id")
        ->on("menu_items")
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
    Schema::dropIfExists("quick_links");
  }
}
