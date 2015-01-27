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

Route::get('/groupManagement', 'GroupManagementController@createGroup');

Route::post('/groupManagement', 'GroupManagementController@addGroup');

Route::get('/group/{id}', 'GroupManagementController@createMembersOfGroup');
Route::post('/group/{id}', 'GroupManagementController@editGroup');

Route::get('deleteGroup/{groupid}', 'GroupManagementController@deleteGroup');
Route::get('deleteMember/{groupid}/{userkey}', 'GroupManagementController@deleteMember');
Route::post('/group/addMember/{groupid}', 'GroupManagementController@addMember');

Route::get('report','HomeController@exportReport');
Route::get('resultReport/{filename}','ReportController@getDownload');
