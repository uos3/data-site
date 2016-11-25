<?php

namespace App\Helpers;

use App\User;

class Helper
{
	public static function makeUniqueSubmitKey() {
		$key = '';
		
		do {
			$key = str_random(40);
		} while (User::where("submit_key", "=", $key)->first() instanceof User);
		
		return $key;
	}
}


?>