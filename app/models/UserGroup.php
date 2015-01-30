<?php

class UserGroup extends Eloquent
{
	protected $table = 'usergroup';
	protected $primaryKey = 'groupid';
	
	public $timestamps = false;

	public $errors;

	public static function saveGroup($input){
		$group = new UserGroup;
		$group->groupname = $input['name'];
		$group->description = $input['description'];
		$group->save();
	}

	public function users()
    {
        return $this->belongsToMany('UserDim', 'group_user_mapping', 'groupid', 'userkey');
    }
}