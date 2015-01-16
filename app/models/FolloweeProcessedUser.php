<?php

class FolloweeProcessedUser extends Eloquent
{
	protected $table = 'followee_processed_user';
	
	public $timestamps = false;

	public $errors;

	protected $primaryKey = "userkey";

	public function user()
    {
        return $this->hasOne('UserDim','userkey','userkey');
    }
}