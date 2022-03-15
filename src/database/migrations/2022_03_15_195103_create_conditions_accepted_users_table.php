<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConditionsAcceptedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conditions_accepted_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('condition_id');
            $table->uuid('accepted_by(uuid)');
            $table->timestamps();

            $table
                ->foreign("condition_id")
                ->references("id")
                ->on("conditions");

            $table
                ->foreign("accepted_by(uuid)")
                ->references("uuid")
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
        Schema::dropIfExists('conditions_accepted_users');
    }
}
