<?php

class FolloweeMapping extends Eloquent
{
	protected $table = 'followee_mapping';
	
	public $timestamps = false;

	public $errors;
}