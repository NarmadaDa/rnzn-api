<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemRolesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("menu_item_roles", function (Blueprint $table) {
      $table->unsignedBigInteger("menu_item_id");
      $table->unsignedBigInteger("role_id");
      $table->primary(["menu_item_id", "role_id"]);
      $table->timestamps();

      $table
        ->foreign("menu_item_id")
        ->references("id")
        ->on("menu_items")
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
    Schema::dropIfExists("menu_item_roles");
  }
}
