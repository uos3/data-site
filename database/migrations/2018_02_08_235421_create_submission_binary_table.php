<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionBinaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('submissions_binary', function (Blueprint $table) {
        $table->integer('submission_id')->unique();
        $table->binary('data');
      });
        //submission_id (unique)
        //data
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('submissions_binary');
        //
    }
}
