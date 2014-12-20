<?php

class TweetDim extends Eloquent
{
	protected $table = 'TweetDim';
	
	public $timestamps = false;

	public $errors;

	public function scopeAvailableItem($query){
		return $query->where('quantity','>','0')
			->where(function ($query) {
				$query->where('endDateTime', '>', new DateTime('now'))
					->orWhere('endDateTime', '=', null);
				})
			->orderBy('id', 'desc');
	}


	public function scopeSearchByText($query,$searchText){
		return $query->where('text','LIKE','%'.$searchText.'%');
	}



}