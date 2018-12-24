<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenamePayloadSequenceColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('sat_status', function ($table) {
        $table->renameColumn('sequence_id', 'beacon_id');
      });
      Schema::table('sat_config', function ($table) {
        $table->renameColumn('sequence_id', 'dataset_id');
      });
      Schema::table('sat_gps', function ($table) {
        $table->renameColumn('sequence_id', 'dataset_id');
      });
      Schema::table('sat_health', function ($table) {
        $table->renameColumn('sequence_id', 'dataset_id');
      });
      Schema::table('sat_img', function ($table) {
        $table->renameColumn('sequence_id', 'dataset_id');
      });
      Schema::table('sat_imu', function ($table) {
        $table->renameColumn('sequence_id', 'dataset_id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // internet said no reversing. I will just make a new migration on top.
    }
}
