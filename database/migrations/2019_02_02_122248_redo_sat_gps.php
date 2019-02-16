<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedoSatGps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('sat_gps');
      Schema::create('sat_gps',function (Blueprint $table) {
        $table->increments('id')->unique();
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('dataset_id')->unsigned();
        $table->integer('time')->unsigned()->nullable(); //this might have to change. Possibly add a mutator on this to get a date object out of the db?
        $table->integer('gps_time')->unsigned()->nullable(); //this might have to change too
        $table->decimal('lat',10,4)->nullable();
        $table->decimal('lon',10,4)->nullable();
        $table->decimal('alt',10,4)->nullable();
        $table->integer('hdop')->nullable();
        $table->integer('vdop')->nullable();
        $table->integer('pdop')->nullable();
        $table->integer('tdop')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
