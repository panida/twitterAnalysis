<?php

class SourceDim extends Eloquent
{
	protected $table = 'SourceDim';
	
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