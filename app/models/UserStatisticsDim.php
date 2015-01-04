<?php

class UserStatisticsDim extends Eloquent
{
	protected $table = 'user_statistics_dim';
	
	public $timestamps = false;

	public $errors;

	protected $primaryKey = "userstatisticskey";

	public static function store($userid, $followers_count, $friends_count, $statuses_count){
		$userStat = new UserStatisticsDim;
		$userStat->userid = $userid;
		$userStat->followers_count = $followers_count;
		$userStat->friends_count = $friends_count;
		$userStat->statuses_count = $statuses_count;
		$userStat->updated_date = (new DateTime('now'))->format('Y-m-d H:i:s');
		$userStat->save();
	}



}