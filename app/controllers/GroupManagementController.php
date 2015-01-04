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

	public function addMember($groupid){
		$input = Input::all();
		$query = UserDim::where('screenname','=',$input['screen_name'])->get();
		$userkey = -1;
		if($query->isEmpty()){
			$info = TwitterAPIHelper::getUserInfo($input['screen_name']);
			if(!empty($info)){
				$userkey = UserDim::storeFromTwitterAPI($info['id_str'], $info['name'], 
											$info['screen_name'], $info['location'], 
											$info['url'], $info['description'], 
											$info['created_at'], $info['time_zone'], 
											$info['utc_offset'], $info['lang'], 
											$info['profile_image_url']);
				UserStatisticsDim::store($info['id_str'], $info['followers_count'], $info['friends_count'], $info['statuses_count']);
			}
			else{
				return Redirect::to('/group/'.$groupid)->with('error', 'ไม่พบสมาชิกที่ต้องการเพิ่ม');
			}
			
		}
		else{
			$userkey = $query->first()->userkey;
		}
		$group_user_map = new GroupUserMapping;
		$group_user_map->groupid = $groupid;
		$group_user_map->userkey = $userkey;
		$group_user_map->save();
		return Redirect::to('/group/'.$groupid)->with('notice', 'เพิ่มสมาชิกสำเร็จ');
	}
	
}