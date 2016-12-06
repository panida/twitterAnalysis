<?php

class TwitterAnalysisFact extends Eloquent
{
	protected $table = 'twitter_analysis_fact';
	
	public $timestamps = false;

	public $errors;

	public static function createViewByText($searchText,$startDate,$endDate,$caseID){
		$now = new DateTime();
		$now = $now->getTimestamp();
		$startDate = new DateTime($startDate);
		$endDate = new DateTime($endDate);
		$viewName = "view_".$now;
		DB::statement('CREATE VIEW '.$viewName.' '.
						'AS SELECT twitter_analysis_fact.*, time_dim.hour as time_hour, '. 
						'date_dim.thedate as date_thedate, date_dim.year as date_year, date_dim.month as date_month, date_dim.date as date_date, '.
						'source_dim.sourcename as source_sourcename, source_dim.sourcetype as source_sourcetype, '.
						'activity_type_dim.activity_name as activity_type_activity_name, '.
						'tweet_detail_dim.created_at as tweet_detail_created_at, tweet_detail_dim.tweet_url as tweet_detail_tweet_url, tweet_detail_dim.tweetid as tweetid, '.
						'tweet_dim.text as tweet_text, tweet_dim.number_of_retweet as tweet_number_of_retweet, '.
						'user_dim.userid as user_userid, user_dim.name as user_name, user_dim.screenname as user_screenname, user_dim.url as user_url, user_dim.description as user_description, user_dim.created_at as user_created_at, user_dim.user_timeline_url as user_user_timeline_url, user_dim.profile_pic_url as user_profile_pic_url, '.
						'user_statistics_dim.followers_count as user_statistics_followers_count, user_statistics_dim.friends_count as user_statistics_friends_count, user_statistics_dim.statuses_count as user_statistics_statuses_count '.
						'FROM twitter_analysis_fact '.
						'inner join date_dim on twitter_analysis_fact.researchcasekey = '.$caseID.' AND twitter_analysis_fact.datekey = date_dim.datekey '.
						'AND date_dim.thedate >= "'.$startDate->format('Y-m-d').'" AND date_dim.thedate <= "'.$endDate->format('Y-m-d').'" '.
						'inner join tweet_dim on twitter_analysis_fact.tweetkey = tweet_dim.tweetkey AND tweet_dim.text LIKE "%'.$searchText.'%" '.
						'inner join time_dim on twitter_analysis_fact.timekey = time_dim.timekey '.
						'inner join activity_type_dim on twitter_analysis_fact.activitytypekey = activity_type_dim.activitytypekey '.
						'inner join tweet_detail_dim on twitter_analysis_fact.tweetdetailkey = tweet_detail_dim.tweetdetailkey '.
						'inner join user_statistics_dim on twitter_analysis_fact.userstatisticskey = user_statistics_dim.userstatisticskey '.
						'inner join user_dim on twitter_analysis_fact.userkey = user_dim.userkey '.
						'inner join source_dim on twitter_analysis_fact.sourcekey = source_dim.sourcekey');
		return $viewName;
	}

	public static function searchByText($searchTexts,$startDate,$endDate,$caseID,$operation){
		// return DB::table('tweet_dim')
		// 			->where('tweet_dim.text','LIKE','%'.$searchText.'%')
		// 			->leftJoin('twitter_analysis_fact','twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey')
		// 			->where('twitter_analysis_fact.researchcasekey','=',$caseID)
		// 			->leftJoin('date_dim','twitter_analysis_fact.datekey','=','date_dim.datekey')
		// 			->where('date_dim.thedate','>=',new DateTime($startDate))
		// 			->where('date_dim.thedate','<=',new DateTime($endDate));

		$textQueryBuilder =  DB::table('twitter_analysis_fact')
							->where('twitter_analysis_fact.researchcasekey','=',$caseID)
							->join('date_dim','twitter_analysis_fact.datekey','=','date_dim.datekey')
							->where('date_dim.thedate','>=',new DateTime($startDate))
							->where('date_dim.thedate','<=',new DateTime($endDate))
							->join('tweet_dim','twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey');
		$textQueryBuilder = $textQueryBuilder->where(function($query) use($searchTexts,$operation){
			$iter = 1;
			foreach ($searchTexts as $searchText) {
				if($iter==1 or $operation==" and "){
					$query = $query->where('tweet_dim.text','LIKE','%'.$searchText.'%');
				}
				else{
					$query = $query->orwhere('tweet_dim.text','LIKE','%'.$searchText.'%');
				}
				$iter +=1;
			}
		});
		
		return $textQueryBuilder;
					
					
	} 

	public static function searchByUser($searchText,$startDate,$endDate,$caseID){
		return DB::table('user_dim')
					->where(function($query) use($searchText)
			            {
			                $query->where('user_dim.name','=',$searchText)
							->orWhere('user_dim.screenname','=',$searchText);
			            })
					// ->where('user_dim.name','=',$searchText)
					// ->orWhere('user_dim.screenname','=',$searchText)
					->leftJoin('twitter_analysis_fact','twitter_analysis_fact.userkey','=','user_dim.userkey')
					->where('twitter_analysis_fact.researchcasekey','=',$caseID)
					->leftJoin('date_dim','twitter_analysis_fact.datekey','=','date_dim.datekey')
					->where('date_dim.thedate','>=',new DateTime($startDate))
					->where('date_dim.thedate','<=',new DateTime($endDate));
	} 
	
	public static function scopeFindOriginalTweet($query,$tweetkey){
		return $query->where('tweetkey',$tweetkey)->where('activitytypekey',1)->orWhere('activitytypekey',2)->first();
	}
	
	public static function scopeFindTweetByUserStat($query,$userstatisticskey){
		return $query->where('userstatisticskey',$userstatisticskey)->first();
	}

	//$this->belongsTo(table,local_key,parent_key);
	public function text(){
		return $this->belongsTo('TweetDim','tweetkey','tweetkey');
	}

	public function user(){
		return $this->belongsTo('UserDim','userkey','userkey');
	}

	public function date(){
		return $this->belongsTo('DateDim','datekey','datekey');
	}

	public function time(){
		return $this->belongsTo('TimeDim','timekey','timekey');
	}

	public function tweetdetail(){
		return $this->belongsTo('TweetDetailDim','tweetdetailkey','tweetdetailkey');
	}

	public function source(){
		return $this->belongsTo('SourceDim','sourcekey','sourcekey');
	}



}
