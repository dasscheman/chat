<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDilemmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('dilemmas', function (Blueprint $table) {
                $table->increments('id');
                $table->text('naam');
                $table->text('dilemma');
                $table->text('goed');
                $table->text('fout');
                $table->integer('status')->unsigned();
                $table->timestamps();
            });
            Schema::create('dilemma_uitkomsts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('dilemma_id')->unsigned();
                $table->integer('user_id_sender')->unsigned();
                $table->integer('user_id_receiver')->unsigned();
                $table->integer('status');
                $table->integer('choise');
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
        Schema::dropIfExists('dillemma');
        Schema::dropIfExists('dillemma_uitkomst');
    }
}
