<?php

class DatabaseManagementController extends BaseController {
	public function saveGroupsOfCase(){
		$input = Input::all();
		$key = intval($input["researchcasekey"]);
		ResearchcaseUsergroupMapping::where('researchcasekey','=',intval($key))->delete();
		if(array_key_exists("interestingGroups", $input)){
			foreach ($input['interestingGroups'] as $group) {
				$keys = explode(",", $group);
				$mapping = new ResearchcaseUsergroupMapping;
				$mapping->researchcasekey = intval($keys[0]);
				$mapping->groupid = intval($keys[1]);
				$mapping->save();
			}
		}
		return Redirect::action('DatabaseManagementController@editGroupsOfCase')->with('notice', 'บันทึกสำเร็จ');
	}

	public function editGroupsOfCase(){
		$db = ResearchCaseDim::all();
		$userGroups = UserGroup::all();
		return View::make('management.databaseDetail',['db'=>$db, 'userGroups'=>$userGroups]);
	}
	
}