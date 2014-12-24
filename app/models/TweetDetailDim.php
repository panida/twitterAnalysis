<?php

class TweetDetailDim extends Eloquent
{
	protected $table = 'tweet_detail_dim';
	
	public $timestamps = false;

	public $errors;

	protected $primaryKey = "tweetdetailkey";


}