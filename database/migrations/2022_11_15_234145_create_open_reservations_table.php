<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('open_reservations');

        Schema::create('open_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games');
            $table->unsignedBigInteger('game_category_id');
            $table->foreign('game_category_id')->references('id')->on('game_categories');
            $table->unsignedBigInteger('game_subcategory_id')->nullable();
            $table->foreign('game_subcategory_id')->references('id')->on('game_subcategories');
            $table->integer('max_people');
            $table->integer('min_people');
            $table->integer('actual_people');
            $table->date('date');
            $table->time('hour');
            $table->decimal('price_per_user');
            $table->boolean('closed');
            $table->boolean('paid');
            $table->boolean('confirmed');
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
        Schema::dropIfExists('open_reservations');
    }
}
