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

Route::get('/', function()
{
	return View::make('home/homepage');
});

Route::get('result', function(){
	$searchText = 'Hello World';
	return View::make('result.statistics')->with('search',$searchText);
});

Route::get('result/statistics', function(){
	$searchText = 'Hello World';
	return View::make('result.statistics')->with('search',$searchText);
});

Route::get('result/speedAndLifeCycle', function(){
	$searchText = 'Hello World';
	return View::make('result.speedAndLifeCycle')->with('search',$searchText);
});

Route::get('result/contributor', function(){
	$searchText = 'Hello World';
	return View::make('result.contributor')->with('search',$searchText);
});

Route::get('result/tweetTimeline', function(){
	$searchText = 'Hello World';
	return View::make('result.tweetTimeline')->with('search',$searchText);
});

Route::get('result/device', function(){
	$searchText = 'Hello World';
	return View::make('result.device')->with('search',$searchText);
});


