<?php
namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller {

    public function confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return redirect('/');	
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
			return redirect('/')->with('error','No user account to activate with this link.');
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();
		
		Auth::guard()->login($user);		

        return redirect('/profile')->with('success','You have successfully verified your account.');
    }
}