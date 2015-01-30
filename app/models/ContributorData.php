<?php

class ContributorData
{
	public $userStatisticsKey;
	public $tweetCount=0;
	public $retweetCount=0;
	public $replyCount=0;
	public $allActivityCount=0;
	public $followerCount=0;
	public function __counstruct(){
		return $this;
	}
	public static function cmpByAllActivityCountDesc(ContributorData $a, ContributorData $b){
		if($a->allActivityCount==$b->allActivityCount) return 0;
		else return ($a->allActivityCount<$b->allActivityCount)? 1:-1; 
	} 
	public static function cmpByFollowerCountDesc(ContributorData $a, ContributorData $b){
		if($a->followerCount==$b->followerCount) return 0;
		else return ($a->followerCount<$b->followerCount)? 1:-1; 
	} 
}