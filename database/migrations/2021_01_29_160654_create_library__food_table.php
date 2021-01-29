<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibraryFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_food', function (Blueprint $table) {
            
            $table->bigInteger('library_id')->unsigned();            
            $table->bigInteger('food_id')->unsigned();            

            $table->timestamps();
        });

        Schema::table('favourite_food', function(Blueprint $table){   

            $table->foreign('library_id')->references('id')->on('libraries')->onDelete('cascade');

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
        Schema::dropIfExists('library_food');
    }
}
