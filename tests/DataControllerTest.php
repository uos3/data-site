<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DataControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testSubmit()
    {
    	$this->post('data/submit')
			->assertResponseOk();
			
		//give it a mocked up data
		
		//test if it ended up in the database
    }
	
	public function testRedirect() {
		$this->get('data/submit')
			->assertRedirectedToRoute('submit');
	}
}
