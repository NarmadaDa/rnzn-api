<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialAuthSessionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("social_auth_sessions", function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->softDeletes();

      $table->unsignedBigInteger("social_account_id");
      $table->string("code", 1024)->nullable();
      $table->string("user_access_token", 1024)->nullable();
      $table->string("long_lived_user_token", 1024)->nullable();
      $table->string("long_lived_page_token", 1024)->nullable();

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
    Schema::dropIfExists("social_auth_sessions");
  }
}
