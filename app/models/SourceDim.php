<?php

class SourceDim extends Eloquent
{
	protected $table = 'SourceDim';
	
	public $timestamps = false;

	public $errors;

	protected $primaryKey = "SourceKey";



}