<?php

class TwitterAnalysisFact extends Eloquent
{
	protected $table = 'TwitterAnalysisFact';
	
	public $timestamps = false;

	public $errors;

	public static function searchByText($searchText,$startDate,$endDate){
		return DB::table('TwitterAnalysisFact')
					->join('TweetDim','TwitterAnalysisFact.TweetKey','=','TweetDim.TweetKey')
					->where('TweetDim.text','LIKE','%'.$searchText.'%')
					->join('DateDim','TwitterAnalysisFact.DateKey','=','DateDim.DateKey')
					->where('DateDim.TheDate','>=',new DateTime($startDate))
					->where('DateDim.TheDate','<=',new DateTime($endDate));

		$desiredDate = DB::table('DateDim')
							->where('DateDim.TheDate','>=',new DateTime($startDate))
							->where('DateDim.TheDate','<=',new DateTime($endDate));
		$desiredTweet= DB::table('TweetDim')
							->where('TweetDim.text','LIKE','%'.$searchText.'%');
		// return $desiredTweet;
		return DB::table('TwitterAnalysisFact')
					->join($desiredTweet,'TwitterAnalysisFact.TweetKey','=','TweetDim.TweetKey')
					->join($desiredDate,'TwitterAnalysisFact.DateKey','=','DateDim.DateKey');

	} 

	public static function scopeSearchByUser($searchText,$startDate,$endDate){
		return DB::table('TwitterAnalysisFact')
					->join('UserDim',function($join){
						$join->on('TwitterAnalysisFact.UserKey','=','UserDim.UserKey')
							->where('UserDim.name','LIKE','%'.$searchText.'%')
							->orWhere('UserDim.screenname','LIKE','%'.$searchText.'%');
					})
					->join('DateDim',function($join){
						$join->on('TwitterAnalysisFact.DateKey','=','DateDim.DateKey')
							->where('DateDim.TheDate','>=',new DateTime($startDate))
							->where('DateDim.TheDate','<=',new DateTime($endDate));
					})
					->get();
	} 
	//$this->belongsTo(table,local_key,parent_key);
	public function text(){
		return $this->belongsTo('TweetDim','TweetKey','TweetKey');
	}

	public function user(){
		return $this->belongsTo('UserDim','UserKey','UserKey');
	}

	public function date(){
		return $this->belongsTo('DateDim','DateKey','DateKey');
	}



}