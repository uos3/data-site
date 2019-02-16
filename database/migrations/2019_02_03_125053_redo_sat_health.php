<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedoSatHealth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('sat_health');
      Schema::create('sat_health',function (Blueprint $table) {
        $table->increments('id')->unique();
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('dataset_id')->unsigned();
        $table->integer('timestamp')->unsigned()->nullable();
        $table->integer('obc_temperature')->nullable();
        $table->integer('rx_temperature')->nullable();
        $table->integer('tx_temperature')->nullable();
        $table->integer('pa_temperature')->nullable();
        $table->integer('reboot_count')->unsigned()->nullable();
        $table->integer('data_packets_pending')->unsigned()->nullable();
        $table->boolean('antenna_switch')->nullable();
        $table->integer('rx_noisefloor')->unsigned()->nullable();
        $table->integer('detected_flash_errors')->unsigned()->nullable();
        $table->integer('detected_ram_errors')->unsigned()->nullable();
        $table->integer('battery_voltage')->nullable();
        $table->integer('battery_current')->unsigned()->nullable();
        $table->integer('battery_temperature')->nullable();
        $table->integer('charge_current')->unsigned()->nullable();
        $table->integer('mppt_voltage')->nullable();
        $table->integer('solar_n1_current')->unsigned()->nullable();
        $table->integer('solar_n2_current')->unsigned()->nullable();
        $table->integer('solar_e1_current')->unsigned()->nullable();
        $table->integer('solar_e2_current')->unsigned()->nullable();
        $table->integer('solar_s1_current')->unsigned()->nullable();
        $table->integer('solar_s2_current')->unsigned()->nullable();
        $table->integer('solar_w1_current')->unsigned()->nullable();
        $table->integer('solar_w2_current')->unsigned()->nullable();
        $table->integer('solar_t1_current')->unsigned()->nullable();
        $table->integer('solar_t2_current')->unsigned()->nullable();
        $table->string('rails_switch_status',6)->nullable();
        $table->string('rails_overcurrent_status',6)->nullable();
        $table->integer('rail_1_boot_count')->unsigned()->nullable();
        $table->integer('rail_1_overcurrent_count')->unsigned()->nullable();
        $table->integer('rail_1_voltage')->nullable();
        $table->integer('rail_1_current')->nullable();
        $table->integer('rail_2_boot_count')->unsigned()->nullable();
        $table->integer('rail_2_overcurrent_count')->unsigned()->nullable();
        $table->integer('rail_2_voltage')->nullable();
        $table->integer('rail_2_current')->unsigned()->nullable();
        $table->integer('rail_3_boot_count')->unsigned()->nullable();
        $table->integer('rail_3_overcurrent_count')->unsigned()->nullable();
        $table->integer('rail_3_voltage')->nullable();
        $table->integer('rail_3_current')->unsigned()->nullable();
        $table->integer('rail_4_boot_count')->unsigned()->nullable();
        $table->integer('rail_4_overcurrent_count')->unsigned()->nullable();
        $table->integer('rail_4_voltage')->nullable();
        $table->integer('rail_4_current')->unsigned()->nullable();
        $table->integer('rail_5_boot_count')->unsigned()->nullable();
        $table->integer('rail_5_overcurrent_count')->unsigned()->nullable();
        $table->integer('rail_5_voltage')->nullable();
        $table->integer('rail_5_current')->unsigned()->nullable();
        $table->integer('rail_6_boot_count')->unsigned()->nullable();
        $table->integer('rail_6_overcurrent_count')->unsigned()->nullable();
        $table->integer('rail_6_voltage')->nullable();
        $table->integer('rail_6_current')->unsigned()->nullable();
        $table->integer('3v3_voltage')->nullable();
        $table->integer('3v3_current')->unsigned()->nullable();
        $table->integer('5v_voltage')->nullable();
        $table->integer('5v_current')->unsigned()->nullable();
        $table->boolean('eeprom_subsystem_ok')->nullable();
        $table->boolean('fram_subsystem_ok')->nullable();
        $table->boolean('camera_subsystem_ok')->nullable();
        $table->boolean('gps_subsystem_ok')->nullable();
        $table->boolean('imu_subsystem_ok')->nullable();
        $table->boolean('transmitter_subsystem_ok')->nullable();
        $table->boolean('receiver_subsystem_ok')->nullable();
        $table->boolean('eps_subsystem_ok')->nullable();
        $table->boolean('battery_subsystem_ok')->nullable();
        $table->boolean('obc_tempsensor_ok')->nullable();
        $table->boolean('pa_tempsensor_ok')->nullable();
        $table->boolean('rx_tempsensor_ok')->nullable();
        $table->boolean('tx_tempsensor_ok')->nullable();
        $table->boolean('batt_tempsensor_ok')->nullable();
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
