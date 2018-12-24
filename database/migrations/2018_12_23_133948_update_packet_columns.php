<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePacketColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('packets', function ($table) {
        $table->renameColumn('status_sequence_id', 'beacon_id');
        $table->renameColumn('checksum', 'crc');
        $table->renameColumn('payload_type', 'type');
        $table->integer('dataset_id')->unsigned();
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
