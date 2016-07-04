<?php 

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DataControllerTest extends TestCase
{
    /**
     *	If the request has no app key, abort with 401.
     *	@return void
     */
    public function testSubmitNoAppKey() {
		$response = $this->call('POST','data/submit',['say'=>'what']);
		//curl -v -s -i -d "say=what" "http://cubehome_local/data/submit" 1> /dev/null
		
		$this->assertResponseStatus('401'); 
		$this->see("No app key supplied."); 
	}
	
	/**
     *	If the request has bad app key, abort with 401.
     *	@return void
     */
	public function testSubmitBadAppKey() {
		$bad_key = "swordfish";
		$response = $this->call('POST','data/submit',['app_key'=>$bad_key]);
		//curl -v -s -i -d "app_key=swordfish" "http://cubehome_local/data/submit" 1> /dev/null
		
		$this->assertResponseStatus('401'); 
		$this->see('Supplied app key "'.$bad_key.'" is incorrect.'); 
	}
	
	/**
     *	If the request is comming from blocked IP, abort with 403.
	 * 	@todo needs blocking/unblocking a user
     *	@return void
     */
	public function testSubmitBlockedUser() {
			
		//get user by IP (127.0.0.1), block them
		
		$response = $this->call('POST','data/submit',['app_key'=>'OTe7K69Plj0nAFgX91sAszl2txy9TobF','cubesat_time'=>Carbon\Carbon::now(),'uploaded_at'=>Carbon\Carbon::now()]);
		//curl -v -s -i -d "app_key=OTe7K69Plj0nAFgX91sAszl2txy9TobF" "http://cubehome_local/data/submit" 1> /dev/null
		
		//unblock user!
	}
	
	/**
     *	If everything is OK, return 200.
     *	@return void
     */
	public function testSubmitOK() {
		$response = $this->call('POST','data/submit',['app_key'=>'OTe7K69Plj0nAFgX91sAszl2txy9TobF','user_id'=>1,'cubesat_time'=>Carbon\Carbon::now(),'uploaded_at'=>Carbon\Carbon::now()]);
		//curl -v -s -i -d "app_key=OTe7K69Plj0nAFgX91sAszl2txy9TobF" "http://cubehome_local/data/submit" 1> /dev/null
		
		$this->assertEquals('200',$response->status());
		$this->see("Success.");
	}
	
	public function testRedirect() {
		$this->get('data/submit')
			->assertRedirectedToRoute('submit');
	}
}
