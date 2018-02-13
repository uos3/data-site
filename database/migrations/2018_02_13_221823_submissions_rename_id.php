<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubmissionsRenameId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('submissions', function (Blueprint $table) {
        $table->renameColumn('submission_id','id');
      });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

      Schema::table('submissions', function (Blueprint $table) {
        $table->renameColumn('id','submission_id');
      });

    }
}
