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

Route::any('result', 'AnalysisController@analyse');

Route::get('/databaseDetail', function(){
	return View::make('management.databaseDetail');
});

Route::get('/groupManagement', function(){
	return View::make('management.addGroup');
});

Route::get('/group/1', function(){
	return View::make('management.editGroup');
});


