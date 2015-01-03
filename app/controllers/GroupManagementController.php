<?php

class GroupManagementController extends BaseController {
	
	public function createGroup(){
		$groups = UserGroup::all();
		$memberCount = array();
		foreach($groups as $group){
			$memberCount[$group->groupid] = $group->users->count();
		}
		return View::make('management.addGroup',['groups'=>$groups,'memberCount'=>$memberCount]);
	}

	public function addGroup(){
		$input = Input::all();
		$rules = array('name' => 'unique:usergroup,groupname');
		
		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
		    return Redirect::action('GroupManagementController@createGroup')->with('error', 'ชื่อกลุ่มนี้ถูกใช้แล้ว');
		}
		else {
			UserGroup::saveGroup($input);
		    return Redirect::action('GroupManagementController@createGroup')->with('notice', 'บันทึกสำเร็จ');
		}
	}

	public function createMembersOfGroup($id){
		$groupDetail = UserGroup::find($id);
		$members = $groupDetail->users;
		$groups = UserGroup::all();
		$memberCount = array();
		foreach($groups as $group){
			$memberCount[$group->groupid] = $group->users->count();
		}
		return View::make('management.editGroup',['groupDetail'=>$groupDetail, 'members'=>$members, 'groups'=>$groups,'memberCount'=>$memberCount]);
	}

	public function editGroup($id){
		$input = Input::all();
		$group = UserGroup::find($id);
		if($input['name']==$group->groupname){
			$group->description = $input['description'];
			$group->save();
			return Redirect::to('/group/'.$id)->with('notice', 'บันทึกสำเร็จ');
		}
		else{
			$rules = array('name' => 'unique:usergroup,groupname');
			$validator = Validator::make($input, $rules);
			if ($validator->fails()) {
			    return Redirect::to('/group/'.$id)->with('error', 'ชื่อกลุ่มนี้ถูกใช้แล้ว');
			}
			else {
				$group->groupname = $input['name'];
				$group->description = $input['description'];
				$group->save();
			    return Redirect::to('/group/'.$id)->with('notice', 'บันทึกสำเร็จ');
			}
		}
	}

	public function deleteGroup($groupid){
		GroupUserMapping::where('groupid', '=', $groupid)->delete();
		UserGroup::find($groupid)->delete();
		return Redirect::action('GroupManagementController@createGroup')->with('notice', 'ลบกลุ่มสำเร็จ');
	}

	public function deleteMember($groupid, $userkey){
		GroupUserMapping::where('groupid', '=', $groupid)->where('userkey', '=', $userkey)->delete();
		return Redirect::to('/group/'.$groupid)->with('notice', 'ลบสมาชิกสำเร็จ');
	}
	
}