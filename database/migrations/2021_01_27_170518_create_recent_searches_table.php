<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recent_searches', function (Blueprint $table) {
            
            $table->bigInteger('search_id')->unsigned();            

            $table->timestamps();
        });

        Schema::table('recent_searches', function(Blueprint $table){   

            $table->foreign('search_id')->references('id')->on('searches')->onDelete('cascade');
        
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recent_searches');
    }
}
