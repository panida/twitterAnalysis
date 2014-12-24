<?php

class SourceDim extends Eloquent
{
	protected $table = 'source_dim';
	
	public $timestamps = false;

	public $errors;

	protected $primaryKey = "sourcekey";



}