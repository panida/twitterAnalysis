<?php

class AnalysisController extends BaseController {

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
		$countAllImpression = $tweetResultList->sum('TwitterAnalysisFact.numberOfFollower');
		$tweetOriginalKeyList = $tweetResultList->select('TwitterAnalysisFact.TweetKey')->distinct()->get();
		$contributorKeyList = $tweetResultList->select('TwitterAnalysisFact.UserStatisticsKey')->distinct()->get();
		$sourceKeyList = $tweetResultList->select('TwitterAnalysisFact.SourceKey')->distinct()->get();
		$countRetweetTime = $tweetResultList->where('TwitterAnalysisFact.ActivityTypeKey','=','3')
                 ->select('TwitterAnalysisFact.TweetKey', DB::raw('count(*) as totalRetweet'))
                 ->groupBy('TwitterAnalysisFact.TweetKey')
                 ->get();
  //       var_dump($countAllActivity);
		// return View::make('blank_page');
        //cannot join itself -- duplicate field
                /*
        $topRetweetedList = array();
        $i = 0;
        foreach($countRetweetTime as $aTweet){
   //      	var_dump($aTweet->TweetKey);
			// return View::make('blank_page');
        	$originalTweetFact = TwitterAnalysisFact::findOriginalTweet($aTweet->TweetKey);
        	var_dump($originalTweetFact->TweetKey);
			return View::make('blank_page');
        	$user = $originalTweetFact->user();
        	$date = $originalTweetFact->date();
        	$time = $originalTweetFact->time();
        	$source = $originalTweetFact->source()->SourceName;
        	$text = TweetDim::find($aTweet->TweetKey)->text;
        	$topRetweetedList[$i] = ['tweetkey'=>$aTweet->TweetKey,
        								'text'=>$text,
        								'date'=>$date,
        								'time'=>$time,
        								'user'=>$user,
        								'retweetCount' => $aTweet->totalRetweet
									];
			$i++;
        }*/
  		
		// $countRetweetTime = array();
		$contributorList = array();
		$maxFol = -1;
		$maxUSKey = 0;
		foreach($contributorKeyList as $aKey){
			$contributorList[$aKey->UserStatisticsKey] = new ContributorData();	
			$contributorList[$aKey->UserStatisticsKey]->userStatisticsKey = $aKey->UserStatisticsKey;
			$followerCount = UserStatisticsDim::find($aKey->UserStatisticsKey)->followers_count;
			$contributorList[$aKey->UserStatisticsKey]->followerCount = $followerCount;
			if($followerCount>$maxFol){
				$maxFol = $followerCount;
				$maxUSKey = $aKey->UserStatisticsKey;
			}
		}
		$maxFolUser = DB::table('UserStatisticsDim')->where('UserStatisticsKey',$maxUSKey)
						->join('UserDim','UserDim.userID','=','UserStatisticsDim.userID')
						->first();
		$maxFollowerUser = ['count'=>$maxFol,'screenname'=>$maxFolUser->screenname,'pic'=>$maxFolUser->ProfilePicURL];
		// var_dump($topFollower);
		// return View::make('blank_page');
		$sourceList = array();
		foreach($sourceKeyList as $aKey){
			$sourceList[$aKey->SourceKey] = 0;
		}
		$countActTweet = 0;
		$countActRetweet = 0;
		$countActReply = 0;
		foreach($tweetResult as $tweet){
			$aKey = $tweet->UserStatisticsKey;
			if($tweet->ActivityTypeKey==1){//tweet
				$contributorList[$aKey]->tweetCount+=1; 
				$countActTweet+=1;
			} 
			else if($tweet->ActivityTypeKey==2){//reply
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
			$sourceList[$tweet->SourceKey]+=1; 
		}
		// var_dump($contributorList);
		// return View::make('blank_page');
		usort($contributorList,"ContributorData::cmpByAllActivityCountDesc");
		reset($contributorList);
		// var_dump($contributorList);
		// return View::make('blank_page');
		$maxActUser = DB::table('UserStatisticsDim')->where('UserStatisticsKey',$contributorList[0]->userStatisticsKey)
						->join('UserDim','UserDim.userID','=','UserStatisticsDim.userID')
						->first();
		$maxActivityUser = ['count'=>$contributorList[0]->allActivityCount,'screenname'=>$maxActUser->screenname,'pic'=>$maxActUser->ProfilePicURL];

		$sourceProportion = array();
		for($i = 1;$i<=5;$i+=1){
			if(sizeof($sourceList)==0) break;
			$maxs = array_keys($sourceList, max($sourceList));
			$sourceProportion[$i] = ['sourceName'=>SourceDim::find($maxs[0])->SourceName,
									'count'=>max($sourceList)];
			unset($sourceList[$maxs[0]]);
		}
		if(sizeof($sourceList)>0) {
			$sourceProportion[6] = ['sourceName'=>'Others',
									'count'=>array_sum($sourceList)];
		}
		// var_dump($tweetResult);
		// return View::make('blank_page');

		// $tweetInRange = DateDim::searchTweetInRange($input['startDate'],$input['endDate']);
		// $tweetResultList = array();
		// if($input['type']=='text'){
		// 	for($tweetInRange as $tweet){
		// 		$pos = strpos($tweet->text()->text,$searchText);
		// 		if($pos!==false) array_push($tweetResultList,$tweet);
		// 	}
		// }
		// else{
		// 	for($tweetInRange as $tweet){
		// 		$pos1 = strpos($tweet->user()->name,$searchText);
		// 		if($pos1!==false) array_push($tweetResultList,$tweet);
		// 		else{
		// 			$pos2 = strpos($tweet->user()->screenname,$searchText);
		// 			if($pos2!==false) array_push($tweetResultList,$tweet);
		// 		}
		// 	}
		// }

		// ----- Statistics Tab -----
		$countAllTweet = sizeof($tweetResult);
		$countAllContributor = sizeof($contributorList);
		
		$countAct = ['tweet'=>$countActTweet,'retweet'=>$countActRetweet,'reply'=>$countActReply];
		// arsort($countRetweetTime);
		// $topRetweetedList = array();
		// foreach($countRetweetTime as $anOriginalTweet){
		// 	$topRetweetedList[]
		// }
  		// var_dump($sourceProportion);
		// return View::make('blank_page');
		// var_dump($countActTweet);
		// var_dump($countActRetweet);
		// var_dump($countActReply);
		// return View::make('blank_page');
		$result = ['type'=>$input['type'],
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'countAllTweet'=>$countAllTweet,
					'countAllContributor'=>$countAllContributor,
					'countAllImpression'=>$countAllImpression,
					'countAct'=> $countAct,
					'sourceProportion'=>$sourceProportion,
					// 'topRetweetedList'=>$topRetweetedList,
					'maxFollowerUser'=>$maxFollowerUser,
					'maxActivityUser'=>$maxActivityUser
				];
		// $result = $input;
		return View::make('layouts.mainResult',$result);
	}
}
