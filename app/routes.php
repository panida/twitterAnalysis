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

Route::get('/', 'HomeController@showWelcome')->before('auth');

Route::get('login', function(){
	return View::make('layouts.login');
});

Route::post('login', 'AuthController@login');

Route::get('logout', 'AuthController@logout')->before('auth');

Route::any('result', 'AnalysisController@analyse')->before('auth');

Route::get('/databaseDetail', 'DatabaseManagementController@editGroupsOfCase')->before('auth');

Route::post('addGroupOfCase', 'DatabaseManagementController@saveGroupsOfCase')->before('auth');

Route::get('/about', function(){
	return View::make('management.about');
})->before('auth');

Route::get('/contact', function(){
	return View::make('management.contact');
})->before('auth');

Route::get('/groupManagement', 'GroupManagementController@createGroup')->before('auth');

Route::post('/groupManagement', 'GroupManagementController@addGroup')->before('auth');

Route::get('/group/{id}', 'GroupManagementController@createMembersOfGroup')->before('auth');
Route::post('/group/{id}', 'GroupManagementController@editGroup')->before('auth');

Route::get('deleteGroup/{groupid}', 'GroupManagementController@deleteGroup')->before('auth');
Route::get('deleteMember/{groupid}/{userkey}', 'GroupManagementController@deleteMember')->before('auth');
Route::post('/group/addMember/{groupid}', 'GroupManagementController@addMember')->before('auth');




Route::get('report','HomeController@exportReport')->before('auth');
Route::get('resultReport/{filename}','ReportController@getDownloadPDF')->before('auth');
Route::get('resultCSV/{filename}','ReportController@getDownloadCSV')->before('auth');
Route::get('callForImage','ReportController@callForImage')->before('auth');
Route::post('callForImage','ReportController@callForImage')->before('auth');
Route::get('generateCSV','ReportController@generateCSV')->before('auth');
Route::post('generateCSV','ReportController@generateCSV')->before('auth');

Route::any('test', function(){
	return View::make('test');
})->before('auth');

