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
		$tweetOriginalKeyList = $tweetResultList->select('TwitterAnalysisFact.TweetKey')->distinct()->get();
		$contributorKeyList = $tweetResultList->select('TwitterAnalysisFact.UserStatisticsKey')->distinct()->get();

		$contributorList = array();
		foreach($contributorKeyList as $aKey){
			$contributorList[$aKey->UserStatisticsKey] = new ContributorData();			
			$followerCount = UserStatisticsDim::find($aKey->UserStatisticsKey)->followers_count;
			$contributorList[$aKey->UserStatisticsKey]->followerCount = $followerCount;

		}
		foreach($tweetResult as $tweet){
			$aKey = $tweet->UserStatisticsKey;
			if($tweet->ActivityTypeKey==1) $contributorList[$aKey]->tweetCount+=1; //tweet
			else if($tweet->ActivityTypeKey==2) $contributorList[$aKey]->replyCount+=1; //reply
			else $contributorList[$aKey]->retweetCount+=1; //retweet
		}

		// var_dump($aKey);
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
		$countAllTweet = sizeof($tweetResult);
		$countAllContributor = sizeof($contributorList);
		// var_dump($countAllTweet);
		// return View::make('blank_page');
		$result = ['type'=>$input['type'],
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'countAllTweet'=>$countAllTweet,
					'countAllContributor'=>$countAllContributor];
		// $result = $input;
		return View::make('layouts.mainResult',$result);
		// return Redirect::to('result/statistics')->with('result',$result);
		// return View::make('result.statistics',$result);
	}
}
