<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->increments('id');
			$table->timestamp('uploaded_at');
			$table->integer('user_id')->unsigned();
			$table->timestamp('cubesat_time');
			$table->float('temperature');
			$table->float('gyro_x');
			$table->float('gyro_y');
			$table->float('gyro_z');
			$table->float('accelerometer_x');
			$table->float('accelerometer_y');
			$table->float('accelerometer_z');
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
        Schema::drop('submissions');
    }
}
