<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePacketSequenceColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('packets', function ($table) {
        $table->dropColumn('health_sequence_id');
        $table->dropColumn('imu_sequence_id');
        $table->dropColumn('img_sequence_id');
        $table->dropColumn('gps_sequence_id');
        $table->dropColumn('config_sequence_id');
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
