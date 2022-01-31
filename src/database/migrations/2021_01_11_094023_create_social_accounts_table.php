<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialAccountsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("social_accounts", function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->softDeletes();

      $table->uuid("uuid")->unique();
      $table->string("type", 64);
      $table->string("social_id")->nullable();
      $table->string("name")->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists("social_accounts");
  }
}
