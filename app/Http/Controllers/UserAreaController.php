<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\User;

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
    public function index()
    {
		$user = Auth::user();
		return view('user.profile',['user'=>$user]);
    }
    
    
    /**
     * Save profile form
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
    	$user = Auth::user();
    	
    	$fields = [
			'name'=> $this->oldOrNew($request,$user,'name'),
			'affiliation'=> $this->oldOrNew($request,$user,'affiliation'),
			'public'=> $this->oldOrNew($request,$user,'public'),
    	];
    	
		return view('user.edit',['user'=>$user,'fields'=>$fields]);
		
		
    }
    
    public function save(Request $request) {
		
		$user = Auth::user();
		
		error_log(print_r($request->all(),true));
		
		$data = $request->all();
		
		$data['public'] = (isset($data['public']))?$data['public']:0;
		
		$rules = [
			'name'=>'required_if:public,1|string',
			'affiliation'=>'string',
			'public'=>'boolean'
    	];
    	
    	$messages = [
			'name.required_if' => 'You have to supply a name if you want to show up on the leaderboard.'
    	];
    	
    	$validator = Validator::make($data,$rules,$messages);
    	
    	//According to the docs, custom validators should have method validate(). They do not. Therefore, this.
    	if ($validator->fails()) {
			return redirect('profile/edit')
                        ->withErrors($validator)
                        ->withInput();
		};
		
		$user->update([
			'name'=> $data['name'],
			'affiliation'=>$data['affiliation'],
			'public'=>$data['public'],
		]);
		//update db
			//save name
		//
		error_log('this is the part where we save the data');
    
		return redirect('profile');
	}
    
    private function oldOrNew($request,$user,$param) {
		if ($request->old($param) === null) {
			return $user->$param;
		} else {
			return $request->old($param);
		}
	}
    
}
