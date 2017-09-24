<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class UserAreaControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testProfileLoggedOut()
    {
        $this->get('/profile');
		$this->assertResponseStatus('302');					 
    }
	
	public function testProfileLoggedIn()
	{
		$user = new User(array('name'=>'John'));
		$this->be($user);
		
		$this->get('/profile');
		$this->assertResponseOk();
		$this->see('Profile');
	}
	
}
