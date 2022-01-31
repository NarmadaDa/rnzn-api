<?php

use Illuminate\Database\Migrations\Migration;

class UpdateUserNotificationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    DB::statement("
      ALTER TABLE user_notifications
      MODIFY viewed_at
      TIMESTAMP NULL
    ");
  }
}
