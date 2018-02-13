<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PacketIdToSatTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('sat_status', function (Blueprint $table) {
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('sequence_id')->unsigned()->change();
      });
      Schema::table('sat_gps', function (Blueprint $table) {
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('sequence_id')->unsigned()->change();
      });
      Schema::table('sat_img', function (Blueprint $table) {
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('sequence_id')->unsigned()->change();
      });
      Schema::table('sat_imu', function (Blueprint $table) {
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('sequence_id')->unsigned()->change();
      });
      Schema::table('sat_health', function (Blueprint $table) {
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('sequence_id')->unsigned()->change();
      });

      Schema::table('sat_config', function (Blueprint $table) {
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('sequence_id')->unsigned()->change();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('sat_status', function (Blueprint $table) {
        $table->dropColumn('packet_id');
      });

      Schema::table('sat_gps', function (Blueprint $table) {
        $table->dropColumn('packet_id');
      });
      Schema::table('sat_img', function (Blueprint $table) {
        $table->dropColumn('packet_id');
      });
      Schema::table('sat_imu', function (Blueprint $table) {
        $table->dropColumn('packet_id');
      });
      Schema::table('sat_health', function (Blueprint $table) {
        $table->dropColumn('packet_id');
      });

      Schema::table('sat_config', function (Blueprint $table) {
        $table->dropColumn('packet_id');
      });
    }
}
