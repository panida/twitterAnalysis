<?php

class TwitterAnalysisFact extends Eloquent
{
	protected $table = 'twitter_analysis_fact';
	
	public $timestamps = false;

	public $errors;

	public static function searchByText($searchText,$startDate,$endDate,$caseID){
		return DB::table('tweet_dim')
					->where('tweet_dim.text','LIKE','%'.$searchText.'%')
					->leftJoin('twitter_analysis_fact','twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey')
					->where('twitter_analysis_fact.researchcasekey','=',$caseID)
					->leftJoin('date_dim','twitter_analysis_fact.datekey','=','date_dim.datekey')
					->where('date_dim.thedate','>=',new DateTime($startDate))
					->where('date_dim.thedate','<=',new DateTime($endDate));
	} 

	public static function searchByUser($searchText,$startDate,$endDate,$caseID){
		return DB::table('user_dim')
					->where('user_dim.name','=',$searchText)
					->orWhere('user_dim.screenname','=',$searchText)
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