<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNicknameToNotNullable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			foreach (\App\Models\User::all() as $user) {
				if ($user->nickname == null) {
					$user->nickname = str_random(20);
					$user->save();
				}
			}
			$table->string('nickname', 20)->nullable(false)->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table) {
			//
		});
	}
}
