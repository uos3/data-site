<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveScoresToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('scores');
        
        Schema::table('users', function (Blueprint $table) {
			$table->unsignedInteger('upload_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('user_id');
			$table->unsignedInteger('upload_count');
        });
        
        Schema::table('users', function (Blueprint $table) {
			$table->dropColumn(['upload_count']);
            //
        });
    }
}
