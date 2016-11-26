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
        $searchTexts = explode("&&&", $searchText);
        if($searchTexts[0]=="*ALL*"){
            $searchTexts=array();
        }
		$startDate = $input['startDate'];
		$endDate = $input['endDate'];
		$timestamp = $input['timestamp'];
		// $filenameCSV = $input['filename'];
        $filenameCSV = 'report'.$timestamp.'.csv';
		$filenameCSV2 = 'report'.$timestamp.'-2.csv';
		$tweetResultList = TwitterAnalysisFact::searchByText($searchTexts,$startDate,$endDate,$caseID);
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
        //$timelineList = array();
        // return $caseID.$searchText.$filenameCSV;
		//------------------Create CSV File---------------------
     	$filenameTimeline = AjaxFile::generateTimelineFile($timestamp,$timelineList,"a");

        if(count($timelineList)<=499000){
            $file3 = fopen(public_path().'/reportCSV/'.$filenameCSV2,"a");
            //fputcsv($file3,['Twitter Account','Tweets','Retweets','Replies','Followers']);         
            foreach ($timelineList as $key => $aTweet) {
            	if($aTweet->real_activitytypekey==3){
            		fputcsv($file3,[' '.$aTweet->real_created_at, '@'.$aTweet->real_screenname, @iconv('UTF-8','cp874//IGNORE','RT@'.$aTweet->original_screenname.':'.$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->real_sourcename)]);
            	}
            	else{
            		fputcsv($file3,[' '.$aTweet->original_created_at, '@'.$aTweet->original_screenname, @iconv('UTF-8','cp874//IGNORE',$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->original_sourcename)]);
            	}
            }
            fclose($file3);
            //--------------------------------------------------------
            //$filenameCSV = $input['filename'];
            $tweetResultList2 = TwitterAnalysisFact::searchByText($searchTexts,$startDate,$endDate,$caseID);  
            $contributorKeyList = $tweetResultList2
                                    ->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')
                                    ->leftJoin('user_statistics_dim','twitter_analysis_fact.userstatisticskey','=','user_statistics_dim.userstatisticskey')
                                    ->select('user_dim.userkey',
                                        'user_dim.screenname',
                                        'twitter_analysis_fact.activitytypekey',
                                        'user_statistics_dim.followers_count',
                                        DB::raw('count(*) as totalNumber')
                                        )
                                    ->groupBy('user_dim.userkey','user_dim.screenname','twitter_analysis_fact.activitytypekey')
                                    ->orderBy('user_statistics_dim.followers_count','desc')
                                    ->get();
            $contributorList = array();
            foreach($contributorKeyList as $aContributorAndType){
                if(!array_key_exists($aContributorAndType->userkey,$contributorList)){
                    $contributorList[$aContributorAndType->userkey] = [ 'userkey'=>$aContributorAndType->userkey,
                                                                        'screenname'=>$aContributorAndType->screenname,
                                                                        'followerCount'=>$aContributorAndType->followers_count,
                                                                        'tweetCount'=>0,
                                                                        'retweetCount'=>0,
                                                                        'replyCount'=>0,
                                                                        'allActivityCount'=>0
                                                                        ];
                }
                if ($aContributorAndType->activitytypekey==3) {
                    $contributorList[$aContributorAndType->userkey]['retweetCount'] = $aContributorAndType->totalNumber;
                    $contributorList[$aContributorAndType->userkey]['allActivityCount'] += $aContributorAndType->totalNumber;
                }
                else if ($aContributorAndType->activitytypekey==1) {
                    $contributorList[$aContributorAndType->userkey]['tweetCount'] = $aContributorAndType->totalNumber;
                    $contributorList[$aContributorAndType->userkey]['allActivityCount'] += $aContributorAndType->totalNumber;
                }
                else {
                    $contributorList[$aContributorAndType->userkey]['replyCount'] = $aContributorAndType->totalNumber;
                    $contributorList[$aContributorAndType->userkey]['allActivityCount'] += $aContributorAndType->totalNumber;
                }               
            }
            reset($contributorList);
            $TwRtRpUserList = array();
            foreach($contributorList as $aUserStat){            
                // $TW = ($aUserStat['tweetCount'] > 0);
                // $RT = ($aUserStat['retweetCount'] > 0);
                // $RP = ($aUserStat['replyCount'] > 0);
                // if($TW or $RT or $RP){
                    array_push($TwRtRpUserList,$aUserStat);
                //}
            }
            //$TwRtRpUserList = array();
            $file2 = fopen(public_path().'/reportCSV/'.$filenameCSV,"a");       
            fputcsv($file2,[]);
            fputcsv($file2,[iconv('UTF-8','cp874','2. บุคคลที่เกี่ยวข้องทั้งหมด')]);
            fputcsv($file2,['Twitter Account','Tweets','Retweets','Replies','Followers']);
            foreach ($TwRtRpUserList as $key => $aUser) {         
                 fputcsv($file2,[iconv('UTF-8','cp874','@'.$aUser['screenname']),number_format($aUser['tweetCount']),number_format($aUser['retweetCount']),number_format($aUser['replyCount']),number_format($aUser['followerCount'])]);
            }
            fclose($file2);
            //--------------------MergeFile---------------------
             $fp1=fopen(public_path().'/reportCSV/'.$filenameCSV,"a+");
             $filenameCSV = 'report'.$timestamp.'-2.csv';
            $fp2=file_get_contents(public_path().'/reportCSV/'.$filenameCSV);
            fwrite($fp1,$fp2);
            //exec('cat '.public_path().'/reportCSV/'.$filenameCSV.' '.public_path().'/reportCSV/'.'report'.$timestamp.'-2.csv > '.public_path().'/reportCSV/'.$filenameCSV);
        }
        return 'finish';
	}

    public function generateAjaxText2(){
        $input = Input::all();
        $caseID = $input['caseID'];
        $searchText = $input['searchText'];
        $searchTexts = explode("&&&", $searchText);
        if($searchTexts[0]=="*ALL*"){
            $searchTexts=array();
        }
        $startDate = $input['startDate'];
        $endDate = $input['endDate'];
        $timestamp = $input['timestamp'];
        $filenameCSV = $input['filename'];
        $query = 'select tweet_original.text as original_text, tweet_detail_original.created_at as original_created_at, '.
                                                'source_original.sourcename as original_sourcename, '.
                                                'user_original.userkey as original_userkey, user_original.name as original_name, user_original.screenname as original_screenname, '.
                                                'user_original.profile_pic_url as original_pic, temp.totalRetweet '.
                                                'from ( '.
                                                    'select tweet_dim.tweetid, count(*) as totalRetweet '.
                                                    'from twitter_analysis_fact '. 
                                                    'inner join date_dim on date_dim.datekey = twitter_analysis_fact.datekey AND '.
                                                    'date_dim.thedate >= "'.$startDate.'" AND '.
                                                    'date_dim.thedate <= "'.$endDate.'" AND '.
                                                    'twitter_analysis_fact.activitytypekey = 3 AND '.
                                                    'twitter_analysis_fact.researchcasekey = '.$caseID.' '.  
                                                    'inner join tweet_dim on tweet_dim.tweetkey = twitter_analysis_fact.tweetkey AND ';

        foreach ($searchTexts as $searchText) {
            $query .= "tweet_dim.text LIKE '%".str_replace("'", "''", $searchText)."%' AND ";
        }
        $query = substr($query,0,-4);
        $query .= 
                                                    // "tweet_dim.text LIKE '%".str_replace("'", "''", $searchText)."%' ".
                                                    'group by tweet_dim.tweetid '.
                                                    'order by totalRetweet desc offset 1000 limit 1000000000'.
                                                ') temp '.
                                                'inner join twitter_analysis_fact on twitter_analysis_fact.objectid = temp.tweetid '.
                                                'inner join tweet_dim tweet_original on tweet_original.tweetkey = twitter_analysis_fact.tweetkey '.
                                                'inner join tweet_detail_dim tweet_detail_original on tweet_detail_original.tweetdetailkey = twitter_analysis_fact.tweetdetailkey '.
                                                'inner join source_dim source_original on source_original.sourcekey = twitter_analysis_fact.sourcekey '.
                                                'inner join user_dim user_original on user_original.userkey = twitter_analysis_fact.userkey '.
                                                'order by temp.totalRetweet desc';
        $topRetweetedList = DB::select(DB::raw($query));
        $filenameTopRetweetedList = AjaxFile::generateTopRetweetedFileSearchByText($timestamp,$topRetweetedList,"a");
        return 'finish';
    }

    public function generateAjaxText3(){
        $input = Input::all();
        $caseID = $input['caseID'];
        $searchText = $input['searchText'];
        $searchTexts = explode("&&&", $searchText);
        if($searchTexts[0]=="*ALL*"){
            $searchTexts=array();
        }
        $startDate = $input['startDate'];
        $endDate = $input['endDate'];
        $timestamp = $input['timestamp'];
        $filenameCSV = $input['filename'];
        
        $tweetResultList = TwitterAnalysisFact::searchByText($searchTexts,$startDate,$endDate,$caseID);  
        $follower_list = $tweetResultList
                ->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')                               
                ->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
                ->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
                ->orderBy('twitter_analysis_fact.number_of_follower','desc')
                ->take(1000000000)
                ->skip(1000)
                ->leftJoin('twitter_analysis_fact as original_fact','tweet_dim.tweetid','=','original_fact.objectid')
                //->where('original_fact.activitytypekey','<',3)                
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
        $filenameTopFollowerList = AjaxFile::generateTopFollowerFile($timestamp,$topFollowerList,"a");
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
        if(count($timelineList)<=499000){
            $file = fopen(public_path().'/reportCSV/'.$filenameCSV,"a");
            //fputcsv($file,['-------------------------------Hello World------------------------------ ']);
            foreach ($timelineList as $key => $aTweet) {
            	if($aTweet->real_activitytypekey==3){
            		fputcsv($file,[' '.$aTweet->real_created_at, '@'.$aTweet->real_screenname, @iconv('UTF-8','cp874//IGNORE','RT@'.$aTweet->original_screenname.':'.$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->real_sourcename)]);
            	}
            	else{
            		fputcsv($file,[' '.$aTweet->original_created_at, '@'.$aTweet->original_screenname, @iconv('UTF-8','cp874//IGNORE',$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->original_sourcename)]);
            	}
            }
            fclose($file);  
        }      
		return 'finish';
	}
}
