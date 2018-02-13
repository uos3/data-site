<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubmissionAddPacketEtc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('submissions', function (Blueprint $table) {
        $table->integer('packet_id')->unique();
        $table->boolean('checksum_success')->default(FALSE);
      });
      //checksum_success (if 0, no packet or sat_ tables populated - only as reference)
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submissions', function (Blueprint $table) {
          $table->dropColumn(['packet_id','checksum_success']);
        });
    }
}
