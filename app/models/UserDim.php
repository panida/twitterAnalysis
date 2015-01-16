<?php

class UserDim extends Eloquent
{
	protected $table = 'user_dim';
	protected $primaryKey = 'userkey';
	
	public $timestamps = false;

	public $errors;

	public function groups(){
		return $this->belongsToMany('usergroup','group_user_mapping','userkey','groupid');
	}

	public static function convertDateTimeFormat($date){
		echo $dateCut = substr($date,4,15).' '.substr($date,26,4);

		$format = 'M d H:i:s Y';
		$date = DateTime::createFromFormat($format, $dateCut);
		return $date;
	}

	public static function storeFromTwitterAPI($userId, $name, $screenname, $location, $url, $description, $created_at, $time_zone, $utc_offset, $lang, $profile_pic_url){
		$user = new UserDim;
		$user->userid = $userId;
		$user->name = $name;
		$user->screenname = $screenname;
		$user->location = $location;
		$user->url = $url;
		$user->description = $description;
		$user->created_at = UserDim::convertDateTimeFormat($created_at);
		$user->time_zone = $time_zone;
		$user->utc_offset = $utc_offset;
		$user->lang = $lang;
		$user->user_timeline_url = "https://twitter.com/".$screenname;
		$user->profile_pic_url = $profile_pic_url;
		$user->save();
		return $user->userkey;
	}

	public function userStatus()
    {
        return $this->hasOne('FolloweeProcessedUser','userkey','userkey');
    }


}