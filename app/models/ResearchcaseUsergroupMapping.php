<?php

class ResearchcaseUsergroupMapping extends Eloquent
{
	protected $table = 'researchcase_usergroup_mapping';
	
	public $timestamps = false;

	public $errors;

	public static function deleteGroup($groupid){
		$affectedRows = ResearchcaseUsergroupMapping::where('groupid', '=', $groupid)->delete();
	}
	
}