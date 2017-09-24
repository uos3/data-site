<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class UserAreaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); //middleware restricts. 'guest' means it's just for guests, 'auth' means it's just for authenticated users.
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
    	$user = Auth::user();
		$leaderboard_position = Helper::getLeaderboardPos($user);
        return view('user.profile',['user'=>$user,'leaderboard_position'=>$leaderboard_position]);
    }
}
