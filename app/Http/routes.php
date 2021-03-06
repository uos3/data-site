<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//pages
Route::get('/','PagesController@home');
Route::get('satellite-info','PagesController@satellite_info');
Route::get('packets/{id}','PagesController@packet_single');
Route::get('packets','PagesController@packets');
Route::get('collected-data','PagesController@collected_data');
Route::get('leaderboard','PagesController@leaderboard');
Route::get('submit',['as'=>'submit','uses'=>'PagesController@submit']);

//JSON API
Route::post('data/submit','DataController@submit');
Route::get('data/submit','DataController@redirect');
Route::get('data/packet/last','DataController@lastPacket');

//csv export
Route::get('data/export/last','DataController@exportLast');

Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'Auth\RegistrationController@confirm'
]);

//Route::get('api','ApiController'); //this registers a group of endpoints - one for each controller method

//since Laravel 5.2.25, this needs to go WITHOUT the 'web' middleware, otherwise messages don't show.
Route::auth();
Route::get('/profile','UserAreaController@index');
Route::get('/profile/edit','UserAreaController@edit');
Route::post('/profile/edit','UserAreaController@save');
