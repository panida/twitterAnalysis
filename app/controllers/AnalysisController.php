<?php

class AnalysisController extends BaseController {

	public function groupTweetForTweetGraph($allTweetQuery, $startDate,$endDate, &$tweetMonth, &$tweetWeek, &$tweetDay, &$tweetHour){
		$allTweetQuery = $allTweetQuery
			->select(DB::raw('
				count(*) as num_of_activity,
				date_dim.date, date_dim.month,
				date_dim.year,time_dim.hour,
				activitytypekey, source_dim.sourcetype'))
			->join('time_dim', 'twitter_analysis_fact.timekey', '=', 'time_dim.timekey')
			->join('source_dim', 'twitter_analysis_fact.sourcekey', '=', 'source_dim.sourcekey')
			->groupBy('date_dim.year', 'date_dim.month', 'date_dim.date','time_dim.hour', 'activitytypekey', 'source_dim.sourcekey')
			->orderBy('date_dim.year','ASC')
			->orderBy('date_dim.month','ASC')
			->orderBy('date_dim.date','ASC')
			->orderBy('time_dim.hour','ASC');
		$tweetGroup = $allTweetQuery->get();
		//$allTweetByDay = $allTweetByHour->groupBy('date_dim.date', 'date_dim.month', 'date_dim.year');
		//echo $startDate;
		

		//--------------------------- Hour -----------------------------------------------

		$startDate = Carbon::createFromFormat('Y-m-d H:i:s',$startDate." 00:00:00");
		//echo $startDate->toDateTimeString();
		$endDate = Carbon::createFromFormat('Y-m-d H:i:s',$endDate." 23:00:00");
		$sizeOfTweetGroup = sizeof($tweetGroup);
		$currentResultIndex = 0;
		$currentDate = clone $startDate;
		$currentSize = 0;
		$tweetApplicationGroupByHour = array(array(),array());
		$tweetTypeGroupByHour = array(array(),array(),array());
		$tweetGroupByHour = array();
		while($currentDate->diffInHours($endDate,false) >= 0){
			array_push($tweetGroupByHour, array(
				"dateTime" => clone $currentDate,
				"year" => $currentDate->year,
				"month" => $currentDate->month,
				"day"	=> $currentDate->day,
				"hour"	=> $currentDate->hour,
				"num_of_activity" => 0
			));

			for($i = 0; $i<3; $i+=1){
				array_push($tweetTypeGroupByHour[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"day"	=> $currentDate->day,
					"hour"	=> $currentDate->hour,
					"num_of_activity" => 0
				));
			}

			for($i = 0; $i<2; $i+=1){
				array_push($tweetApplicationGroupByHour[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"day"	=> $currentDate->day,
					"hour"	=> $currentDate->hour,
					"num_of_activity" => 0
				));
			}

			while($currentResultIndex < $sizeOfTweetGroup && 
				$tweetGroup[$currentResultIndex]->year == $currentDate->year && 
				$tweetGroup[$currentResultIndex]->month == $currentDate->month && 
				$tweetGroup[$currentResultIndex]->date == $currentDate->day && 
				$tweetGroup[$currentResultIndex]->hour == $currentDate->hour){
				
				$tweetGroupByHour[$currentSize]["num_of_activity"] +=  $tweetGroup[$currentResultIndex]->num_of_activity;
				$tweetTypeGroupByHour[$tweetGroup[$currentResultIndex]->activitytypekey-1][$currentSize]["num_of_activity"] += $tweetGroup[$currentResultIndex]->num_of_activity;

				if($tweetGroup[$currentResultIndex]->sourcetype == 'web'){
					$tweetApplicationGroupByHour[0][$currentSize]["num_of_activity"] += $tweetGroup[$currentResultIndex]->num_of_activity;
				}
				else if($tweetGroup[$currentResultIndex]->sourcetype == 'mobile'){
					$tweetApplicationGroupByHour[1][$currentSize]["num_of_activity"] += $tweetGroup[$currentResultIndex]->num_of_activity;
				}
				$currentResultIndex+=1;

			}
			$currentDate = $currentDate->addHour();
			$currentSize+=1;
		}
		array_push($tweetHour,$tweetGroupByHour,$tweetTypeGroupByHour, $tweetApplicationGroupByHour);

		//--------------------------- Day -----------------------------------------------

		$tweetApplicationGroupByDay = array(array(),array());
		$tweetGroupByDay = array();
		$tweetTypeGroupByDay = array(array(),array(),array());
		$currentDate = clone $startDate;
		$currentSize = 0;
		$currentGroupInHourInx =0;
		$sizeOfTweetGroup = sizeof($tweetGroupByHour);
		while($currentDate->diffInDays($endDate,false) >= 0){
			array_push($tweetGroupByDay, array(
				"dateTime" => clone $currentDate,
				"year" => $currentDate->year,
				"month" => $currentDate->month,
				"day"	=> $currentDate->day,
				"num_of_activity" => 0
			));
			for($i = 0; $i<3; $i+=1){
				array_push($tweetTypeGroupByDay[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"day"	=> $currentDate->day,
					"num_of_activity" => 0
				));
			}

			for($i = 0; $i<2; $i+=1){
				array_push($tweetApplicationGroupByDay[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"day"	=> $currentDate->day,
					"num_of_activity" => 0
				));
			}

			while($currentGroupInHourInx < $sizeOfTweetGroup && 
				$currentDate->diffInDays($tweetGroupByHour[$currentGroupInHourInx]["dateTime"])==0){
				$tweetGroupByDay[$currentSize]["num_of_activity"] += $tweetGroupByHour[$currentGroupInHourInx]["num_of_activity"];
				for($i = 0; $i<3; $i+=1){
					$tweetTypeGroupByDay[$i][$currentSize]["num_of_activity"] += $tweetTypeGroupByHour[$i][$currentGroupInHourInx]["num_of_activity"];
				}
				for($i = 0; $i<2; $i+=1){
					$tweetApplicationGroupByDay[$i][$currentSize]["num_of_activity"] += $tweetApplicationGroupByHour[$i][$currentGroupInHourInx]["num_of_activity"];
				}
				$currentGroupInHourInx += 1;
			}
			$currentDate=$currentDate->addDay();
			$currentSize += 1;
		}
		array_push($tweetDay,$tweetGroupByDay,$tweetTypeGroupByDay,$tweetApplicationGroupByDay);

		//--------------------------- Month -----------------------------------------------
		
		$tweetApplicationGroupByMonth = array(array(),array());
		$tweetGroupByMonth = array();
		$tweetTypeGroupByMonth = array(array(),array(),array());
		$currentDate = clone $startDate;
		$currentDate = $currentDate->startOfMonth();
		$endMonth = clone $endDate;
		$endMonth = $endMonth->startOfMonth();
		$currentSize = 0;
		$currentGroupInDayInx =0;
		$sizeOfTweetGroup = sizeof($tweetGroupByDay);
		while($currentDate->diffInMonths($endMonth,false) >= 0){
			array_push($tweetGroupByMonth, array(
				"dateTime" => clone $currentDate,
				"year" => $currentDate->year,
				"month" => $currentDate->month,
				"num_of_activity" => 0
			));
			
			for($i = 0; $i<3; $i+=1){
				array_push($tweetTypeGroupByMonth[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"num_of_activity" => 0
				));
			}

			for($i = 0; $i<2; $i+=1){
				array_push($tweetApplicationGroupByMonth[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"num_of_activity" => 0
				));
			}

			while($currentGroupInDayInx < $sizeOfTweetGroup && 
				$currentDate->diffInMonths($tweetGroupByDay[$currentGroupInDayInx]["dateTime"])==0){
				
				$tweetGroupByMonth[$currentSize]["num_of_activity"] += $tweetGroupByDay[$currentGroupInDayInx]["num_of_activity"];
				for($i = 0; $i<3; $i+=1){
					$tweetTypeGroupByMonth[$i][$currentSize]["num_of_activity"] += $tweetTypeGroupByDay[$i][$currentGroupInDayInx]["num_of_activity"];
				}

				for($i = 0; $i<2; $i+=1){
					$tweetApplicationGroupByMonth[$i][$currentSize]["num_of_activity"] += $tweetApplicationGroupByDay[$i][$currentGroupInDayInx]["num_of_activity"];
				}

				$currentGroupInDayInx += 1;
			}
			$currentDate=$currentDate->addMonth();
			$currentSize += 1;
		}
		array_push($tweetMonth,$tweetGroupByMonth,$tweetTypeGroupByMonth,$tweetApplicationGroupByMonth);

		//--------------------------- Week -----------------------------------------------

		$tweetApplicationGroupByWeek = array(array(),array());
		$tweetGroupByWeek = array();
		$tweetTypeGroupByWeek = array(array(),array(),array());
		$currentDate = clone $startDate;
		$currentDate = $currentDate->startOfWeek();
		$endWeek = clone $endDate;
		$endWeek = $endWeek->startOfWeek();
		$currentSize = 0;
		$currentGroupInDayInx =0;
		$sizeOfTweetGroup = sizeof($tweetGroupByDay);
		while($currentDate->diffInWeeks($endWeek,false) >= 0){
			$startDateTime = clone $currentDate;
			$endDateTime = clone $currentDate;
			array_push($tweetGroupByWeek, array(
				"startDay" => $startDateTime->day,
				"endDay" => $endDateTime->endOfWeek()->day,
				"year" => $currentDate->year,
				"month" => $currentDate->month,
				"num_of_activity" => 0
			));
			for($i = 0; $i<3; $i+=1){
				array_push($tweetTypeGroupByWeek[$i], array(
					"startDay" => $startDateTime->day,
					"endDay" => $endDateTime->endOfWeek()->day,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"num_of_activity" => 0
				));
			}
			for($i = 0; $i<2; $i+=1){
				array_push($tweetApplicationGroupByWeek[$i], array(
					"startDay" => $startDateTime->day,
					"endDay" => $endDateTime->endOfWeek()->day,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"num_of_activity" => 0
				));
			}
			while($currentGroupInDayInx < $sizeOfTweetGroup && 
				$currentDate->diffInWeeks($tweetGroupByDay[$currentGroupInDayInx]["dateTime"])==0){
				
				$tweetGroupByWeek[$currentSize]["num_of_activity"] += $tweetGroupByDay[$currentGroupInDayInx]["num_of_activity"];
				for($i = 0; $i<3; $i+=1){
					$tweetTypeGroupByWeek[$i][$currentSize]["num_of_activity"] += $tweetTypeGroupByDay[$i][$currentGroupInDayInx]["num_of_activity"];
				}
				for($i = 0; $i<2; $i+=1){
					$tweetApplicationGroupByWeek[$i][$currentSize]["num_of_activity"] += $tweetApplicationGroupByDay[$i][$currentGroupInDayInx]["num_of_activity"];
				}

				$currentGroupInDayInx += 1;
			}
			$currentDate=$currentDate->addWeek();
			$currentSize += 1;
		}
		array_push($tweetWeek,$tweetGroupByWeek,$tweetTypeGroupByWeek,$tweetApplicationGroupByWeek);
	}

	public static function cmpByGroupidAscTimeDesc($a, $b){
		if($a->groupid<$b->groupid) return -1;
		else if($a->groupid>$b->groupid) return 1;
		else {
			if($a->real_created_at==$b->real_created_at) return 0;
		} return ($a->real_created_at<$b->real_created_at)? 1:-1; 
	} 

	public function analyse(){		
		$input = Input::all();
		if($input['type']=='text'){
			return AnalysisController::analyseByText();
		}
		else{
			return AnalysisController::analyseByUser();
		}
	}

	public function analyseByText(){
		$input = Input::all();
		$caseID = $input['caseID'];
		$searchText = $input['searchText'];
		$startDate = $input['startDate'];
		$endDate = $input['endDate'];
		if($input['type']=='text'){
			$tweetResultList = TwitterAnalysisFact::searchByText($searchText,$startDate,$endDate,$caseID);
		}
		else{
			$tweetResultList = TwitterAnalysisFact::searchByUser($searchText,$startDate,$endDate,$caseID);
		}
		
		$tweetResult = $tweetResultList->get();

		//Prepare Data for tweet graph
		$allTweetQuery = clone $tweetResultList;
		$tweetMonth = array();
		$tweetWeek = array();
		$tweetDay = array();
		$tweetHour = array();
		AnalysisController::groupTweetForTweetGraph($allTweetQuery,$startDate,$endDate,$tweetMonth,$tweetWeek,$tweetDay,$tweetHour);


		$countAllTweet = sizeof($tweetResult);
		if($countAllTweet==0){
			$result = ['type'=>$input['type'],
					'caseID' => $caseID,
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'countAllTweet'=>$countAllTweet,
					'researchCase' => ResearchCaseDim::lists('name', 'researchcasekey')];
			return View::make('layouts.notFound',$result);
		}

        						// ->get();
  //       var_dump($topFollowerList);
		// return View::make('blank_page');
		$tweetResultListTemp = clone $tweetResultList; 
		$tweetResultList = array();
		for($i=0;$i<=20;$i++) $tweetResultList[$i] = clone $tweetResultListTemp;   
        

		$countAllImpression = $tweetResultList[1]->sum('twitter_analysis_fact.number_of_follower');
		$tweetOriginalKeyList = $tweetResultList[2]->select('twitter_analysis_fact.tweetkey')->distinct()->get();
		$contributorKeyList = $tweetResultList[3]->select('twitter_analysis_fact.userstatisticskey')->distinct()->get();
		$sourceKeyList = $tweetResultList[4]->select('twitter_analysis_fact.sourcekey')->distinct()->get();
		$countRetweetTime = $tweetResultList[5]->where('twitter_analysis_fact.activitytypekey','=','3')
                 ->select('twitter_analysis_fact.tweetkey', DB::raw('count(*) as totalRetweet'))
                 ->groupBy('twitter_analysis_fact.tweetkey')
                 ->orderBy('totalRetweet','desc')
                 ->get();
 //                 	var_dump($tweetResultList->get());
	// return View::make('blank_page');
        $topFollowerList = $tweetResultList[6]
        		->orderBy('twitter_analysis_fact.number_of_follower','desc')
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')        		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
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
        			'user_original.profile_pic_url as original_pic')
        		->get();

        $timelineList = $tweetResultList[7]
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')        		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')
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

        $tweetInterestList = $tweetResultList[8]
        		->where('activitytypekey',1)
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')
        		->where('user_dim.isinterested','Yes')
        		->leftJoin('group_user_mapping','twitter_analysis_fact.userkey','=','group_user_mapping.userkey') 
        		->leftJoin('usergroup','group_user_mapping.groupid','=','usergroup.groupid')       		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')        		
        		->select('user_dim.screenname as real_screenname',
        			'user_dim.name as real_name',
        			'user_dim.profile_pic_url as real_pic',
        			'source_dim.sourcename as real_sourcename',
        			'tweet_detail_dim.created_at as real_created_at',
        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
        			'twitter_analysis_fact.tweetkey as real_tweetkey',
        			'tweet_dim.text as original_text',
        			'usergroup.groupid as groupid',
        			'usergroup.groupname as groupname',
        			'date_dim.abbr_nameofday as nameday',
        			'date_dim.date as date',
        			'date_dim.abbr_nameofmonth as month',
        			'date_dim.year as year',
        			'date_dim.thedate as thedate'
        			);        		
        $tweetInterestDetailList = $tweetInterestList->get();
        $tweetInterestCountList = $tweetInterestList
        							->select('usergroup.groupid','usergroup.groupname as groupname', DB::raw('count(*) as totalTweet'))
					                ->groupBy('usergroup.groupid')
					        		->get();

		$replyInterestList = $tweetResultList[9]
        		->where('activitytypekey',2)
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')
        		->where('user_dim.isinterested','Yes')
        		->leftJoin('group_user_mapping','twitter_analysis_fact.userkey','=','group_user_mapping.userkey') 
        		->leftJoin('usergroup','group_user_mapping.groupid','=','usergroup.groupid')       		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')        		
        		->select('user_dim.screenname as real_screenname',
        			'user_dim.name as real_name',
        			'user_dim.profile_pic_url as real_pic',
        			'source_dim.sourcename as real_sourcename',
        			'tweet_detail_dim.created_at as real_created_at',
        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
        			'twitter_analysis_fact.tweetkey as real_tweetkey',
        			'tweet_dim.text as original_text',
        			'usergroup.groupid as groupid',
        			'usergroup.groupname as groupname',
        			'date_dim.abbr_nameofday as nameday',
        			'date_dim.date as date',
        			'date_dim.abbr_nameofmonth as month',
        			'date_dim.year as year',
        			'date_dim.thedate as thedate'
        			);        		
        $replyInterestDetailList = $replyInterestList->get();
        $replyInterestCountList = $replyInterestList
        							->select('usergroup.groupid','usergroup.groupname as groupname', DB::raw('count(*) as totalReply'))
					                ->groupBy('usergroup.groupid')
					        		->get();


		$retweetInterestList = $tweetResultList[10]
				->where('twitter_analysis_fact.activitytypekey',3)   
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')   
        		->where('user_dim.isinterested','Yes')
        		->leftJoin('group_user_mapping','twitter_analysis_fact.userkey','=','group_user_mapping.userkey') 
        		->leftJoin('usergroup','group_user_mapping.groupid','=','usergroup.groupid')      		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')
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
        			'usergroup.groupid as groupid',
        			'usergroup.groupname as groupname',
        			'date_dim.abbr_nameofday as nameday',
        			'date_dim.date as date',
        			'date_dim.abbr_nameofmonth as month',
        			'date_dim.year as year',
        			'date_dim.thedate as thedate');
        		
        $retweetInterestDetailList = $retweetInterestList->get();
        $retweetInterestCountList = $retweetInterestList
        							->select('usergroup.groupid','usergroup.groupname as groupname', DB::raw('count(*) as totalRetweet'))
					                ->groupBy('usergroup.groupid')
					        		->get();
		usort($tweetInterestDetailList,"AnalysisController::cmpByGroupidAscTimeDesc");
		usort($retweetInterestDetailList,"AnalysisController::cmpByGroupidAscTimeDesc");
		usort($replyInterestDetailList,"AnalysisController::cmpByGroupidAscTimeDesc");
			// echo "<pre>";
   //   		var_dump($tweetInterestDetailList);
			// echo "</pre>";
			// return View::make('blank_page');
		$totalGroup = array();
		foreach($tweetInterestCountList as $aGroup){
			$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
									  'groupname'=>$aGroup->groupname,
									  'tweetCount'=>$aGroup->totalTweet,
									  'retweetCount'=>0,
									  'replyCount'=>0];
		}
		foreach($retweetInterestCountList as $aGroup){
			if(array_key_exists($aGroup->groupid, $totalGroup)) 
				$totalGroup[$aGroup->groupid]['retweetCount'] = $aGroup->totalRetweet;
			else
				$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
									  'groupname'=>$aGroup->groupname,
									  'tweetCount'=>0,
									  'retweetCount'=>$aGroup->totalRetweet,
									  'replyCount'=>0];
		}
		foreach($replyInterestCountList as $aGroup){
			if(array_key_exists($aGroup->groupid, $totalGroup)) 
				$totalGroup[$aGroup->groupid]['replyCount'] = $aGroup->totalReply;
			else
				$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
									  'groupname'=>$aGroup->groupname,
									  'tweetCount'=>0,
									  'retweetCount'=>0,
									  'replyCount'=>$aGroup->totalReply];
		}

		ksort($totalGroup);
   //      	echo "<pre>";
   //   		var_dump($totalGroup);
			// echo "</pre>";
			// return View::make('blank_page');		



        $topRetweetedList = array();
        $i = 0;
        $retweetedCountOfUser = array();
        foreach($countRetweetTime as $aTweet){
        	$originalTweetFact = TwitterAnalysisFact::findOriginalTweet($aTweet->tweetkey);
        	if(get_class($originalTweetFact)!=='TwitterAnalysisFact'){
        	var_dump($aTweet->tweetkey);
			return View::make('blank_page');}
        	$user = $originalTweetFact->user;
        	$date = $originalTweetFact->date;
        	$time = $originalTweetFact->time;
        	$detail = $originalTweetFact->tweetdetail;
        	$source = $originalTweetFact->source->sourcename;
        	$text = TweetDim::find($aTweet->tweetkey)->text;
        	$topRetweetedList[$i] = ['tweetkey'=>$aTweet->tweetkey,
        								'text'=>$text,
        								'date'=>$date,
        								'time'=>$time,
        								'detail' =>$detail,
        								'source'=>$source,
        								'user'=>$user,
        								'retweetCount' => $aTweet->totalRetweet
									];
			if(array_key_exists($user->userid,$retweetedCountOfUser)) $retweetedCountOfUser[$user->userid]['count'] += $aTweet->totalRetweet;
			else $retweetedCountOfUser[$user->userid] = ['count'=>$aTweet->totalRetweet,'screenname'=>$user->screenname,'pic'=>$user->profile_pic_url];
			$i++;
        }
        $maxRTCount = -1;
        $maxRetweetedUser = NULL;
        foreach($retweetedCountOfUser as $aUser){
        	if($aUser['count']>$maxRTCount){
        		$maxRTCount = $aUser['count'];
        		$maxRetweetedUser = $aUser;
        	}
    	}
  	// 				var_dump($topRetweetedList);
			// return View::make('blank_page');
        if(sizeof($topRetweetedList)<=10) $top10RetweetedList = $topRetweetedList;
        else $top10RetweetedList = array_slice($topRetweetedList, 0,10);
		// $countRetweetTime = array();
		$contributorList = array();
		$maxFol = -1;
		$maxUSKey = 0;
		foreach($contributorKeyList as $aKey){
			$contributorList[$aKey->userstatisticskey] = new ContributorData();	
			$contributorList[$aKey->userstatisticskey]->userstatisticskey = $aKey->userstatisticskey;
			$followerCount = UserStatisticsDim::find($aKey->userstatisticskey)->followers_count;
			$contributorList[$aKey->userstatisticskey]->followerCount = $followerCount;
			if($followerCount>$maxFol){
				$maxFol = $followerCount;
				$maxUSKey = $aKey->userstatisticskey;
			}
		}
		$maxFolUser = DB::table('user_statistics_dim')->where('userstatisticskey',$maxUSKey)
						->join('user_dim','user_dim.userid','=','user_statistics_dim.userid')
						->first();
		$maxFollowerUser = ['count'=>$maxFol,'screenname'=>$maxFolUser->screenname,'pic'=>$maxFolUser->profile_pic_url];
		// var_dump($topFollower);
		// return View::make('blank_page');
		$sourceList = array();
		foreach($sourceKeyList as $aKey){
			$sourceList[$aKey->sourcekey] = 0;
		}
		$countActTweet = 0;
		$countActRetweet = 0;
		$countActReply = 0;
		// $tweetInterestUser = array();
		// $retweetInterestUser = array();
		// $replyInterestUser = array();
		foreach($tweetResult as $tweet){
			$aKey = $tweet->userstatisticskey;
			if($tweet->activitytypekey==1){//tweet
				$contributorList[$aKey]->tweetCount+=1; 
				$countActTweet+=1;
				// if($tweet->user->isinterested == "Yes"){
				// 	foreach($tweet->user->groups as $aGroup){
				// 		if(array_key_exists($aGroup->groupid, $tweetInterestUser)) $tweetInterestUser[$aGroup->groupid]+=1;
				// 		else $tweetInterestUser[$aGroup->groupid]=1;
				// 	}
				// }
			} 
			else if($tweet->activitytypekey==2){//reply
				$contributorList[$aKey]->replyCount+=1; 
				$countActReply+=1;
				// if($tweet->user->isinterested == "Yes"){
				// 	foreach($tweet->user->groups as $aGroup){
				// 		if(array_key_exists($aGroup->groupid, $replyInterestUser)) $replyInterestUser[$aGroup->groupid]+=1;
				// 		else $replyInterestUser[$aGroup->groupid]=1;
				// 	}
				// }
			} 
			else{//retweet
				$contributorList[$aKey]->retweetCount+=1;
				$countActRetweet+=1;
				// if($tweet->user->isinterested == "Yes"){
				// 	foreach($tweet->user->groups as $aGroup){
				// 		if(array_key_exists($aGroup->groupid, $retweetInterestUser)) $retweetInterestUser[$aGroup->groupid]+=1;
				// 		else $retweetInterestUser[$aGroup->groupid]=1;
				// 	}
				// }
			}  
			$contributorList[$aKey]->allActivityCount+=1;
			$sourceList[$tweet->sourcekey]+=1; 
		}
		// echo "<pre>";
		// var_dump($tweetInterestUser);
		// var_dump($retweetInterestUser);
		// var_dump($replyInterestUser);
		// echo "</pre>";
		// return View::make('blank_page');


		$TwUserList = array();
		$RtUserList = array();
		$RpUserList = array();
		$TwRtUserList = array();
		$RtRpUserList = array();
		$TwRpUserList = array();
		$TwRtRpUserList = array();
		usort($contributorList,"ContributorData::cmpByFollowerCountDesc");
		reset($contributorList);
		foreach($contributorList as $aUserStat){
			$tweetFact = TwitterAnalysisFact::findTweetByUserStat($aUserStat->userstatisticskey);
			$username = $tweetFact->user->screenname; 
			$userDisplayStat = ['screenname'=>$username,
								'tweetCount'=>$aUserStat->tweetCount,
								'retweetCount'=>$aUserStat->retweetCount,
								'replyCount'=>$aUserStat->replyCount,
								'followerCount'=>$aUserStat->followerCount];
			$TW = ($aUserStat->tweetCount > 0);
			$RT = ($aUserStat->retweetCount > 0);
			$RP = ($aUserStat->replyCount > 0);
			if($TW){
				array_push($TwUserList,$userDisplayStat);
			}
			if($RT){
				array_push($RtUserList,$userDisplayStat);
			}
			if($RP){
				array_push($RpUserList,$userDisplayStat);
			}
			if($TW or $RT){
				array_push($TwRtUserList,$userDisplayStat);
			}
			if($TW or $RP){
				array_push($TwRpUserList,$userDisplayStat);
			}
			if($RT or $RP){
				array_push($RtRpUserList,$userDisplayStat);
			}
			if($TW or $RT or $RP){
				array_push($TwRtRpUserList,$userDisplayStat);
			}
		}
		$perPage = 10;
		$TwUserList = array_chunk($TwUserList,$perPage);
		$RtUserList = array_chunk($RtUserList,$perPage);	
		$RpUserList = array_chunk($RpUserList,$perPage);
		$TwRtUserList = array_chunk($TwRtUserList,$perPage);
		$RtRpUserList = array_chunk($RtRpUserList,$perPage);
		$TwRpUserList = array_chunk($TwRpUserList,$perPage);
		$TwRtRpUserList = array_chunk($TwRtRpUserList,$perPage);
		// var_dump($TwUserList);
		// return View::make('blank_page');
		usort($contributorList,"ContributorData::cmpByAllActivityCountDesc");
		reset($contributorList);
		// var_dump($contributorList);
		// return View::make('blank_page');
		$maxActUser = DB::table('user_statistics_dim')->where('userstatisticskey',$contributorList[0]->userstatisticskey)
						->join('user_dim','user_dim.userid','=','user_statistics_dim.userid')
						->first();
		$maxActivityUser = ['count'=>$contributorList[0]->allActivityCount,'screenname'=>$maxActUser->screenname,'pic'=>$maxActUser->profile_pic_url];

		$sourceProportion = array();
		for($i = 1;$i<=5;$i+=1){
			if(sizeof($sourceList)==0) break;
			$maxs = array_keys($sourceList, max($sourceList));
			$sourceProportion[$i] = ['sourceName'=>SourceDim::find($maxs[0])->sourcename,
									'count'=>max($sourceList)];
			unset($sourceList[$maxs[0]]);
		}
		if(sizeof($sourceList)>0) {
			$sourceProportion[6] = ['sourceName'=>'Others',
									'count'=>array_sum($sourceList)];
		}

		// ----- Statistics Tab -----
		
		$countAllContributor = sizeof($contributorList);
		
		$countAct = ['tweet'=>$countActTweet,'retweet'=>$countActRetweet,'reply'=>$countActReply];

		$result = ['type'=>$input['type'],
					'caseID' => $caseID,
					'researchCase' => ResearchCaseDim::lists('name', 'researchcasekey'),
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'countAllTweet'=>$countAllTweet,
					'countAllContributor'=>$countAllContributor,
					'countAllImpression'=>$countAllImpression,
					'countAct'=> $countAct,
					'sourceProportion'=>$sourceProportion,
					'topRetweetedList'=>$topRetweetedList,
					'top10RetweetedList'=>$top10RetweetedList,
					'topFollowerList'=>$topFollowerList,
					'timelineList'=>$timelineList,
					'maxFollowerUser'=>$maxFollowerUser,
					'maxRetweetedUser' =>$maxRetweetedUser,
					'maxActivityUser'=>$maxActivityUser,
					'tweetMonth' => $tweetMonth,
					'tweetWeek' => $tweetWeek,
					'tweetDay' => $tweetDay,
					'tweetHour' => $tweetHour,
					'TwUserList'=>$TwUserList,
					'RtUserList'=>$RtUserList, 
					'RpUserList'=>$RpUserList, 
					'TwRtUserList'=>$TwRtUserList,
					'RtRpUserList'=>$RtRpUserList,
					'TwRpUserList'=>$TwRpUserList, 
					'TwRtRpUserList'=>$TwRtRpUserList,
					'perPage'=>$perPage,
					'tweetInterestDetailList'=>$tweetInterestDetailList,
					'retweetInterestDetailList'=>$retweetInterestDetailList,
					'replyInterestDetailList'=>$replyInterestDetailList,
					'totalGroupDetail'=>$totalGroup
				];
		// $result = $input;
		return View::make('layouts.mainResultByText',$result);
	}

	public function analyseByUser()
	{
		$input = Input::all();
		$caseID = $input['caseID'];
		$searchText = $input['searchText'];
		$startDate = $input['startDate'];
		$endDate = $input['endDate'];
		if($input['type']=='text'){
			$tweetResultList = TwitterAnalysisFact::searchByText($searchText,$startDate,$endDate,$caseID);
		}
		else{
			$tweetResultList = TwitterAnalysisFact::searchByUser($searchText,$startDate,$endDate,$caseID);
		}
		
		$tweetResult = $tweetResultList->get();

	// 	//Prepare Data for tweet graph
	// 	$allTweetQuery = clone $tweetResultList;
	// 	$tweetMonth = array();
	// 	$tweetWeek = array();
	// 	$tweetDay = array();
	// 	$tweetHour = array();
	// 	AnalysisController::groupTweetForTweetGraph($allTweetQuery,$startDate,$endDate,$tweetMonth,$tweetWeek,$tweetDay,$tweetHour);


		$countAllTweet = sizeof($tweetResult);
		if($countAllTweet==0){
			$result = ['type'=>$input['type'],
					'caseID' => $caseID,
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'countAllTweet'=>$countAllTweet,
					'researchCase' => ResearchCaseDim::lists('name', 'researchcasekey')];
			return View::make('layouts.notFound',$result);
		}

 //        						// ->get();
 //  //       var_dump($topFollowerList);
	// 	// return View::make('blank_page');
		$tweetResultListTemp = clone $tweetResultList; 
		$tweetResultList = array();
		for($i=0;$i<=20;$i++) $tweetResultList[$i] = clone $tweetResultListTemp;   
        

		$countAllImpression = $tweetResultList[1]->sum('twitter_analysis_fact.number_of_follower');
		$tweetOriginalKeyList = $tweetResultList[2]->select('twitter_analysis_fact.tweetkey')->distinct()->get();
		$contributorKeyList = $tweetResultList[3]->select('twitter_analysis_fact.userstatisticskey')->distinct()->get();
		$sourceKeyList = $tweetResultList[4]->select('twitter_analysis_fact.sourcekey')->distinct()->get();
	// 	$countRetweetTime = $tweetResultList[5]->where('twitter_analysis_fact.activitytypekey','=','3')
 //                 ->select('twitter_analysis_fact.tweetkey', DB::raw('count(*) as totalRetweet'))
 //                 ->groupBy('twitter_analysis_fact.tweetkey')
 //                 ->orderBy('totalRetweet','desc')
 //                 ->get();
 // //                 	var_dump($tweetResultList->get());
	// // return View::make('blank_page');
 //        $topFollowerList = $tweetResultList[6]
 //        		->orderBy('twitter_analysis_fact.number_of_follower','desc')
 //        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')        		                
 //        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
 //        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
 //        		->leftJoin('twitter_analysis_fact as original_fact','tweet_dim.tweetkey','=','original_fact.tweetkey')
 //        		->where('original_fact.activitytypekey','<',3)        		
 //        		->leftJoin('user_dim as user_original','original_fact.userkey','=','user_original.userkey')
 //        		->leftJoin('source_dim as source_original','original_fact.sourcekey','=','source_original.sourcekey')
 //        		->leftJoin('tweet_detail_dim as tweet_detail_original','original_fact.tweetdetailkey','=','tweet_detail_original.tweetdetailkey')
 //        		->leftJoin('tweet_dim as tweet_original','original_fact.tweetkey','=','tweet_original.tweetkey')
 //        		->select('user_dim.screenname as real_screenname',
 //        			'source_dim.sourcename as real_sourcename',
 //        			'tweet_detail_dim.created_at as real_created_at',
 //        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
 //        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
 //        			'twitter_analysis_fact.tweetkey as real_tweetkey',
 //        			'tweet_original.text as original_text',
 //        			'tweet_detail_original.created_at as original_created_at',
 //        			'source_original.sourcename as original_sourcename',
 //        			'user_original.name as original_name',
 //        			'user_original.screenname as original_screenname',
 //        			'user_original.profile_pic_url as original_pic')
 //        		->get();

        $timelineList = $tweetResultList[7]
        		->leftJoin('tweet_dim','twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey')       		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')
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

 //        $tweetInterestList = $tweetResultList[8]
 //        		->where('activitytypekey',1)
 //        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')
 //        		->where('user_dim.isinterested','Yes')
 //        		->leftJoin('group_user_mapping','twitter_analysis_fact.userkey','=','group_user_mapping.userkey') 
 //        		->leftJoin('usergroup','group_user_mapping.groupid','=','usergroup.groupid')       		                
 //        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
 //        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
 //        		->orderBy('tweet_detail_dim.created_at','desc')        		
 //        		->select('user_dim.screenname as real_screenname',
 //        			'user_dim.name as real_name',
 //        			'user_dim.profile_pic_url as real_pic',
 //        			'source_dim.sourcename as real_sourcename',
 //        			'tweet_detail_dim.created_at as real_created_at',
 //        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
 //        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
 //        			'twitter_analysis_fact.tweetkey as real_tweetkey',
 //        			'tweet_dim.text as original_text',
 //        			'usergroup.groupid as groupid',
 //        			'usergroup.groupname as groupname',
 //        			'date_dim.abbr_nameofday as nameday',
 //        			'date_dim.date as date',
 //        			'date_dim.abbr_nameofmonth as month',
 //        			'date_dim.year as year',
 //        			'date_dim.thedate as thedate'
 //        			);        		
 //        $tweetInterestDetailList = $tweetInterestList->get();
 //        $tweetInterestCountList = $tweetInterestList
 //        							->select('usergroup.groupid','usergroup.groupname as groupname', DB::raw('count(*) as totalTweet'))
	// 				                ->groupBy('usergroup.groupid')
	// 				        		->get();

	// 	$replyInterestList = $tweetResultList[9]
 //        		->where('activitytypekey',2)
 //        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')
 //        		->where('user_dim.isinterested','Yes')
 //        		->leftJoin('group_user_mapping','twitter_analysis_fact.userkey','=','group_user_mapping.userkey') 
 //        		->leftJoin('usergroup','group_user_mapping.groupid','=','usergroup.groupid')       		                
 //        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
 //        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
 //        		->orderBy('tweet_detail_dim.created_at','desc')        		
 //        		->select('user_dim.screenname as real_screenname',
 //        			'user_dim.name as real_name',
 //        			'user_dim.profile_pic_url as real_pic',
 //        			'source_dim.sourcename as real_sourcename',
 //        			'tweet_detail_dim.created_at as real_created_at',
 //        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
 //        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
 //        			'twitter_analysis_fact.tweetkey as real_tweetkey',
 //        			'tweet_dim.text as original_text',
 //        			'usergroup.groupid as groupid',
 //        			'usergroup.groupname as groupname',
 //        			'date_dim.abbr_nameofday as nameday',
 //        			'date_dim.date as date',
 //        			'date_dim.abbr_nameofmonth as month',
 //        			'date_dim.year as year',
 //        			'date_dim.thedate as thedate'
 //        			);        		
 //        $replyInterestDetailList = $replyInterestList->get();
 //        $replyInterestCountList = $replyInterestList
 //        							->select('usergroup.groupid','usergroup.groupname as groupname', DB::raw('count(*) as totalReply'))
	// 				                ->groupBy('usergroup.groupid')
	// 				        		->get();


	// 	$retweetInterestList = $tweetResultList[10]
	// 			->where('twitter_analysis_fact.activitytypekey',3)   
 //        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')   
 //        		->where('user_dim.isinterested','Yes')
 //        		->leftJoin('group_user_mapping','twitter_analysis_fact.userkey','=','group_user_mapping.userkey') 
 //        		->leftJoin('usergroup','group_user_mapping.groupid','=','usergroup.groupid')      		                
 //        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
 //        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
 //        		->orderBy('tweet_detail_dim.created_at','desc')
 //        		->leftJoin('twitter_analysis_fact as original_fact','tweet_dim.tweetkey','=','original_fact.tweetkey')
 //        		->where('original_fact.activitytypekey','<',3)        		
 //        		->leftJoin('user_dim as user_original','original_fact.userkey','=','user_original.userkey')
 //        		->leftJoin('source_dim as source_original','original_fact.sourcekey','=','source_original.sourcekey')
 //        		->leftJoin('tweet_detail_dim as tweet_detail_original','original_fact.tweetdetailkey','=','tweet_detail_original.tweetdetailkey')
 //        		->leftJoin('tweet_dim as tweet_original','original_fact.tweetkey','=','tweet_original.tweetkey')
 //        		->select('user_dim.screenname as real_screenname',
 //        			'source_dim.sourcename as real_sourcename',
 //        			'tweet_detail_dim.created_at as real_created_at',
 //        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
 //        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
 //        			'twitter_analysis_fact.tweetkey as real_tweetkey',
 //        			'tweet_original.text as original_text',
 //        			'tweet_detail_original.created_at as original_created_at',
 //        			'source_original.sourcename as original_sourcename',
 //        			'user_original.name as original_name',
 //        			'user_original.screenname as original_screenname',
 //        			'user_original.profile_pic_url as original_pic',
 //        			'usergroup.groupid as groupid',
 //        			'usergroup.groupname as groupname',
 //        			'date_dim.abbr_nameofday as nameday',
 //        			'date_dim.date as date',
 //        			'date_dim.abbr_nameofmonth as month',
 //        			'date_dim.year as year',
 //        			'date_dim.thedate as thedate');
        		
 //        $retweetInterestDetailList = $retweetInterestList->get();
 //        $retweetInterestCountList = $retweetInterestList
 //        							->select('usergroup.groupid','usergroup.groupname as groupname', DB::raw('count(*) as totalRetweet'))
	// 				                ->groupBy('usergroup.groupid')
	// 				        		->get();
	// 	usort($tweetInterestDetailList,"AnalysisController::cmpByGroupidAscTimeDesc");
	// 	usort($retweetInterestDetailList,"AnalysisController::cmpByGroupidAscTimeDesc");
	// 	usort($replyInterestDetailList,"AnalysisController::cmpByGroupidAscTimeDesc");
	// 		// echo "<pre>";
 //   //   		var_dump($tweetInterestDetailList);
	// 		// echo "</pre>";
	// 		// return View::make('blank_page');
			$topRetweetedList = $tweetResultList[11]
				->where('twitter_analysis_fact.activitytypekey','<',3)   
				->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->leftJoin('tweet_dim','twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey')
				->leftJoin('twitter_analysis_fact as all_fact','tweet_dim.tweetkey','=','all_fact.tweetkey')
				->leftJoin('date_dim as all_fact_date_dim','all_fact.datekey','=','all_fact_date_dim.datekey')
				->where('all_fact_date_dim.thedate','>=',new DateTime($startDate))
				->where('all_fact_date_dim.thedate','<=',new DateTime($endDate))
				->select('user_dim.screenname as screenname',
					'user_dim.name as name',
					'user_dim.profile_pic_url as pic',
        			'source_dim.sourcename as sourcename',
        			'tweet_dim.text as text',
        			'tweet_detail_dim.created_at as created_at',
        			'twitter_analysis_fact.tweetkey',
        			DB::raw('count(*) as totalRetweet')) 
        		->groupBy('twitter_analysis_fact.tweetkey')
				->orderBy('totalRetweet','desc')       			
        		->get();
        	// totalRetweet also counts the original tweet edit this in view


			// echo "<pre>";
   //   		var_dump($topRetweetedList);
			// echo "</pre>";
			// return View::make('blank_page');
	// 	$totalGroup = array();
	// 	foreach($tweetInterestCountList as $aGroup){
	// 		$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
	// 								  'groupname'=>$aGroup->groupname,
	// 								  'tweetCount'=>$aGroup->totalTweet,
	// 								  'retweetCount'=>0,
	// 								  'replyCount'=>0];
	// 	}
	// 	foreach($retweetInterestCountList as $aGroup){
	// 		if(array_key_exists($aGroup->groupid, $totalGroup)) 
	// 			$totalGroup[$aGroup->groupid]['retweetCount'] = $aGroup->totalRetweet;
	// 		else
	// 			$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
	// 								  'groupname'=>$aGroup->groupname,
	// 								  'tweetCount'=>0,
	// 								  'retweetCount'=>$aGroup->totalRetweet,
	// 								  'replyCount'=>0];
	// 	}
	// 	foreach($replyInterestCountList as $aGroup){
	// 		if(array_key_exists($aGroup->groupid, $totalGroup)) 
	// 			$totalGroup[$aGroup->groupid]['replyCount'] = $aGroup->totalReply;
	// 		else
	// 			$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
	// 								  'groupname'=>$aGroup->groupname,
	// 								  'tweetCount'=>0,
	// 								  'retweetCount'=>0,
	// 								  'replyCount'=>$aGroup->totalReply];
	// 	}

	// 	ksort($totalGroup);
 //   //      	echo "<pre>";
 //   //   		var_dump($totalGroup);
	// 		// echo "</pre>";
	// 		// return View::make('blank_page');		



 //        $topRetweetedList = array();
 //        $i = 0;
 //        $retweetedCountOfUser = array();
 //        foreach($countRetweetTime as $aTweet){
 //        	$originalTweetFact = TwitterAnalysisFact::findOriginalTweet($aTweet->tweetkey);
 //        	if(get_class($originalTweetFact)!=='TwitterAnalysisFact'){
 //        	var_dump($aTweet->tweetkey);
	// 		return View::make('blank_page');}
 //        	$user = $originalTweetFact->user;
 //        	$date = $originalTweetFact->date;
 //        	$time = $originalTweetFact->time;
 //        	$detail = $originalTweetFact->tweetdetail;
 //        	$source = $originalTweetFact->source->sourcename;
 //        	$text = TweetDim::find($aTweet->tweetkey)->text;
 //        	$topRetweetedList[$i] = ['tweetkey'=>$aTweet->tweetkey,
 //        								'text'=>$text,
 //        								'date'=>$date,
 //        								'time'=>$time,
 //        								'detail' =>$detail,
 //        								'source'=>$source,
 //        								'user'=>$user,
 //        								'retweetCount' => $aTweet->totalRetweet
	// 								];
	// 		if(array_key_exists($user->userid,$retweetedCountOfUser)) $retweetedCountOfUser[$user->userid]['count'] += $aTweet->totalRetweet;
	// 		else $retweetedCountOfUser[$user->userid] = ['count'=>$aTweet->totalRetweet,'screenname'=>$user->screenname,'pic'=>$user->profile_pic_url];
	// 		$i++;
 //        }
 //        $maxRTCount = -1;
 //        $maxRetweetedUser = NULL;
 //        foreach($retweetedCountOfUser as $aUser){
 //        	if($aUser['count']>$maxRTCount){
 //        		$maxRTCount = $aUser['count'];
 //        		$maxRetweetedUser = $aUser;
 //        	}
 //    	}
 //  	// 				var_dump($topRetweetedList);
	// 		// return View::make('blank_page');
		$top10RetweetedList = array();
        if(sizeof($topRetweetedList)<=10) $top10RetweetedList = $topRetweetedList;
        else $top10RetweetedList = array_slice($topRetweetedList, 0,10);
	// 	// $countRetweetTime = array();
	// 	$contributorList = array();
	// 	$maxFol = -1;
	// 	$maxUSKey = 0;
	// 	foreach($contributorKeyList as $aKey){
	// 		$contributorList[$aKey->userstatisticskey] = new ContributorData();	
	// 		$contributorList[$aKey->userstatisticskey]->userstatisticskey = $aKey->userstatisticskey;
	// 		$followerCount = UserStatisticsDim::find($aKey->userstatisticskey)->followers_count;
	// 		$contributorList[$aKey->userstatisticskey]->followerCount = $followerCount;
	// 		if($followerCount>$maxFol){
	// 			$maxFol = $followerCount;
	// 			$maxUSKey = $aKey->userstatisticskey;
	// 		}
	// 	}
	// 	$maxFolUser = DB::table('user_statistics_dim')->where('userstatisticskey',$maxUSKey)
	// 					->join('user_dim','user_dim.userid','=','user_statistics_dim.userid')
	// 					->first();
	// 	$maxFollowerUser = ['count'=>$maxFol,'screenname'=>$maxFolUser->screenname,'pic'=>$maxFolUser->profile_pic_url];
	// 	// var_dump($topFollower);
	// 	// return View::make('blank_page');
		$sourceList = array();
		foreach($sourceKeyList as $aKey){
			$sourceList[$aKey->sourcekey] = 0;
		}
		$countActTweet = 0;
		$countActRetweet = 0;
		$countActReply = 0;
	// 	// $tweetInterestUser = array();
	// 	// $retweetInterestUser = array();
	// 	// $replyInterestUser = array();
		foreach($tweetResult as $tweet){
	// 		$aKey = $tweet->userstatisticskey;
			if($tweet->activitytypekey==1){//tweet
	// 			$contributorList[$aKey]->tweetCount+=1; 
				$countActTweet+=1;
	// 			// if($tweet->user->isinterested == "Yes"){
	// 			// 	foreach($tweet->user->groups as $aGroup){
	// 			// 		if(array_key_exists($aGroup->groupid, $tweetInterestUser)) $tweetInterestUser[$aGroup->groupid]+=1;
	// 			// 		else $tweetInterestUser[$aGroup->groupid]=1;
	// 			// 	}
	// 			// }
			} 
			else if($tweet->activitytypekey==2){//reply
	// 			$contributorList[$aKey]->replyCount+=1; 
				$countActReply+=1;
	// 			// if($tweet->user->isinterested == "Yes"){
	// 			// 	foreach($tweet->user->groups as $aGroup){
	// 			// 		if(array_key_exists($aGroup->groupid, $replyInterestUser)) $replyInterestUser[$aGroup->groupid]+=1;
	// 			// 		else $replyInterestUser[$aGroup->groupid]=1;
	// 			// 	}
	// 			// }
			} 
			else{//retweet
	// 			$contributorList[$aKey]->retweetCount+=1;
				$countActRetweet+=1;
	// 			// if($tweet->user->isinterested == "Yes"){
	// 			// 	foreach($tweet->user->groups as $aGroup){
	// 			// 		if(array_key_exists($aGroup->groupid, $retweetInterestUser)) $retweetInterestUser[$aGroup->groupid]+=1;
	// 			// 		else $retweetInterestUser[$aGroup->groupid]=1;
	// 			// 	}
	// 			// }
			}  
	// 		$contributorList[$aKey]->allActivityCount+=1;
			$sourceList[$tweet->sourcekey]+=1; 
		}
	// 	// echo "<pre>";
	// 	// var_dump($tweetInterestUser);
	// 	// var_dump($retweetInterestUser);
	// 	// var_dump($replyInterestUser);
	// 	// echo "</pre>";
	// 	// return View::make('blank_page');


	// 	$TwUserList = array();
	// 	$RtUserList = array();
	// 	$RpUserList = array();
	// 	$TwRtUserList = array();
	// 	$RtRpUserList = array();
	// 	$TwRpUserList = array();
	// 	$TwRtRpUserList = array();
	// 	usort($contributorList,"ContributorData::cmpByFollowerCountDesc");
	// 	reset($contributorList);
	// 	foreach($contributorList as $aUserStat){
	// 		$tweetFact = TwitterAnalysisFact::findTweetByUserStat($aUserStat->userstatisticskey);
	// 		$username = $tweetFact->user->screenname; 
	// 		$userDisplayStat = ['screenname'=>$username,
	// 							'tweetCount'=>$aUserStat->tweetCount,
	// 							'retweetCount'=>$aUserStat->retweetCount,
	// 							'replyCount'=>$aUserStat->replyCount,
	// 							'followerCount'=>$aUserStat->followerCount];
	// 		$TW = ($aUserStat->tweetCount > 0);
	// 		$RT = ($aUserStat->retweetCount > 0);
	// 		$RP = ($aUserStat->replyCount > 0);
	// 		if($TW){
	// 			array_push($TwUserList,$userDisplayStat);
	// 		}
	// 		if($RT){
	// 			array_push($RtUserList,$userDisplayStat);
	// 		}
	// 		if($RP){
	// 			array_push($RpUserList,$userDisplayStat);
	// 		}
	// 		if($TW or $RT){
	// 			array_push($TwRtUserList,$userDisplayStat);
	// 		}
	// 		if($TW or $RP){
	// 			array_push($TwRpUserList,$userDisplayStat);
	// 		}
	// 		if($RT or $RP){
	// 			array_push($RtRpUserList,$userDisplayStat);
	// 		}
	// 		if($TW or $RT or $RP){
	// 			array_push($TwRtRpUserList,$userDisplayStat);
	// 		}
	// 	}
	// 	$perPage = 10;
	// 	$TwUserList = array_chunk($TwUserList,$perPage);
	// 	$RtUserList = array_chunk($RtUserList,$perPage);	
	// 	$RpUserList = array_chunk($RpUserList,$perPage);
	// 	$TwRtUserList = array_chunk($TwRtUserList,$perPage);
	// 	$RtRpUserList = array_chunk($RtRpUserList,$perPage);
	// 	$TwRpUserList = array_chunk($TwRpUserList,$perPage);
	// 	$TwRtRpUserList = array_chunk($TwRtRpUserList,$perPage);
	// 	// var_dump($TwUserList);
	// 	// return View::make('blank_page');
	// 	usort($contributorList,"ContributorData::cmpByAllActivityCountDesc");
	// 	reset($contributorList);
	// 	// var_dump($contributorList);
	// 	// return View::make('blank_page');
	// 	$maxActUser = DB::table('user_statistics_dim')->where('userstatisticskey',$contributorList[0]->userstatisticskey)
	// 					->join('user_dim','user_dim.userid','=','user_statistics_dim.userid')
	// 					->first();
	// 	$maxActivityUser = ['count'=>$contributorList[0]->allActivityCount,'screenname'=>$maxActUser->screenname,'pic'=>$maxActUser->profile_pic_url];

		$sourceProportion = array();
		for($i = 1;$i<=5;$i+=1){
			if(sizeof($sourceList)==0) break;
			$maxs = array_keys($sourceList, max($sourceList));
			$sourceProportion[$i] = ['sourceName'=>SourceDim::find($maxs[0])->sourcename,
									'count'=>max($sourceList)];
			unset($sourceList[$maxs[0]]);
		}
		if(sizeof($sourceList)>0) {
			$sourceProportion[6] = ['sourceName'=>'Others',
									'count'=>array_sum($sourceList)];
		}

	// 	// ----- Statistics Tab -----
		
		$countAllContributor = sizeof($contributorKeyList);
		
		$countAct = ['tweet'=>$countActTweet,'retweet'=>$countActRetweet,'reply'=>$countActReply];

		$result = ['type'=>$input['type'],
					'caseID' => $caseID,
					'researchCase' => ResearchCaseDim::lists('name', 'researchcasekey'),
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'countAllTweet'=>$countAllTweet,
					'countAllContributor'=>$countAllContributor,
					'countAllImpression'=>$countAllImpression,
					'countAct'=> $countAct,
					'sourceProportion'=>$sourceProportion,
					'topRetweetedList'=>$topRetweetedList,
					'top10RetweetedList'=>$top10RetweetedList,
					// 'topFollowerList'=>$topFollowerList,
					'timelineList'=>$timelineList,
					// 'maxFollowerUser'=>$maxFollowerUser,
					// 'maxRetweetedUser' =>$maxRetweetedUser,
					// 'maxActivityUser'=>$maxActivityUser,
					// 'tweetMonth' => $tweetMonth,
					// 'tweetWeek' => $tweetWeek,
					// 'tweetDay' => $tweetDay,
					// 'tweetHour' => $tweetHour,
					// 'TwUserList'=>$TwUserList,
					// 'RtUserList'=>$RtUserList, 
					// 'RpUserList'=>$RpUserList, 
					// 'TwRtUserList'=>$TwRtUserList,
					// 'RtRpUserList'=>$RtRpUserList,
					// 'TwRpUserList'=>$TwRpUserList, 
					// 'TwRtRpUserList'=>$TwRtRpUserList,
					// 'perPage'=>$perPage,
					// 'tweetInterestDetailList'=>$tweetInterestDetailList,
					// 'retweetInterestDetailList'=>$retweetInterestDetailList,
					// 'replyInterestDetailList'=>$replyInterestDetailList,
					// 'totalGroupDetail'=>$totalGroup
				];
		// $result = $input;
		return View::make('layouts.mainResultByUser',$result);
	}
}
