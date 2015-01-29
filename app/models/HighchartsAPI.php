<?php

class HighchartsAPI
{		
	public static function callForImage($filename,$jsonString,$width){
		extract($_POST);
		// $jsonString = "{
		// 			  	title:{
		// 			      text:''
		// 				 },
		// 			 	 plotOptions: {
		// 			            pie: {
		// 			                dataLabels: {
		// 			                    enabled: true,
		// 			                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
		// 			                    style: {
		// 			                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
		// 			                    }
		// 			                }
		// 			            }
		// 			        },
		// 				        series: [{
		// 				            type: 'pie',
		// 				            name: 'Application',
		// 				            data: [
		// 				                ['Android',       26.8],
		// 				                ['iPhone',    8.5],
		// 				                ['Blackberry',     6.2],
		// 				                ['Others',   0.7]
		// 				            ]
		// 				        }]

		// 				}";
		// $width = '500';
		$url = 'http://export.highcharts.com/';
		$data = array(
					'content' => 'options',
					'options' => $jsonString,
					'type' => 'image/png',
					'width' => $width,
					'constr' => 'Chart'
				);		
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    $raw = curl_exec($ch);
	    curl_close ($ch);
	    $saveto = public_path().'\reportImage\\'.$filename;
	    if(file_exists($saveto)){
	        unlink($saveto);
	    }	    	    
	    $fp = fopen($saveto,'x');
	    fwrite($fp, $raw);
	    fclose($fp);
	}	

}