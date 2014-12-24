<?php

class TwitterAnalysisFact extends Eloquent
{
	protected $table = 'twitter_analysis_fact';
	
	public $timestamps = false;

	public $errors;

	public static function searchByText($searchText,$startDate,$endDate){
		return DB::table('tweet_dim')
					->where('tweet_dim.text','LIKE','%'.$searchText.'%')
					->join('twitter_analysis_fact','twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey')
					->join('date_dim','twitter_analysis_fact.datekey','=','date_dim.datekey')
					->where('date_dim.thedate','>=',new DateTime($startDate))
					->where('date_dim.thedate','<=',new DateTime($endDate));

		// $desiredDate = DB::table('date_dim')
		// 					->where('date_dim.thedate','>=',new DateTime($startDate))
		// 					->where('date_dim.thedate','<=',new DateTime($endDate));
		// $desiredTweet= DB::table('tweet_dim')
		// 					->where('tweet_dim.text','LIKE','%'.$searchText.'%');
		// // return $desiredTweet;
		// return DB::table('twitter_analysis_fact')
		// 			->join($desiredTweet,'twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey')
		// 			->join($desiredDate,'twitter_analysis_fact.datekey','=','date_dim.datekey');

	} 

	public static function searchByUser($searchText,$startDate,$endDate){
		return DB::table('user_dim')
					->where('user_dim.name','LIKE','%'.$searchText.'%')
					->orWhere('user_dim.screenname','LIKE','%'.$searchText.'%')
					->join('twitter_analysis_fact','twitter_analysis_fact.userkey','=','user_dim.userkey')
					->join('date_dim','twitter_analysis_fact.datekey','=','date_dim.datekey')
					->where('date_dim.thedate','>=',new DateTime($startDate))
					->where('date_dim.thedate','<=',new DateTime($endDate));
		// return DB::table('twitter_analysis_fact')
		// 			->join('user_dim',function($join){
		// 				$join->on('twitter_analysis_fact.userkey','=','user_dim.userkey')
		// 					->where('user_dim.name','LIKE','%'.$searchText.'%')
		// 					->orWhere('user_dim.screenname','LIKE','%'.$searchText.'%');
		// 			})
		// 			->join('date_dim',function($join){
		// 				$join->on('twitter_analysis_fact.datekey','=','date_dim.datekey')
		// 					->where('date_dim.thedate','>=',new DateTime($startDate))
		// 					->where('date_dim.thedate','<=',new DateTime($endDate));
		// 			})
		// 			->get();
	} 
	public static function scopeFindOriginalTweet($query,$tweetkey){
   //      	var_dump($tweetkey);
			// return View::make('blank_page');
		return $query->where('tweetkey',$tweetkey)->where('activitytypekey',1)->orWhere('activitytypekey',2)->first();
		// return DB::table('twitter_analysis_fact')->where('tweetkey',$tweetkey)->where('activitytypekey',1)->first();
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