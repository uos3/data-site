<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSatConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('sat_config', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('sequence_id')->unsigned();

        $table->boolean('tx_enable')->nullable();
        $table->integer('tx_interval_beacon')->unsigned()->nullable();
        $table->integer('tx_interval_downlink')->unsigned()->nullable();
        $table->tinyInteger('tx_datarate')->unsigned()->nullable(); //spec says "enumerated" but Laravel has issues with enum
        $table->tinyInteger('tx_packet_size')->unsigned()->nullable();
        $table->integer('tx_power')->unsigned()->nullable();
        $table->integer('tx_warning_power')->unsigned()->nullable();
        $table->integer('tx_warning_threshold')->nullable();
        $table->decimal('low_voltage_threshold',10,4)->nullable();
        $table->decimal('low_voltage_recovery_threshold',10,4)->nullable();
        $table->integer('power_stats_acquisition_interval')->unsigned()->nullable();
        $table->integer('configuration_acquisition_interval')->unsigned()->nullable();
        $table->integer('imu_acquisition_interval')->unsigned()->nullable();
        $table->integer('gps_acquisition_interval')->unsigned()->nullable();
        $table->integer('image_acquisition_time')->unsigned()->nullable();
        $table->tinyInteger('image_acquisition_profile')->unsigned()->nullable();
        $table->integer('imu_acquisition_number')->unsigned()->nullable();
        $table->integer('greetings_message_transmission_interval')->unsigned()->nullable();
        $table->boolean('enable_gps_time_sync');
        $table->tinyInteger('imu_bandwidth')->unsigned()->nullable();
        $table->integer('gps_sample_count')->unsigned()->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sat_config');
    }
}
