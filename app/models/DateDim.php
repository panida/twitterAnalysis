<?php

class DateDim extends Eloquent
{
	protected $table = 'date_dim';
	
	public $timestamps = false;

	public $errors;

	// WHERE order_date >= TO_DATE('2003/01/01', 'yyyy/mm/dd')
	// AND order_date <= TO_DATE('2003/12/31','yyyy/mm/dd');

	public function scopeSearchTweetInRange($query,$startDate,$endDate){
		return $query->where('thedate','>=', date('Y-m-d',$startDate))->where('thedate','<=', date('Y-m-d',$endDate))->twitterFact();
	}

	public function scopeSearchOriginalTweetInRange($query,$startDate,$endDate){
		return $query->where('thedate','>=', date('Y-m-d',$startDate))->where('thedate','<=', date('Y-m-d',$endDate))->originalTwitterFact();
	}

	//$this->hasMany('Comment', 'foreign_key', 'local_key');
	public function twitterFact(){
		return $this->hasMany('TwitterAnalysisFact','datekey','datekey');
	}


}