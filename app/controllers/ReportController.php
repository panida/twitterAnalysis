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

	public function getDownloadPDF($filename){
        $file = public_path(). '/report/'.$filename;
        $headers = array(
              'Content-Type' => 'application/pdf',
            );
        return Response::download($file, $filename, $headers);
	}

	public function getDownloadCSV($filename){
        $file = public_path(). '/reportCSV/'.$filename;
        $headers = array(
              'Content-Type' => 'text/csv',
            );
        return Response::download($file, $filename, $headers);
	}

	
}
