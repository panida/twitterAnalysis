<?php

class TwitterAnalysisFact extends Eloquent
{
	protected $table = 'TwitterAnalysisFact';
	
	public $timestamps = false;

	public $errors;

	public static function searchByText($searchText,$startDate,$endDate){
		return DB::table('TweetDim')
					->where('TweetDim.text','LIKE','%'.$searchText.'%')
					->join('TwitterAnalysisFact','TwitterAnalysisFact.TweetKey','=','TweetDim.TweetKey')
					->join('DateDim','TwitterAnalysisFact.DateKey','=','DateDim.DateKey')
					->where('DateDim.TheDate','>=',new DateTime($startDate))
					->where('DateDim.TheDate','<=',new DateTime($endDate));

		// $desiredDate = DB::table('DateDim')
		// 					->where('DateDim.TheDate','>=',new DateTime($startDate))
		// 					->where('DateDim.TheDate','<=',new DateTime($endDate));
		// $desiredTweet= DB::table('TweetDim')
		// 					->where('TweetDim.text','LIKE','%'.$searchText.'%');
		// // return $desiredTweet;
		// return DB::table('TwitterAnalysisFact')
		// 			->join($desiredTweet,'TwitterAnalysisFact.TweetKey','=','TweetDim.TweetKey')
		// 			->join($desiredDate,'TwitterAnalysisFact.DateKey','=','DateDim.DateKey');

	} 

	public static function searchByUser($searchText,$startDate,$endDate){
		return DB::table('UserDim')
					->where('UserDim.name','LIKE','%'.$searchText.'%')
					->orWhere('UserDim.screenname','LIKE','%'.$searchText.'%')
					->join('TwitterAnalysisFact','TwitterAnalysisFact.UserKey','=','UserDim.UserKey')
					->join('DateDim','TwitterAnalysisFact.DateKey','=','DateDim.DateKey')
					->where('DateDim.TheDate','>=',new DateTime($startDate))
					->where('DateDim.TheDate','<=',new DateTime($endDate));
		// return DB::table('TwitterAnalysisFact')
		// 			->join('UserDim',function($join){
		// 				$join->on('TwitterAnalysisFact.UserKey','=','UserDim.UserKey')
		// 					->where('UserDim.name','LIKE','%'.$searchText.'%')
		// 					->orWhere('UserDim.screenname','LIKE','%'.$searchText.'%');
		// 			})
		// 			->join('DateDim',function($join){
		// 				$join->on('TwitterAnalysisFact.DateKey','=','DateDim.DateKey')
		// 					->where('DateDim.TheDate','>=',new DateTime($startDate))
		// 					->where('DateDim.TheDate','<=',new DateTime($endDate));
		// 			})
		// 			->get();
	} 
	public static function findOriginalTweet($TweetKey){
   //      	var_dump($TweetKey);
			// return View::make('blank_page');
		return DB::table('TwitterAnalysisFact')->where('TweetKey',$TweetKey)->where('ActivityTypeKey',1)->first();
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

	public function time(){
		return $this->belongsTo('TimeDim','TimeKey','TimeKey');
	}

	public function source(){
		return $this->belongsTo('SourceDim','SourceKey','SourceKey');
	}



}