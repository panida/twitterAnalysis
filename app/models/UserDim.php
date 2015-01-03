<?php

class UserDim extends Eloquent
{
	protected $table = 'user_dim';
	protected $primaryKey = 'userkey';
	
	public $timestamps = false;

	public $errors;

	public function groups(){
		return $this->belongsToMany('UserGroup','GroupUserMapping','userkey','groupid');
	}





}