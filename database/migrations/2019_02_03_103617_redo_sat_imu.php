<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedoSatImu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('sat_imu');
      Schema::create('sat_imu',function (Blueprint $table) {
        $table->increments('id')->unique();
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('dataset_id')->unsigned();
        $table->integer('timestamp')->unsigned()->nullable();
        $table->integer('mag_x')->nullable();
        $table->integer('mag_y')->nullable();
        $table->integer('mag_z')->nullable();
        $table->integer('gyro_x')->nullable();
        $table->integer('gyro_y')->nullable();
        $table->integer('gyro_z')->nullable();
        $table->integer('accel_x')->nullable();
        $table->integer('accel_y')->nullable();
        $table->integer('accel_z')->nullable();
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
