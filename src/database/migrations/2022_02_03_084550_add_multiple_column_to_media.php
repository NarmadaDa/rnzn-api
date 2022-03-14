<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnToMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('file_type', 20)->nullable();
            $table->string('dimensions', 20)->nullable();
            $table->string('file_size', 20)->nullable();
        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['file_type',  'dimensions', 'file_size']);
        });
    }
}
