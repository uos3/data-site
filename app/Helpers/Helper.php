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
	
	/**
	 * Get user's position on leaderboard.
	 * 
	 * @param User $user
	 * @return int
	 */
	public static function getLeaderboardPos(User $user) {
		return 0;
	}
}


?>