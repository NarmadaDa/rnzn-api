<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("menu_items", function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->softDeletes();

      $table->uuid("uuid")->unique();
      $table->unsignedBigInteger("menu_id")->index();
      $table->enum("item_type", ["article", "menu"]);
      $table->unsignedBigInteger("item_id")->index();
      $table->unsignedSmallInteger("sort_order")->default(0);
      $table->string("title");
      $table->string("slug")->unique();

      $table
        ->foreign("menu_id")
        ->references("id")
        ->on("menus")
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
    Schema::dropIfExists("menu_items");
  }
}
