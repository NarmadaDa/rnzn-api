<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("user_notifications", function (Blueprint $table) {
      $table->unsignedBigInteger("notification_id");
      $table->unsignedBigInteger("user_id");
      $table->primary(["notification_id", "user_id"]);
      $table->timestamps();
      $table->timestamp("viewed_at")->nullable();

      $table
        ->foreign("notification_id")
        ->references("id")
        ->on("notifications")
        ->onDelete("cascade");

      $table
        ->foreign("user_id")
        ->references("id")
        ->on("users")
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
    Schema::dropIfExists("user_notifications");
  }
}
