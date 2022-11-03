<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('game_id');
            $table->foreign('game_id')->references('id')->on('game');
            $table->decimal('price');
            $table->people('number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_prices');
    }
}
