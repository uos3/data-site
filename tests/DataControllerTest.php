<?php 

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\BlacklistedIP;

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
	public function testSubmitBlockedIP() {
		$this->markTestIncomplete('unfinished');
		//temporarily block localhost
		$ip = BlacklistedIP::firstOrCreate(['ip_address'=>'127.0.0.1']);
		
		$response = $this->call('POST','data/submit',['app_key'=>env('APP_KEY'),'cubesat_time'=>Carbon\Carbon::now(),'uploaded_at'=>Carbon\Carbon::now()]);
		//curl -v -s -i -d "app_key=" "http://cubehome_local/data/submit" 1> /dev/null
		
		$this->assertResponseStatus('403');
		$this->see('Access denied.');
		
		$ip->delete();
	}
	
	public function testSubmitBlockedUser() {
		
		//pick user with id=1 (now our test user)
		//set them to blocked
		
		//try uploading with their credentials
		
		//should throw 403 and access denied 
		
		//unblock user!
	}
	
	/**
     *	If everything is OK, return 200.
     *	@return void
     */
	public function testAnonymousSubmit() {
		
		$response = $this->call('POST','data/submit',['app_key'=>env('APP_KEY'),'cubesat_time'=>Carbon\Carbon::now(),'uploaded_at'=>Carbon\Carbon::now()]);
		//curl -v -s -i -d "app_key=" "http://cubehome_local/data/submit" 1> /dev/null
		
		$this->assertResponseOk();
		$this->see("Success.");
	}
	
	public function testRedirect() {
		$this->get('data/submit')
			->assertRedirectedToRoute('submit');
			
		//$this->markTestIncomplete('unfinished');
		//$this->markedTestSkipped('not now');
	}
	
	public function testRegisteredUserSubmit() {
		
		$user = User::whereNotNull('submit_key')->first();
		
		//try to submit with their key
		
		//should return ok and see success
		
		$this->markTestIncomplete('unfinished');
	}
	
	
}
