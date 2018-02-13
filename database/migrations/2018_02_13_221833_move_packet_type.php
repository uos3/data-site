<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MovePacketType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('submissions', function (Blueprint $table) {
        $table->dropColumn('payload_type');
      });
      Schema::table('packets', function (Blueprint $table) {
        $table->string('payload_type',1);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('packets', function (Blueprint $table) {
        $table->dropColumn('payload_type');
      });
      Schema::table('submissions', function (Blueprint $table) {
        $table->string('payload_type',1);
      });
    }
}
