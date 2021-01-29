<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavouriteFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourite_food', function (Blueprint $table) {
            
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('food_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('favourite_food', function(Blueprint $table){   
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favourite_food');
    }
}
