<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		$researchCase = ResearchCaseDim::lists('name', 'researchcasekey');
		$cases = ResearchCaseDim::caseData();
		// echo "<pre>";
		// var_dump($cases);
		// echo "</pre>";
		// return View::make('blank_page');
		return View::make('home/homepage2')
					->with('researchCase',$researchCase)
					->with('cases',$cases);
	}

}
