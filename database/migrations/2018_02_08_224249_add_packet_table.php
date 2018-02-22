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
          $table->integer('status_table_id')->unsigned()->unique();
          $table->integer('status_sequence_id')->unsigned();
          $table->integer('health_table_id')->unsigned()->unique()->nullable();
          $table->integer('health_sequence_id')->unsigned()->nullable();
          $table->integer('imu_table_id')->unsigned()->unique()->nullable();
          $table->integer('imu_sequence_id')->unsigned()->nullable();
          $table->integer('img_table_id')->unsigned()->unique()->nullable();
          $table->integer('img_sequence_id')->unsigned()->nullable();
          $table->integer('gps_table_id')->unsigned()->unique()->nullable();
          $table->integer('gps_sequence_id')->unsigned()->nullable();
          $table->integer('config_table_id')->unsigned()->unique()->nullable();
          $table->integer('config_sequence_id')->unsigned()->nullable();
          $table->timestamp('last_submitted')->useCurrent();
          $table->string('checksum');
          $table->string('hash');
          //checksum
          //hash

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packets');
    }
}
