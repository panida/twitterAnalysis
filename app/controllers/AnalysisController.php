<?php

class AnalysisController extends BaseController {

	public function groupTweetForTweetGraph($allTweetQuery, $startDate,$endDate, &$tweetGroupByMonth, &$tweetGroupByWeek, &$tweetGroupByDay, &$tweetGroupByHour){
		$allTweetQuery = $allTweetQuery
			->select(DB::raw('
				count(*) as num_of_activity,
				date_dim.date, date_dim.month,
				date_dim.year,time_dim.hour'))
			->join('time_dim', 'twitter_analysis_fact.timekey', '=', 'time_dim.timekey')
			->groupBy('date_dim.year', 'date_dim.month', 'date_dim.date','time_dim.hour')
			->orderBy('date_dim.year','ASC')
			->orderBy('date_dim.month','ASC')
			->orderBy('date_dim.date','ASC')
			->orderBy('time_dim.hour','ASC');
		$tweetGroup = $allTweetQuery->get();
		//$allTweetByDay = $allTweetByHour->groupBy('date_dim.date', 'date_dim.month', 'date_dim.year');
		//echo $startDate;
		$startDate = Carbon::createFromFormat('Y-m-d H:i:s',$startDate." 00:00:00");
		//echo $startDate->toDateTimeString();
		$endDate = Carbon::createFromFormat('Y-m-d H:i:s',$endDate." 23:00:00");
		$sizeOfTweetGroup = sizeof($tweetGroup);
		$currentResultIndex = 0;
		$currentDate = clone $startDate;
		$currentSize = 0;
		while($currentDate->diffInHours($endDate,false) >= 0){
			array_push($tweetGroupByHour, array(
				"dateTime" => clone $currentDate,
				"year" => $currentDate->year,
				"month" => $currentDate->month,
				"day"	=> $currentDate->day,
				"hour"	=> $currentDate->hour,
				"num_of_activity" => 0
			));
			if($currentResultIndex < $sizeOfTweetGroup && 
				$tweetGroup[$currentResultIndex]->year == $currentDate->year && 
				$tweetGroup[$currentResultIndex]->month == $currentDate->month && 
				$tweetGroup[$currentResultIndex]->date == $currentDate->day && 
				$tweetGroup[$currentResultIndex]->hour == $currentDate->hour){
				$tweetGroupByHour[$currentSize]["num_of_activity"] =  $tweetGroup[$currentResultIndex]->num_of_activity;
				$currentResultIndex+=1;
			}
			$currentDate = $currentDate->addHour();
			$currentSize+=1;
		}
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
			while($currentGroupInHourInx < $sizeOfTweetGroup && 
				$currentDate->diffInDays($tweetGroupByHour[$currentGroupInHourInx]["dateTime"])==0){
				$tweetGroupByDay[$currentSize]["num_of_activity"] += $tweetGroupByHour[$currentGroupInHourInx]["num_of_activity"];
				$currentGroupInHourInx += 1;
			}
			$currentDate=$currentDate->addDay();
			$currentSize += 1;
		}

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
			while($currentGroupInDayInx < $sizeOfTweetGroup && 
				$currentDate->diffInMonths($tweetGroupByDay[$currentGroupInDayInx]["dateTime"])==0){
				$tweetGroupByMonth[$currentSize]["num_of_activity"] += $tweetGroupByDay[$currentGroupInDayInx]["num_of_activity"];
				$currentGroupInDayInx += 1;
			}
			$currentDate=$currentDate->addMonth();
			$currentSize += 1;
		}

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
				"startDateTime" => $startDateTime,
				"endDateTime" => $endDateTime->endOfWeek(),
				"year" => $currentDate->year,
				"month" => $currentDate->month,
				"num_of_activity" => 0
			));
			while($currentGroupInDayInx < $sizeOfTweetGroup && 
				$currentDate->diffInWeeks($tweetGroupByDay[$currentGroupInDayInx]["dateTime"])==0){
				$tweetGroupByWeek[$currentSize]["num_of_activity"] += $tweetGroupByDay[$currentGroupInDayInx]["num_of_activity"];
				$currentGroupInDayInx += 1;
			}
			$currentDate=$currentDate->addWeek();
			$currentSize += 1;
		}
	}

	public function analyse()
	{
		$input = Input::all();
		$searchText = $input['searchText'];
		$startDate = $input['startDate'];
		$endDate = $input['endDate'];
		if($input['type']=='text'){
			$tweetResultList = TwitterAnalysisFact::searchByText($searchText,$startDate,$endDate);
		}
		else{
			$tweetResultList = TwitterAnalysisFact::searchByUser($searchText,$startDate,$endDate);
		}
		
		$tweetResult = $tweetResultList->get();

		//Prepare Data for tweet graph
		$allTweetQuery = clone $tweetResultList;
		$tweetGroupByMonth = array();
		$tweetGroupByWeek = array();
		$tweetGroupByDay = array();
		$tweetGroupByHour = array();
		AnalysisController::groupTweetForTweetGraph($allTweetQuery,$startDate,$endDate,$tweetGroupByMonth,$tweetGroupByWeek,$tweetGroupByDay,$tweetGroupByHour);


		$countAllTweet = sizeof($tweetResult);
		if($countAllTweet==0){
			$result = ['type'=>$input['type'],
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'countAllTweet'=>$countAllTweet];
			return View::make('layouts.notFound',$result);
		}
		$countAllImpression = $tweetResultList->sum('twitter_analysis_fact.number_of_follower');
		$tweetOriginalKeyList = $tweetResultList->select('twitter_analysis_fact.tweetkey')->distinct()->get();
		$contributorKeyList = $tweetResultList->select('twitter_analysis_fact.userstatisticskey')->distinct()->get();
		$sourceKeyList = $tweetResultList->select('twitter_analysis_fact.sourcekey')->distinct()->get();
		$countRetweetTime = $tweetResultList->where('twitter_analysis_fact.activitytypekey','=','3')
                 ->select('twitter_analysis_fact.tweetkey', DB::raw('count(*) as totalRetweet'))
                 ->groupBy('twitter_analysis_fact.tweetkey')
                 ->orderBy('totalRetweet','desc')
                 ->get();

  //       var_dump($countAllActivity);
		// return View::make('blank_page');
        //cannot join itself -- duplicate field

        $topRetweetedList = array();
        $i = 0;
        $retweetedCountOfUser = array();
        foreach($countRetweetTime as $aTweet){
   //      	var_dump($aTweet->Tweetkey);
			// return View::make('blank_page');
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
		foreach($tweetResult as $tweet){
			$aKey = $tweet->userstatisticskey;
			if($tweet->activitytypekey==1){//tweet
				$contributorList[$aKey]->tweetCount+=1; 
				$countActTweet+=1;
			} 
			else if($tweet->activitytypekey==2){//reply
				$contributorList[$aKey]->replyCount+=1; 
				$countActReply+=1;
			} 
			else{//retweet
				$contributorList[$aKey]->retweetCount+=1;
				$countActRetweet+=1;
				// if(array_key_exists($tweet->TweetKey, $countRetweetTime))
				// 	$countRetweetTime[$tweet->TweetKey]+=1;
				// else $countRetweetTime[$tweet->TweetKey] = 1;
			}  
			$contributorList[$aKey]->allActivityCount+=1;
			$sourceList[$tweet->sourcekey]+=1; 
		}
		// var_dump($contributorList);
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
		// var_dump($tweetResult);
		// return View::make('blank_page');

		// ----- Statistics Tab -----
		
		$countAllContributor = sizeof($contributorList);
		
		$countAct = ['tweet'=>$countActTweet,'retweet'=>$countActRetweet,'reply'=>$countActReply];

		$result = ['type'=>$input['type'],
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
					'maxFollowerUser'=>$maxFollowerUser,
					'maxRetweetedUser' =>$maxRetweetedUser,
					'maxActivityUser'=>$maxActivityUser,
					'tweetGroupByMonth' => $tweetGroupByMonth,
					'tweetGroupByWeek' => $tweetGroupByWeek,
					'tweetGroupByDay' => $tweetGroupByDay,
					'tweetGroupByHour' => $tweetGroupByHour
				];
		// $result = $input;
		return View::make('layouts.mainResult',$result);
	}
}
