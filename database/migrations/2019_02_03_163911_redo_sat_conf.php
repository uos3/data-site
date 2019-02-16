<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedoSatConf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sat_config');
        Schema::create('sat_config',function (Blueprint $table) {
          $table->increments('id')->unique();
          $table->integer('packet_id')->unsigned()->unique();
          $table->integer('dataset_id')->unsigned();

          $table->boolean('tx_enable')->nullable();
          $table->integer('tx_interval')->unsigned()->nullable();
          $table->integer('tx_interval_downlink')->unsigned()->nullable();
          $table->decimal('tx_datarate',10,2)->nullable(); //logic - the spec calls for an enumerated data type, but gives no options. but it states kbps values with 2 decimal spaces. so hopefully this will capture most options. possibly change once telemetry-app is finished.
          $table->integer('tx_power')->unsigned()->nullable();
          $table->integer('tx_overtemp')->unsigned()->nullable();
          $table->integer('rx_overtemp')->unsigned()->nullable();
          $table->integer('batt_overtemp')->unsigned()->nullable();
          $table->integer('obc_overtemp')->unsigned()->nullable();
          $table->integer('pa_overtemp')->unsigned()->nullable();
          $table->integer('low_voltage_threshold')->nullable();
          $table->integer('low_voltage_recovery')->nullable();
          $table->integer('health_acquisition_interval')->unsigned()->nullable();
          $table->integer('configuration_acquisition_interval')->unsigned()->nullable();
          $table->integer('imu_acquisition_interval')->unsigned()->nullable();
          $table->integer('imu_sample_count')->unsigned()->nullable();
          $table->integer('imu_sample_interval')->unsigned()->nullable();
          $table->integer('gps_acquisition_interval')->unsigned()->nullable();
          $table->integer('gps_sample_count')->unsigned()->nullable();
          $table->integer('gps_sample_interval')->unsigned()->nullable();
          $table->integer('image_acquisition_time')->unsigned()->nullable();
          $table->integer('image_acquisition_profile')->unsigned()->nullable();
          $table->integer('time')->unsigned()->nullable();
          $table->integer('operational_mode')->unsigned()->nullable();
          $table->integer('self_test')->unsigned()->nullable();
          $table->boolean('power_rail_1')->nullable();
          $table->boolean('power_rail_2')->nullable();
          $table->boolean('power_rail_3')->nullable();
          $table->boolean('power_rail_4')->nullable();
          $table->boolean('power_rail_5')->nullable();
          $table->boolean('power_rail_6')->nullable();
          $table->boolean('reset_power_rail_1')->nullable();
          $table->boolean('reset_power_rail_2')->nullable();
          $table->boolean('reset_power_rail_3')->nullable();
          $table->boolean('reset_power_rail_4')->nullable();
          $table->boolean('reset_power_rail_5')->nullable();
          $table->boolean('reset_power_rail_6')->nullable();
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
