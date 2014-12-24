<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');

Route::post('result', 'AnalysisController@analyse');

Route::get('/databaseDetail', function(){
	return View::make('management.databaseDetail');
});

Route::get('/groupManagement', function(){
	return View::make('management.groupManagement');
});


