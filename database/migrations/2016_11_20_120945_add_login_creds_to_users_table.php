<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLoginCredsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
        	$table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
			$table->string('submit_key')->unique()->nullable()->default(NULL);
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
        	$table->dropColumn(['name', 'email', 'password','remember_token','submit_key']);
            //
        });
    }
}
