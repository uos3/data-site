<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPacketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packets',function (Blueprint $table) {
          $table->increments('id')->unique();
          //status_table_id
          //status_sequence_id
          //health_table_id
          //health_sequence_id
          //imu_table_id
          //imu_sequence_id
          //img_table_id
          //img_sequence_id
          //gps_table_id
          //gps_sequence_id
          //config_table_id
          //config_sequence_id
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
