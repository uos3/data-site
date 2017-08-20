<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Helpers\Helper;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
	
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
    	$this->redirectTo = '/';
		
		$confirmation_code = str_random(30);
		
		$user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'submit_key' => Helper::makeUniqueSubmitKey(),
            'confirmation_code'=>$confirmation_code
        ]);
		
		Mail::send('auth.emails.verify',['confirmation_code'=>$confirmation_code],function($message) use ($data) {
			$message->to($data['email'])->subject('Verify your email adress');
		});
		return $user;
    }
	
	protected function getCredentials(Request $request)
    {
        $c = $request->only($this->loginUsername(), 'password');
        return array_merge($c, ['confirmed' => true]);
    }
	
	
	/**
     * Handle a login request to the application.
	 * 
	 * CHANGED: added logic for checking if email has been confirmed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
    	
		$this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
				
		$user = User::where('email',$request->input('email'))->first();
		
		if (! $user) {
			return $this->sendFailedLoginResponse($request); //might as well.
		} elseif (! $user->confirmed) {
			return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                'confirmed'=>'You need to confirm your email address before you can use your account.',
            ]);
		}

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }
	        
	
	/**
     * Handle a registration request for the application.
	 * 
	 * CHANGED: user not logged in after registration (we're waiting for email confirmation)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
		
		$this->create($request->all());
				
        return redirect('/register')->with('form_success','Just one more step! Please check your inbox and verify your email address.');
    }
}
