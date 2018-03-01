<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveSequenceIdColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * The sequence_id is per data packet section, not per packet.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('submissions', function (Blueprint $table) {
        $table->dropColumn('sequence_id');
      });

      Schema::table('sat_status', function (Blueprint $table) {
        $table->integer('sequence_id');
        $table->increments('id')->unique();
        $table->dropColumn('submission_id');
      });
      Schema::table('sat_gps', function (Blueprint $table) {
        $table->integer('sequence_id');
        $table->increments('id')->unique();
        $table->dropColumn('submission_id');
      });
      Schema::table('sat_img', function (Blueprint $table) {
        $table->integer('sequence_id');
        $table->increments('id')->unique();
        $table->dropColumn('submission_id');
      });
      Schema::table('sat_imu', function (Blueprint $table) {
        $table->integer('sequence_id');
        $table->increments('id')->unique();
        $table->dropColumn('submission_id');
      });
      Schema::table('sat_health', function (Blueprint $table) {
        $table->integer('sequence_id');
        $table->increments('id')->unique();
        $table->dropColumn('submission_id');
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
        $table->integer('sequence_id');
        $table->integer('submission_id')->unique();
        $table->dropColumn('id');
      });

      Schema::table('sat_status', function (Blueprint $table) {
        $table->dropColumn('sequence_id');
        $table->integer('submission_id')->unique();
        $table->dropColumn('id');
      });
      Schema::table('sat_gps', function (Blueprint $table) {
        $table->dropColumn('sequence_id');
        $table->integer('submission_id')->unique();
        $table->dropColumn('id');
      });
      Schema::table('sat_img', function (Blueprint $table) {
        $table->dropColumn('sequence_id');
        $table->integer('submission_id')->unique();
        $table->dropColumn('id');
      });
      Schema::table('sat_imu', function (Blueprint $table) {
        $table->dropColumn('sequence_id');
        $table->integer('submission_id')->unique();
        $table->dropColumn('id');
      });
      Schema::table('sat_health', function (Blueprint $table) {
        $table->dropColumn('sequence_id');
        $table->integer('submission_id')->unique();
        $table->dropColumn('id');
      });
        //
    }
}
