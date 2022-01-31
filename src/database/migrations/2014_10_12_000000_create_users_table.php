<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("users", function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->softDeletes();

      $table->uuid("uuid")->unique();
      $table->string("email")->unique();
      $table->string("password");
      $table->timestamp("email_verified_at")->nullable();
      $table->timestamp("approved_at")->nullable();
      $table->unsignedBigInteger("approved_by")->nullable();

      $table
        ->foreign("approved_by")
        ->references("id")
        ->on("users");
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists("users");
  }
}
