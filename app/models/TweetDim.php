<?php

class TweetDim extends Eloquent
{
	protected $table = 'tweet_dim';
	
	public $timestamps = false;

	public $errors;

	protected $primaryKey = "tweetkey";


	public function scopeSearchByText($query,$searchText){
		return $query->where('text','LIKE','%'.$searchText.'%');
	}



}