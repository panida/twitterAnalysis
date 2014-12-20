<?php

class UserStatisticsDim extends Eloquent
{
	protected $table = 'UserStatisticsDim';
	
	public $timestamps = false;

	public $errors;

	protected $primaryKey = "UserStatisticsKey";



}