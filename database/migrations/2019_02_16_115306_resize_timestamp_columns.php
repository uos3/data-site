<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResizeTimestampColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('sat_gps', function ($table) {
        $table->bigInteger("time")->change();
        $table->bigInteger("gps_time")->change();
      });
      Schema::table('sat_imu', function ($table) {
        $table->bigInteger("timestamp")->change();
      });
      Schema::table('sat_health', function ($table) {
        $table->bigInteger("timestamp")->change();
      });
      Schema::table('sat_img', function ($table) {
        $table->bigInteger("timestamp")->change();
      });
      Schema::table('sat_config', function ($table) {
        $table->bigInteger("time")->change();
      });
      Schema::table('sat_status', function ($table) {
        $table->bigInteger("time")->change();
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
