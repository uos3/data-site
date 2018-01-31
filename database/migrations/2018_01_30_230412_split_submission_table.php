<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SplitSubmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      //Drop current submissions table. CAUTION.
      Schema::dropIfExists('submissions');

      //Recreate submissions table.
      Schema::create('submissions',function (Blueprint $table) {
        $table->increments('id')->unique();
        $table->timestamp('server_time'); //set on save
        $table->integer('user_id')->unsigned()->nullable();
        $table->timestamp('downlink_time');
        $table->string('ip_address',45);
        $table->mediumInteger('sequence_id')->unsigned();
        $table->string('payload_type',1);
      });

      Schema::create('sat_status',function (Blueprint $table) {
        $table->integer('submission_id')->unsigned()->unique();
        $table->timestamp('downlink_time');
        $table->timestamp('spacecraft_time');
        $table->boolean('time_source')->nullable();
        $table->string('spacecraft_id')->nullable(); //SCID -- do we even need this in the database..?
        $table->decimal('obc_temperature',10,4)->nullable();
        $table->decimal('battery_temperature',10,4)->nullable();
        $table->decimal('battery_voltage',10,4)->nullable();
        $table->decimal('battery_current',10,4)->nullable();
        $table->decimal('charge_current',10,4)->nullable();
        $table->boolean('antenna_deployment')->nullable();
        $table->integer('data_pending')->unsigned();
        $table->integer('reboot_count')->unsigned();
        $table->string('rails_status',6)->nullable();
        $table->smallInteger('rx_temperature')->nullable();
        $table->smallInteger('tx_temperature')->nullable();
        $table->smallInteger('pa_temperature')->nullable();
        $table->decimal('rx_noisefloor',10,4)->nullable();
      });


      Schema::create('sat_health',function (Blueprint $table) {
        $table->integer('submission_id')->unsigned()->unique();
        $table->integer('timestamp')->unsigned();

        $table->decimal('obc_temperature',10,4)->nullable();
        $table->smallInteger('rx_temperature')->nullable();
        $table->smallInteger('tx_temperature')->nullable();
        $table->smallInteger('pa_temperature')->nullable();
        $table->integer('reboot_count')->unsigned()->nullable();
        $table->integer('data_packets_pending')->unsigned()->nullable();
        $table->boolean('antenna_switch')->nullable();
        $table->decimal('rx_noisefloor',10,4)->nullable();
        $table->integer('detected_flash_errors')->unsigned()->nullable();
        $table->integer('detected_ram_errors')->unsigned()->nullable();
        $table->decimal('battery_temperature',10,4)->nullable();
        $table->decimal('battery_voltage',10,4)->nullable();
        $table->decimal('battery_current',10,4)->nullable();
        $table->decimal('charge_current',10,4)->nullable();
        $table->decimal('mppt_voltage',10,4)->nullable();
        $table->decimal('solar_n1_current',10,4)->nullable();
        $table->decimal('solar_n2_current',10,4)->nullable();
        $table->decimal('solar_e1_current',10,4)->nullable();
        $table->decimal('solar_e2_current',10,4)->nullable();
        $table->decimal('solar_s1_current',10,4)->nullable();
        $table->decimal('solar_s2_current',10,4)->nullable();
        $table->decimal('solar_w1_current',10,4)->nullable();
        $table->decimal('solar_w2_current',10,4)->nullable();
        $table->decimal('solar_t1_current',10,4)->nullable();
        $table->decimal('solar_t2_current',10,4)->nullable();
        $table->string('rails_switch_status',6)->nullable();
        $table->string('rails_overcurrent_status',6)->nullable();
        $table->integer('rail_1_boot_count')->unsigned()->nullable();
        $table->integer('rail_1_overcurrent_count')->unsigned()->nullable();
        $table->decimal('rail_1_voltage',10,4)->nullable();
        $table->decimal('rail_1_current',10,4)->nullable();
        $table->integer('rail_2_boot_count')->unsigned()->nullable();
        $table->integer('rail_2_overcurrent_count')->unsigned()->nullable();
        $table->decimal('rail_2_voltage',10,4)->nullable();
        $table->decimal('rail_2_current',10,4)->nullable();
        $table->integer('rail_3_boot_count')->unsigned()->nullable();
        $table->integer('rail_3_overcurrent_count')->unsigned()->nullable();
        $table->decimal('rail_3_voltage',10,4)->nullable();
        $table->decimal('rail_3_current',10,4)->nullable();
        $table->integer('rail_4_boot_count')->unsigned()->nullable();
        $table->integer('rail_4_overcurrent_count')->unsigned()->nullable();
        $table->decimal('rail_4_voltage',10,4)->nullable();
        $table->decimal('rail_4_current',10,4)->nullable();
        $table->integer('rail_5_boot_count')->unsigned()->nullable();
        $table->integer('rail_5_overcurrent_count')->unsigned()->nullable();
        $table->decimal('rail_5_voltage',10,4)->nullable();
        $table->decimal('rail_5_current',10,4)->nullable();
        $table->integer('rail_6_boot_count')->unsigned()->nullable();
        $table->integer('rail_6_overcurrent_count')->unsigned()->nullable();
        $table->decimal('rail_6_voltage',10,4)->nullable();
        $table->decimal('rail_6_current',10,4)->nullable();
        $table->decimal('3v3_voltage',10,4)->nullable();
        $table->decimal('3v3_current',10,4)->nullable();
        $table->decimal('5v_voltage',10,4)->nullable();
        $table->decimal('5v_current',10,4)->nullable();
      });


      Schema::create('sat_imu',function (Blueprint $table) {
        $table->integer('submission_id')->unsigned()->unique();
        $table->integer('timestamp')->unsigned();

        $table->decimal('mag_x',10,4)->nullable();
        $table->decimal('mag_y',10,4)->nullable();
        $table->decimal('mag_z',10,4)->nullable();
        $table->decimal('gyro_x',10,4)->nullable();
        $table->decimal('gyro_y',10,4)->nullable();
        $table->decimal('gyro_z',10,4)->nullable();
        $table->decimal('accel_x',10,4)->nullable();
        $table->decimal('accel_y',10,4)->nullable();
        $table->decimal('accel_z',10,4)->nullable();
      });


      Schema::create('sat_gps',function (Blueprint $table) {
        $table->integer('submission_id')->unsigned()->unique();
        $table->integer('timestamp')->unsigned();

        $table->decimal('lat',10,4)->nullable();
        $table->decimal('lon',10,4)->nullable();
        $table->decimal('alt',10,4)->nullable();
        $table->decimal('hdop',10,4)->nullable();
        $table->decimal('vdop',10,4)->nullable();
        $table->decimal('pdop',10,4)->nullable();
        $table->decimal('tdop',10,4)->nullable();
      });

      Schema::create('sat_img',function (Blueprint $table) {
        $table->integer('submission_id')->unsigned()->unique();
        $table->integer('timestamp')->unsigned();

        $table->integer('image_id')->unsigned()->nullable();
        $table->integer('fragment_id')->unsigned()->nullable();
        $table->integer('number_of_fragments')->unsigned()->nullable();
        $table->text('image_data')->nullable(); //probably base64
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('submissions');
      Schema::dropIfExists('sat_status');
      Schema::dropIfExists('sat_health');
      Schema::dropIfExists('sat_gps');
      Schema::dropIfExists('sat_img');
      Schema::dropIfExists('sat_imu');
      Schema::dropIfExists('sat_img');

      Schema::create('submissions', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamp('uploaded_at');
          $table->integer('user_id')->unsigned();

          $table->decimal('battery_voltage', 6, 3);
    			$table->decimal('battery_current', 6, 3);
    			$table->decimal('battery_temperature', 6, 3);
    			$table->decimal('charge_current', 6, 3);
    			$table->decimal('mppt_voltage', 6, 3);
    			$table->decimal('solar_n1_current', 6, 3);
    			$table->decimal('solar_n2_current', 6, 3);
    			$table->decimal('solar_e1_current', 6, 3);
    			$table->decimal('solar_e2_current', 6, 3);
    			$table->decimal('solar_s1_current', 6, 3);
    			$table->decimal('solar_s2_current', 6, 3);
    			$table->decimal('solar_w1_current', 6, 3);
    			$table->decimal('solar_w2_current', 6, 3);
    			$table->decimal('solar_t1_current', 6, 3);
    			$table->decimal('solar_t2_current', 6, 3);
    			$table->decimal('rails_switch_status', 6, 3);
    			$table->decimal('rails_overcurrent_status', 6, 3);
    			$table->decimal('rail_1_boot_count', 6, 3);
    			$table->decimal('rail_1_overcurrent_count', 6, 3);
    			$table->decimal('rail_1_voltage', 6, 3);
    			$table->decimal('rail_1_current', 6, 3);
    			$table->decimal('rail_2_boot_count', 6, 3);
    			$table->decimal('rail_2_overcurrent_count', 6, 3);
    			$table->decimal('rail_2_voltage', 6, 3);
    			$table->decimal('rail_2_current', 6, 3);
    			$table->decimal('rail_3_boot_count', 6, 3);
    			$table->decimal('rail_3_overcurrent_count', 6, 3);
    			$table->decimal('rail_3_voltage', 6, 3);
    			$table->decimal('rail_3_current', 6, 3);
    			$table->decimal('rail_4_boot_count', 6, 3);
    			$table->decimal('rail_4_overcurrent_count', 6, 3);
    			$table->decimal('rail_4_voltage', 6, 3);
    			$table->decimal('rail_4_current', 6, 3);
    			$table->decimal('rail_5_boot_count', 6, 3);
    			$table->decimal('rail_5_overcurrent_count', 6, 3);
    			$table->decimal('rail_5_voltage', 6, 3);
    			$table->decimal('rail_5_current', 6, 3);
    			$table->decimal('rail_6_boot_count', 6, 3);
    			$table->decimal('rail_6_overcurrent_count', 6, 3);
    			$table->decimal('rail_6_voltage', 6, 3);
    			$table->decimal('rail_6_current', 6, 3);
    			$table->decimal('3v3_voltage', 6, 3);
    			$table->decimal('3v3_current', 6, 3);
    			$table->decimal('5v_voltage', 6, 3);
    			$table->decimal('5v_current', 6, 3);
      });
      //there is no damn point to roll this back.
    }
}
