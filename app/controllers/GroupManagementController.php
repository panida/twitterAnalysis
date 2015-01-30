<?php

class GroupManagementController extends BaseController {
	
	public function createGroup(){
		$groups = UserGroup::all();
		//$memberCount = [];
		$notFinishedMembers = array();
		foreach($groups as $group){
			$memberCount[$group->groupid] = $group->users->count();
		}
		$query = FolloweeProcessedUser::where('status','=','process')->get();
		//if(!$query->isEmpty()){
			$notFinishedMembers = $query;
		//}
		return View::make('management.addGroup',['groups'=>$groups,'memberCount'=>$memberCount, 'notFinishedMembers'=>$notFinishedMembers]);
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
		$screenname = null;
		$info = null;
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
				$screenname = $info['screen_name'];
			}
			else{
				return Redirect::to('/group/'.$groupid)->with('error', 'ไม่พบสมาชิกที่ต้องการเพิ่ม');
			}	
		}
		else{
			$user = $query->first();
			$userkey = $user->userkey;
			$screenname = $user->screenname;
		}
		$group_user_map = new GroupUserMapping;
		$group_user_map->groupid = $groupid;
		$group_user_map->userkey = $userkey;
		$group_user_map->save();
		
		$preprocessUser = FolloweeProcessedUser::find($userkey);

		if(!$preprocessUser){
			if($query->isEmpty() && $info['protected']==true){
				$processedUser = new FolloweeProcessedUser;
				$processedUser->userkey = $userkey;
				$processedUser->status = 'finish';
				$processedUser->protected = 'yes';
				$processedUser->save();
			}
			else{
				$processedUser = new FolloweeProcessedUser;
				$processedUser->userkey = $userkey;
				$processedUser->status = 'process';
				$processedUser->protected = 'no';
				$processedUser->save();
				Queue::push('GroupManagementController@addFollowee', array('userkey' => "".$userkey, 'screenname' => ''.$screenname, 'cursor' => "-1"));
			}
			
		}
		return Redirect::to('/group/'.$groupid)->with('notice', 'เพิ่มสมาชิกสำเร็จ');
	}

	public function addFollowee($job,$args){
		$userkey = $args["userkey"];
		$screenname = $args["screenname"];
		$cursor = $args["cursor"];

		$result = TwitterAPIHelper::find_followee($userkey,$screenname,$cursor);
		if(!empty($result)){

			foreach($result['ids'] as $id){
				$followee_mapping = new FolloweeMapping;
				//echo "".$id.", ";
				$followee_mapping->userkey = $userkey;
				$followee_mapping->followeeid = $id;
				$followee_mapping->save(); 
			}

			//echo "<br/>-------------------------------------------<br/>";
			if($result['next_cursor_str']!='0'){
				Queue::push('GroupManagementController@addFollowee', array('userkey' => "".$userkey, 'screenname' => ''.$screenname, 'cursor' => $result['next_cursor_str']));
			}
			else{
				$processedUser = FolloweeProcessedUser::find($userkey);
				$processedUser->status = 'finish';
				$processedUser->save();
			}

		}
		else{
			$processedUser = FolloweeProcessedUser::find($userkey);
			$processedUser->status = 'finish';
			$processedUser->protected = 'yes';
			$processedUser->save();
		}
		sleep(6);
		$job->delete();

	}
	
}