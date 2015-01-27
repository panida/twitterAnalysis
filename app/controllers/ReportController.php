<?php

class ReportController extends BaseController {

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

	public function getDownload($filename){

        $file = public_path(). "\\report\\".$filename;
  //       echo "<pre>";
		// var_dump($file);
		// echo "</pre>";
		// return View::make('blank_page');
        $headers = array(
              'Content-Type' => 'application/pdf',
            );
        return Response::download($file, $filename, $headers);
	}

}
