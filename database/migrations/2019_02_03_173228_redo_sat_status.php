<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedoSatStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('sat_status');
      Schema::create('sat_status',function (Blueprint $table) {
        $table->increments('id')->unique();
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('beacon_id')->unsigned();
        $table->string('spacecraft_id')->nullable(); //SCID -- do we even need this in the database..?
        $table->integer('time')->unsigned()->nullable(); //this comes from the sat
        $table->boolean('time_source')->nullable();
        $table->integer('downlink_time')->unsigned()->nullable(); //judging from the code this should come from the telemetry-app
        $table->integer('obc_temperature')->nullable();
        $table->integer('battery_temperature')->nullable();
        $table->integer('battery_voltage')->nullable();
        $table->integer('battery_current')->unsigned()->nullable();
        $table->boolean('antenna_deployment')->nullable();
        $table->integer('operational_mode')->unsigned()->nullable();
        $table->integer('data_pending')->unsigned()->nullable();
        $table->integer('reboot_count')->unsigned()->nullable();
        $table->string('rails_status',6)->nullable();
        $table->integer('rx_temperature')->nullable();
        $table->integer('tx_temperature')->nullable();
        $table->integer('pa_temperature')->nullable();
        $table->integer('rx_noisefloor')->unsigned()->nullable();
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
