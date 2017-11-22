<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySubmissionsDataColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submissions', function (Blueprint $table) {
			//drop all fake data columns
			$table->dropColumn(['cubesat_time','temperature','gyro_x','gyro_y','gyro_z','accelerometer_x','accelerometer_y','accelerometer_z']);
			
			//create all new fake data columns
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
			
			
			//TODO: reference to image uploads? filename? just a flag that image was uploaded?
			//TODO: GNSS values columns?
			//TODO: magnetometer values columns?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submissions', function (Blueprint $table) {
			//recreate old
			$table->timestamp('cubesat_time');
			$table->float('temperature');
			$table->float('gyro_x');
			$table->float('gyro_y');
			$table->float('gyro_z');
			$table->float('accelerometer_x');
			$table->float('accelerometer_y');
			$table->float('accelerometer_z');
			
			//drop new	
			$table->dropColumn('battery_voltage');
			$table->dropColumn('battery_current');
			$table->dropColumn('battery_temperature');
			$table->dropColumn('charge_current');
			$table->dropColumn('mppt_voltage');
			$table->dropColumn('solar_n1_current');
			$table->dropColumn('solar_n2_current');
			$table->dropColumn('solar_e1_current');
			$table->dropColumn('solar_e2_current');
			$table->dropColumn('solar_s1_current');
			$table->dropColumn('solar_s2_current');
			$table->dropColumn('solar_w1_current');
			$table->dropColumn('solar_w2_current');
			$table->dropColumn('solar_t1_current');
			$table->dropColumn('solar_t2_current');
			$table->dropColumn('rails_switch_status');
			$table->dropColumn('rails_overcurrent_status');
			$table->dropColumn('rail_1_boot_count');
			$table->dropColumn('rail_1_overcurrent_count');
			$table->dropColumn('rail_1_voltage');
			$table->dropColumn('rail_1_current');
			$table->dropColumn('rail_2_boot_count');
			$table->dropColumn('rail_2_overcurrent_count');
			$table->dropColumn('rail_2_voltage');
			$table->dropColumn('rail_2_current');
			$table->dropColumn('rail_3_boot_count');
			$table->dropColumn('rail_3_overcurrent_count');
			$table->dropColumn('rail_3_voltage');
			$table->dropColumn('rail_3_current');
			$table->dropColumn('rail_4_boot_count');
			$table->dropColumn('rail_4_overcurrent_count');
			$table->dropColumn('rail_4_voltage');
			$table->dropColumn('rail_4_current');
			$table->dropColumn('rail_5_boot_count');
			$table->dropColumn('rail_5_overcurrent_count');
			$table->dropColumn('rail_5_voltage');
			$table->dropColumn('rail_5_current');
			$table->dropColumn('rail_6_boot_count');
			$table->dropColumn('rail_6_overcurrent_count');
			$table->dropColumn('rail_6_voltage');
			$table->dropColumn('rail_6_current');
			$table->dropColumn('3v3_voltage');
			$table->dropColumn('3v3_current');
			$table->dropColumn('5v_voltage');
			$table->dropColumn('5v_current');
            //
        });		
    }
}
