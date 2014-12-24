<?php

class AnalysisController extends BaseController {

	public static function paginateArray($data, $perPage, $page = null)
	{
	    $page = $page ? (int) $page * 1 : (isset($_REQUEST['page']) ? (int) $_REQUEST['page'] * 1 : 1);
	    $offset = ($page * $perPage) - $perPage;
	    return Paginator::make(array_slice($data, $offset, $perPage, true), count($data), $perPage);
	}

	protected function paginateResults(array $results, $perPage = 0, $page = 0)
	{
		$page = ($page) ? $page : Input::get('page');
		$perPage = ($perPage) ? $perPage : $this->perPage;
		$pagedResults = array_chunk($results, $perPage);
		return Paginator::make($resultPages[$thisPage], count($results), $perPage);
	}

	public static function paginateData(){
		$perPage = 10;
		$currentPage = Input::get('page') - 1;
		$pagedData = array_slice($TwUserList, $currentPage * $perPage, $perPage);
		$TwUserListPaginate = Paginator::make($pagedData, count($TwUserList), $perPage);
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
					'TwUserList'=>$TwUserList,
					'RtUserList'=>$RtUserList, 
					'RpUserList'=>$RpUserList, 
					'TwRtUserList'=>$TwRtUserList,
					'RtRpUserList'=>$RtRpUserList,
					'TwRpUserList'=>$TwRpUserList, 
					'TwRtRpUserList'=>$TwRtRpUserList,
					'perPage'=>$perPage
				];
		// $result = $input;
		return View::make('layouts.mainResult',$result);
	}
}
