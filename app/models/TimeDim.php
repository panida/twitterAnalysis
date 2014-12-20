<?php

class TimeDim extends Eloquent
{
	protected $table = 'TimeDim';
	
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



}