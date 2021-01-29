<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibraryManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_management', function (Blueprint $table) {

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('library_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('library_management', function(Blueprint $table){   

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('library_id')->references('id')->on('libraries')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('library_management');
    }
}
