<?php

class TweetDim extends Eloquent
{
	protected $table = 'TweetDim';
	
	public $timestamps = false;

	public $errors;

	protected $primaryKey = "TweetKey";


	public function scopeSearchByText($query,$searchText){
		return $query->where('text','LIKE','%'.$searchText.'%');
	}



}