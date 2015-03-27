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

	public function generateCSV(){
		$input = Input::all();
		if($input['type']=='text'){
			return ReportController::generateCSVText();
		}
		else{
			return ReportController::generateCSVUser();
		}
	}

	public function generateCSVText(){
		$input = Input::all();
		$caseID = $input['caseID'];
		$searchText = $input['searchText'];
		$startDate = $input['startDate'];
		$endDate = $input['endDate'];
		$timestamp = $input['timestamp'];
		$filenameCSV = $input['filename'];
		
		$tweetResultList = TwitterAnalysisFact::searchByText($searchText,$startDate,$endDate,$caseID);
		$timelineList = $tweetResultList
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')        		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')
        		// ->take(18446744073709550615)
        		->take(1000000000)
        		->skip(1000)
        		->leftJoin('twitter_analysis_fact as original_fact','tweet_dim.tweetkey','=','original_fact.tweetkey')
        		->where('original_fact.activitytypekey','<',3)        		
        		->leftJoin('user_dim as user_original','original_fact.userkey','=','user_original.userkey')
        		->leftJoin('source_dim as source_original','original_fact.sourcekey','=','source_original.sourcekey')
        		->leftJoin('tweet_detail_dim as tweet_detail_original','original_fact.tweetdetailkey','=','tweet_detail_original.tweetdetailkey')
        		->leftJoin('tweet_dim as tweet_original','original_fact.tweetkey','=','tweet_original.tweetkey')
        		->select('user_dim.screenname as real_screenname',
        			'source_dim.sourcename as real_sourcename',
        			'tweet_detail_dim.created_at as real_created_at',
        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
        			'twitter_analysis_fact.tweetkey as real_tweetkey',
        			'tweet_original.text as original_text',
        			'tweet_detail_original.created_at as original_created_at',
        			'source_original.sourcename as original_sourcename',
        			'user_original.name as original_name',
        			'user_original.screenname as original_screenname',
        			'user_original.profile_pic_url as original_pic',
        			'date_dim.abbr_nameofday as nameday',
        			'date_dim.date as date',
        			'date_dim.abbr_nameofmonth as month',
        			'date_dim.year as year',
        			'date_dim.thedate as thedate')
        		->get();
        // return $caseID.$searchText.$filenameCSV;
		//------------------Create CSV File---------------------
     	$filenameTimeline = AjaxFile::generateTimelineFile($timestamp,$timelineList,"a");

        $file = fopen(public_path().'/reportCSV/'.$filenameCSV,"a");         
        foreach ($timelineList as $key => $aTweet) {
        	if($aTweet->real_activitytypekey==3){
        		fputcsv($file,[' '.$aTweet->real_created_at, '@'.$aTweet->real_screenname, @iconv('UTF-8','cp874//IGNORE','RT@'.$aTweet->original_screenname.':'.$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->real_sourcename)]);
        	}
        	else{
        		fputcsv($file,[' '.$aTweet->original_created_at, '@'.$aTweet->original_screenname, @iconv('UTF-8','cp874//IGNORE',$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->original_sourcename)]);
        	}
        }
        fclose($file);
        return 'finish';
	}
	public function generateCSVUser(){
		$input = Input::all();
		$caseID = $input['caseID'];
		$searchText = $input['searchText'];
		$startDate = $input['startDate'];
		$endDate = $input['endDate'];
		$timestamp = $input['timestamp'];
		$filenameCSV = $input['filename'];
		$tweetResultList = TwitterAnalysisFact::searchByUser($searchText,$startDate,$endDate,$caseID);
		$timelineList = $tweetResultList
        		->leftJoin('tweet_dim','twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey')       		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')
        		->take(1000000000)
        		->skip(1000)
        		->leftJoin('twitter_analysis_fact as original_fact','tweet_dim.tweetkey','=','original_fact.tweetkey')
        		->where('original_fact.activitytypekey','<',3)        		
        		->leftJoin('user_dim as user_original','original_fact.userkey','=','user_original.userkey')
        		->leftJoin('source_dim as source_original','original_fact.sourcekey','=','source_original.sourcekey')
        		->leftJoin('tweet_detail_dim as tweet_detail_original','original_fact.tweetdetailkey','=','tweet_detail_original.tweetdetailkey')
        		->leftJoin('tweet_dim as tweet_original','original_fact.tweetkey','=','tweet_original.tweetkey')
        		->select('user_dim.screenname as real_screenname',
        			'source_dim.sourcename as real_sourcename',
        			'tweet_detail_dim.created_at as real_created_at',
        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
        			'twitter_analysis_fact.tweetkey as real_tweetkey',
        			'tweet_original.text as original_text',
        			'tweet_detail_original.created_at as original_created_at',
        			'source_original.sourcename as original_sourcename',
        			'user_original.name as original_name',
        			'user_original.screenname as original_screenname',
        			'user_original.profile_pic_url as original_pic',
        			'date_dim.abbr_nameofday as nameday',
        			'date_dim.date as date',
        			'date_dim.abbr_nameofmonth as month',
        			'date_dim.year as year',
        			'date_dim.thedate as thedate')
        		->get();
        $filenameTimeline = AjaxFile::generateTimelineFile($timestamp,$timelineList,"a");
        $file = fopen(public_path().'/reportCSV/'.$filenameCSV,"a");
        foreach ($timelineList as $key => $aTweet) {
        	if($aTweet->real_activitytypekey==3){
        		fputcsv($file,[' '.$aTweet->real_created_at, '@'.$aTweet->real_screenname, @iconv('UTF-8','cp874//IGNORE','RT@'.$aTweet->original_screenname.':'.$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->real_sourcename)]);
        	}
        	else{
        		fputcsv($file,[' '.$aTweet->original_created_at, '@'.$aTweet->original_screenname, @iconv('UTF-8','cp874//IGNORE',$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->original_sourcename)]);
        	}
        }
        fclose($file);        
		return 'finish';
	}
}
