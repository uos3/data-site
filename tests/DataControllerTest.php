<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\BlacklistedIP;
use App\Helpers\Helper;

class DataControllerTest extends TestCase
{

	use DatabaseTransactions;

	protected function makeUser() {

		$user = User::firstOrCreate([
			"name"=>'John',
			"email"=>'example@test.com',
		]);

		$user->submit_key = Helper::makeUniqueSubmitKey();
		$user->save();

		return $user;
	}

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

		$this->assertResponseStatus('403');
		$this->see('App key incorrect.');
	}

	/**
     *	If the request is comming from blocked IP, abort with 403.
	 * 	@return void
     */
	public function testSubmitBlockedIP() {
		//temporarily block localhost
		$ip = BlacklistedIP::firstOrCreate(['ip_address'=>'127.0.0.1']);

		$response = $this->call('POST','data/submit',[
				'app_key'=>env('APP_KEY'),
				'downlink_time'=>Carbon\Carbon::now(),
			]);
		//curl -v -s -i -d "app_key=" "http://cubehome_local/data/submit" 1> /dev/null

		$this->assertResponseStatus('403');
		$this->see('Access denied.');

		$ip->delete();
	}


	/**
     *	If the request is made with a wrong submit key, abort with 401.
	 * 	@return void
     */
	public function testSubmitBadSubmitKey() {

		//generate a key (it will be unique to the db - but it won't be in the db. Nifty!)
		$bad_submit_key = Helper::makeUniqueSubmitKey();

		//try uploading with it
		$response = $this->call('POST','data/submit',[
				'app_key'=>env('APP_KEY'),
				'submit_key'=>$bad_submit_key,
				'downlink_time'=>Carbon\Carbon::now(),
			]);

		//should be soft-blocked
		$this->assertResponseStatus('401');
		$this->see("No user with this submit key found.");
	}


	/**
     *	If the request is made by a blocked user, abort with 403.
	 * 	@return void
     */
	public function testSubmitBlockedUser() {
		//create a test user
		$user = $this->makeUser();
		//block the test user
		$user->blocked=true;
		$user->save();

		//try uploading with their credentials
		$response = $this->call('POST','data/submit',[
				'app_key'=>env('APP_KEY'),
				'submit_key'=>$user->submit_key,
				'downlink_time'=>Carbon\Carbon::now(),
			]);

		//should be blocked
		$this->assertResponseStatus('403');
		$this->see('Access denied.');

		//delete the user
		$user->delete();
	}

	/**
     *	If everything is OK, return 200.
     *	@return void
     */
	public function testAnonymousSubmit() {

		$timestamp = Carbon\Carbon::now();
		$response = $this->call('POST','data/submit',[
				'app_key'=>env('APP_KEY'),
				'downlink_time'=>$timestamp->toDateTimeString(),
				'payload_type'=>'x',
				'data'=>'gaidghaighadghapghapig'
		]);
		//curl -v -s -i -d "app_key=" "http://cubehome_local/data/submit" 1> /dev/null

		$this->assertResponseOk();
		$this->see("Success.");
		$this->seeInDatabase('submissions',[
				'downlink_time'=>$timestamp->toDateTimeString(),
			]);
	}

	public function testRedirect() {
		$this->get('data/submit')
			->assertRedirectedToRoute('submit');

		//$this->markTestIncomplete('unfinished');
		//$this->markedTestSkipped('not now');
	}

	public function testRegisteredUserSubmit() {

		$user = $this->makeUser();
		$timestamp = Carbon\Carbon::now();

		//try to submit with their key
		$response = $this->call('POST','data/submit',[
				'app_key'=>env('APP_KEY'),
				'submit_key'=>$user->submit_key,
				'downlink_time'=>$timestamp->toDateTimeString(),
				'data'=>'sdkgasdghdgsdfhpg',
				'payload_type'=>'x'
			]);

		//should return ok and see success
		$this->assertResponseOk();
		$this->see("Success.");
		$this->seeInDatabase('submissions',[
				'downlink_time'=>$timestamp->toDateTimeString(),
			]);
		$user->delete();
	}

	//dumb hack - clear testing user from the database in case the tests throw error and the user isn't deleted
	//TODO figure out a cleaner way to do it (testing db?)
	protected static function setUpAfterClass() {
		$user = User::where([
			"name"=>'John',
			"email"=>'example@test.com',
			"password"=>''
		])->first();

		$user->delete();
	}


}
