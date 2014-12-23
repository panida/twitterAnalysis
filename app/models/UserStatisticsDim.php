<?php

class UserStatisticsDim extends Eloquent
{
	protected $table = 'user_statistics_dim';
	
	public $timestamps = false;

	public $errors;

	protected $primaryKey = "userstatisticskey";



}