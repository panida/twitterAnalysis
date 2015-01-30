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

        $file = /index-utf8-encode.php(). "/report/".$filename;
  //       echo "<pre>";
		// var_dump($file);
		// echo "</pre>";
		// return View::make('blank_page');
        $headers = array(
              'Content-Type' => 'application/pdf',
            );
        return Response::download($file, $filename, $headers);
	}

	public function callForImage(){
		$jsonString = "{
					  	title:{
					      text:''
						 },
					 	 plotOptions: {
					            pie: {
					                dataLabels: {
					                    enabled: true,
					                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
					                    style: {
					                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
					                    }
					                }
					            }
					        },
						        series: [{
						            type: 'pie',
						            name: 'Application',
						            data: [
						                ['Android',       26.8],
						                ['iPhone',    8.5],
						                ['Blackberry',     6.2],
						                ['Others',   0.7]
						            ]
						        }]

						}";
		$url = 'http://export.highcharts.com/index-utf8-encode.php';
		$data = array(
					'content' => 'options',
					'options' => $jsonString,
					'type' => 'image/png',
					'width' => '500',
					'constr' => 'Chart'
				);
		$fields = '';
	    foreach($data as $key => $value) { 
	       $fields .= $key . '=' . $value . '&'; 
	    }
	    rtrim($fields, '&');
		// // use key 'http' even if you send the request to https://...
		// $options = array(
		//     'http' => array(
		//         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		//         'method'  => 'POST',
		//         'content' => http_build_query($data),
		//     ),
		// );
		// $context  = stream_context_create($options);
		// $result = file_get_contents($url, false, $context);
		// $response = http_post_fields("http://export.highcharts.com/demo", $data);
		// // $r = new HttpRequest('http://export.highcharts.com/demo', HttpRequest::METH_POST);
		// // $r->addPostFields($data);
		// // try {
		// //     // echo $r->send()->getBody();
		// echo "<pre>";
		// var_dump($response);
		// echo "</pre>";
		// return View::make('blank_page');
		// } catch (HttpException $ex) {
		//     echo $ex;
		// }


		// $url = "http://localhost/post_output.php";
 
		// $post_data = array (
		//     "foo" => "bar",
		//     "query" => "Nettuts",
		//     "action" => "Submit"
		// );
		 
// 		$ch = curl_init();
		 
// 		curl_setopt($ch, CURLOPT_URL, $url);
		 
// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 		// we are doing a POST request
// 		curl_setopt($ch, CURLOPT_POST, 1);
// 		// adding the post variables to the request
// 		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		 
// 		$output = curl_exec($ch);
		 
// 		curl_close($ch);
		 
// 		echo $output;
// //------------------
// 		$ch = curl_init ($url);
// 	    curl_setopt($ch, CURLOPT_HEADER, 0);
// 	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 	    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
// 	    $raw=curl_exec($ch);
// 	    curl_close ($ch);
// 	    if(file_exists($saveto)){
// 	        unlink($saveto);
// 	    }
// 	    $fp = fopen($saveto,'x');
// 	    fwrite($fp, $raw);
// 	    fclose($fp);
	    //---------------------------------
	    $ch = curl_init ();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_POST, count($data));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		// adding the post variables to the request
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	    $raw=curl_exec($ch);
	    echo "<pre>";
		var_dump($raw);
		echo "</pre>";
		return View::make('blank_page');
	    curl_close ($ch);
	    $saveto = public_path().'/reportImage/pic.png';
	    $fp = fopen($saveto,'x');
	    fwrite($fp, $raw);
	    fclose($fp);
	}	

}
