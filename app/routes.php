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

Route::get('result/statistics', 'AnalysisController@showStatistics');

Route::get('result/speedAndLifeCycle', 'AnalysisController@showSpeedAndLifeCycle');

Route::get('result/contributor', 'AnalysisController@showContributor');

Route::get('result/tweetTimeline', 'AnalysisController@showTweetTimeline');

