<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RedoSatImg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('sat_img');
      Schema::create('sat_img',function (Blueprint $table) {
        $table->increments('id')->unique();
        $table->integer('packet_id')->unsigned()->unique();
        $table->integer('dataset_id')->unsigned();
        $table->integer('timestamp')->unsigned()->nullable();

        $table->integer('image_id')->unsigned()->nullable();
        $table->integer('fragment_id')->unsigned()->nullable();
        $table->integer('number_of_fragments')->unsigned()->nullable();
        $table->text('image_data')->nullable(); //probably base64? this might need to change
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
