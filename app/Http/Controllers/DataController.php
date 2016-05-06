<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DataController extends Controller
{
    public function __construct(Submission $submission) {
    	$this->submission = $submission;
    }
		
    //
    
    public function submit() {
    	/*
		 * app sends POST data through specific url
		 * check if the APP KEY is correct (app key is embedded in the Java app)
		 * 
		 * if yes:
		 * 	submit data to db (VALIDATE)
		 * 	return something to notify success (id of submission? date uploaded? ??)
		 * 	if they don't pass validation: return error 
		 * 
		 * if no:
		 * 	return error
		 * 
		 * 
		 */ 
		 
		 return('yes');
    }
	
	
	public function redirect() {
		return redirect()->route('submit');
		#return redirect()->action('PagesController@submit');
	}
}
