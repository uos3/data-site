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

Route::get('/','PagesController@welcome');
Route::get('about','PagesController@about');
Route::get('contribute','PagesController@contribute');

Route::get('submit',['as'=>'submit','uses'=>'PagesController@submit']);

Route::post('data/submit','DataController@submit');

Route::get('data/submit','DataController@redirect');

//Route::get('api','ApiController'); //this registers a group of endpoints - one for each controller method


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});
