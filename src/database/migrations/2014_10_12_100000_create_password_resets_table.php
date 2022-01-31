<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("password_resets", function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->softDeletes();

      $table->string("email")->index();
      $table->timestamp("expires_at")->nullable();
      $table->string("code");
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists("password_resets");
  }
}
