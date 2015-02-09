<?php

class AnalysisController extends BaseController {

	public function groupTweetForTweetGraph($allTweetQuery, $startDate,$endDate, &$tweetMonth, &$tweetWeek, &$tweetDay, &$tweetHour){
		$allTweetQuery = $allTweetQuery
			->select(DB::raw('
				count(*) as num_of_activity,
				date_dim.date, date_dim.month,
				date_dim.year,time_dim.hour,
				activitytypekey, source_dim.sourcetype'))
			->join('time_dim', 'twitter_analysis_fact.timekey', '=', 'time_dim.timekey')
			->join('source_dim', 'twitter_analysis_fact.sourcekey', '=', 'source_dim.sourcekey')
			->groupBy('date_dim.year', 'date_dim.month', 'date_dim.date','time_dim.hour', 'activitytypekey', 'source_dim.sourcekey')
			->orderBy('date_dim.year','ASC')
			->orderBy('date_dim.month','ASC')
			->orderBy('date_dim.date','ASC')
			->orderBy('time_dim.hour','ASC');
		$tweetGroup = $allTweetQuery->get();
		//$allTweetByDay = $allTweetByHour->groupBy('date_dim.date', 'date_dim.month', 'date_dim.year');
		//echo $startDate;
		

		//--------------------------- Hour -----------------------------------------------

		$startDate = Carbon::createFromFormat('Y-m-d H:i:s',$startDate." 00:00:00");
		//echo $startDate->toDateTimeString();
		$endDate = Carbon::createFromFormat('Y-m-d H:i:s',$endDate." 23:00:00");
		$sizeOfTweetGroup = sizeof($tweetGroup);
		$currentResultIndex = 0;
		$currentDate = clone $startDate;
		$currentSize = 0;
		$tweetApplicationGroupByHour = array(array(),array(),array(),array());
		$tweetTypeGroupByHour = array(array(),array(),array());
		$tweetGroupByHour = array();
		while($currentDate->diffInHours($endDate,false) >= 0){
			array_push($tweetGroupByHour, array(
				"dateTime" => clone $currentDate,
				"year" => $currentDate->year,
				"month" => $currentDate->month,
				"day"	=> $currentDate->day,
				"hour"	=> $currentDate->hour,
				"num_of_activity" => 0
			));

			for($i = 0; $i<3; $i+=1){
				array_push($tweetTypeGroupByHour[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"day"	=> $currentDate->day,
					"hour"	=> $currentDate->hour,
					"num_of_activity" => 0
				));
			}

			for($i = 0; $i<4; $i+=1){
				array_push($tweetApplicationGroupByHour[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"day"	=> $currentDate->day,
					"hour"	=> $currentDate->hour,
					"num_of_activity" => 0
				));
			}

			while($currentResultIndex < $sizeOfTweetGroup && 
				$tweetGroup[$currentResultIndex]->year == $currentDate->year && 
				$tweetGroup[$currentResultIndex]->month == $currentDate->month && 
				$tweetGroup[$currentResultIndex]->date == $currentDate->day && 
				$tweetGroup[$currentResultIndex]->hour == $currentDate->hour){
				
				$tweetGroupByHour[$currentSize]["num_of_activity"] +=  $tweetGroup[$currentResultIndex]->num_of_activity;
				$tweetTypeGroupByHour[$tweetGroup[$currentResultIndex]->activitytypekey-1][$currentSize]["num_of_activity"] += $tweetGroup[$currentResultIndex]->num_of_activity;

				if($tweetGroup[$currentResultIndex]->sourcetype == 'Twitter'){
					$tweetApplicationGroupByHour[0][$currentSize]["num_of_activity"] += $tweetGroup[$currentResultIndex]->num_of_activity;
				}
				else if($tweetGroup[$currentResultIndex]->sourcetype == 'Facebook'){
					$tweetApplicationGroupByHour[1][$currentSize]["num_of_activity"] += $tweetGroup[$currentResultIndex]->num_of_activity;
				}
				else if($tweetGroup[$currentResultIndex]->sourcetype == 'Official news'){
					$tweetApplicationGroupByHour[2][$currentSize]["num_of_activity"] += $tweetGroup[$currentResultIndex]->num_of_activity;
				}
				else if($tweetGroup[$currentResultIndex]->sourcetype == 'Other'){
					$tweetApplicationGroupByHour[3][$currentSize]["num_of_activity"] += $tweetGroup[$currentResultIndex]->num_of_activity;
				}
				$currentResultIndex+=1;

			}
			$currentDate = $currentDate->addHour();
			$currentSize+=1;
		}
		array_push($tweetHour,$tweetGroupByHour,$tweetTypeGroupByHour, $tweetApplicationGroupByHour);

		//--------------------------- Day -----------------------------------------------

		$tweetApplicationGroupByDay = array(array(),array(),array(),array());
		$tweetGroupByDay = array();
		$tweetTypeGroupByDay = array(array(),array(),array());
		$currentDate = clone $startDate;
		$currentSize = 0;
		$currentGroupInHourInx =0;
		$sizeOfTweetGroup = sizeof($tweetGroupByHour);
		while($currentDate->diffInDays($endDate,false) >= 0){
			array_push($tweetGroupByDay, array(
				"dateTime" => clone $currentDate,
				"year" => $currentDate->year,
				"month" => $currentDate->month,
				"day"	=> $currentDate->day,
				"num_of_activity" => 0
			));
			for($i = 0; $i<3; $i+=1){
				array_push($tweetTypeGroupByDay[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"day"	=> $currentDate->day,
					"num_of_activity" => 0
				));
			}

			for($i = 0; $i<4; $i+=1){
				array_push($tweetApplicationGroupByDay[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"day"	=> $currentDate->day,
					"num_of_activity" => 0
				));
			}

			while($currentGroupInHourInx < $sizeOfTweetGroup && 
				$currentDate->diffInDays($tweetGroupByHour[$currentGroupInHourInx]["dateTime"])==0){
				$tweetGroupByDay[$currentSize]["num_of_activity"] += $tweetGroupByHour[$currentGroupInHourInx]["num_of_activity"];
				for($i = 0; $i<3; $i+=1){
					$tweetTypeGroupByDay[$i][$currentSize]["num_of_activity"] += $tweetTypeGroupByHour[$i][$currentGroupInHourInx]["num_of_activity"];
				}
				for($i = 0; $i<4; $i+=1){
					$tweetApplicationGroupByDay[$i][$currentSize]["num_of_activity"] += $tweetApplicationGroupByHour[$i][$currentGroupInHourInx]["num_of_activity"];
				}
				$currentGroupInHourInx += 1;
			}
			$currentDate=$currentDate->addDay();
			$currentSize += 1;
		}
		array_push($tweetDay,$tweetGroupByDay,$tweetTypeGroupByDay,$tweetApplicationGroupByDay);

		//--------------------------- Month -----------------------------------------------
		
		$tweetApplicationGroupByMonth = array(array(),array(),array(),array());
		$tweetGroupByMonth = array();
		$tweetTypeGroupByMonth = array(array(),array(),array());
		$currentDate = clone $startDate;
		$currentDate = $currentDate->startOfMonth();
		$endMonth = clone $endDate;
		$endMonth = $endMonth->startOfMonth();
		$currentSize = 0;
		$currentGroupInDayInx =0;
		$sizeOfTweetGroup = sizeof($tweetGroupByDay);
		while($currentDate->diffInMonths($endMonth,false) >= 0){
			array_push($tweetGroupByMonth, array(
				"dateTime" => clone $currentDate,
				"year" => $currentDate->year,
				"month" => $currentDate->month,
				"num_of_activity" => 0
			));
			
			for($i = 0; $i<3; $i+=1){
				array_push($tweetTypeGroupByMonth[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"num_of_activity" => 0
				));
			}

			for($i = 0; $i<4; $i+=1){
				array_push($tweetApplicationGroupByMonth[$i], array(
					"dateTime" => clone $currentDate,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"num_of_activity" => 0
				));
			}

			while($currentGroupInDayInx < $sizeOfTweetGroup && 
				$currentDate->diffInMonths($tweetGroupByDay[$currentGroupInDayInx]["dateTime"])==0){
				
				$tweetGroupByMonth[$currentSize]["num_of_activity"] += $tweetGroupByDay[$currentGroupInDayInx]["num_of_activity"];
				for($i = 0; $i<3; $i+=1){
					$tweetTypeGroupByMonth[$i][$currentSize]["num_of_activity"] += $tweetTypeGroupByDay[$i][$currentGroupInDayInx]["num_of_activity"];
				}

				for($i = 0; $i<4; $i+=1){
					$tweetApplicationGroupByMonth[$i][$currentSize]["num_of_activity"] += $tweetApplicationGroupByDay[$i][$currentGroupInDayInx]["num_of_activity"];
				}

				$currentGroupInDayInx += 1;
			}
			$currentDate=$currentDate->addMonth();
			$currentSize += 1;
		}
		array_push($tweetMonth,$tweetGroupByMonth,$tweetTypeGroupByMonth,$tweetApplicationGroupByMonth);

		//--------------------------- Week -----------------------------------------------

		$tweetApplicationGroupByWeek = array(array(),array(),array(),array());
		$tweetGroupByWeek = array();
		$tweetTypeGroupByWeek = array(array(),array(),array());
		$currentDate = clone $startDate;
		$currentDate = $currentDate->startOfWeek();
		$endWeek = clone $endDate;
		$endWeek = $endWeek->startOfWeek();
		$currentSize = 0;
		$currentGroupInDayInx =0;
		$sizeOfTweetGroup = sizeof($tweetGroupByDay);
		while($currentDate->diffInWeeks($endWeek,false) >= 0){
			$startDateTime = clone $currentDate;
			$endDateTime = clone $currentDate;
			array_push($tweetGroupByWeek, array(
				"startDay" => $startDateTime->day,
				"endDay" => $endDateTime->endOfWeek()->day,
				"year" => $currentDate->year,
				"month" => $currentDate->month,
				"num_of_activity" => 0
			));
			for($i = 0; $i<3; $i+=1){
				array_push($tweetTypeGroupByWeek[$i], array(
					"startDay" => $startDateTime->day,
					"endDay" => $endDateTime->endOfWeek()->day,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"num_of_activity" => 0
				));
			}
			for($i = 0; $i<4; $i+=1){
				array_push($tweetApplicationGroupByWeek[$i], array(
					"startDay" => $startDateTime->day,
					"endDay" => $endDateTime->endOfWeek()->day,
					"year" => $currentDate->year,
					"month" => $currentDate->month,
					"num_of_activity" => 0
				));
			}
			while($currentGroupInDayInx < $sizeOfTweetGroup && 
				$currentDate->diffInWeeks($tweetGroupByDay[$currentGroupInDayInx]["dateTime"])==0){
				
				$tweetGroupByWeek[$currentSize]["num_of_activity"] += $tweetGroupByDay[$currentGroupInDayInx]["num_of_activity"];
				for($i = 0; $i<3; $i+=1){
					$tweetTypeGroupByWeek[$i][$currentSize]["num_of_activity"] += $tweetTypeGroupByDay[$i][$currentGroupInDayInx]["num_of_activity"];
				}
				for($i = 0; $i<4; $i+=1){
					$tweetApplicationGroupByWeek[$i][$currentSize]["num_of_activity"] += $tweetApplicationGroupByDay[$i][$currentGroupInDayInx]["num_of_activity"];
				}

				$currentGroupInDayInx += 1;
			}
			$currentDate=$currentDate->addWeek();
			$currentSize += 1;
		}
		array_push($tweetWeek,$tweetGroupByWeek,$tweetTypeGroupByWeek,$tweetApplicationGroupByWeek);
	}

	public static function cmpByGroupidAscTimeDesc($a, $b){
		if($a->groupid<$b->groupid) return -1;
		else if($a->groupid>$b->groupid) return 1;
		else {
			if($a->real_created_at==$b->real_created_at) return 0;
		} return ($a->real_created_at<$b->real_created_at)? 1:-1; 
	} 

	public static function cmpByNumberOfFollowerDesc($a, $b){
		return $b->real_no_of_follower-$a->real_no_of_follower; 
	}

	public static function cmpByAllActivityCountDesc($a, $b){
		if($a['allActivityCount']==$b['allActivityCount']) return 0;
		else return ($a['allActivityCount']<$b['allActivityCount'])? 1:-1; 
	} 

	function TransitionCMP($a, $b)
	{
	    return $a->count - $b->count;
	}

	public function prepareDataForSocialGraph($tweetResultList, $startDate, $endDate, $caseId, &$socialNodes, &$socialLinks, &$socialTransitions){
		
		$links = DB::table('researchcase_usergroup_mapping AS case_map_1')
							->where('case_map_1.researchcasekey','=',$caseId)
							->join('group_user_mapping AS user_map_1', 'user_map_1.groupid', '=', 'case_map_1.groupid')
							->join('user_dim AS friend', 'friend.userkey', '=', 'user_map_1.userkey')
							->join('followee_mapping', 'followee_mapping.followeeid', '=', 'friend.userid')
							->join('user_dim AS user', 'followee_mapping.userkey', '=', 'user.userkey')
							->join('group_user_mapping AS user_map_2', 'user.userkey', '=', 'user_map_2.userkey')
							->join('researchcase_usergroup_mapping AS case_map_2','case_map_2.groupid','=','user_map_2.groupid')
							->where('case_map_2.researchcasekey','=',$caseId)
							->select(DB::raw('user.userkey AS source'), DB::raw('friend.userkey AS target'))
							->distinct()
							->orderBy('source')
							->orderBy('target')
							->get();

		foreach($links as $link){
			$obj = new \stdClass();
			$obj->source = $link->source;
			$obj->target = $link->target;
			$obj->type = 1;
			array_push($socialLinks, $obj);
		}

		$researchPeople = DB::table('researchcase_usergroup_mapping')
								->where('researchcase_usergroup_mapping.researchcasekey','=',$caseId)
								->join('group_user_mapping', 'group_user_mapping.groupid', '=', 'researchcase_usergroup_mapping.groupid')
								->join('user_dim', 'user_dim.userkey', '=', 'group_user_mapping.userkey', 'left')
								->join('followee_processed_user', 'user_dim.userkey', '=', 'followee_processed_user.userkey')
								->select(DB::raw('group_user_mapping.groupid AS groupid'),
											DB::raw('user_dim.userkey AS userkey'), 
											DB::raw('user_dim.screenname AS screenname'),
											DB::raw('user_dim.name AS realname'),  
											DB::raw('user_dim.description AS description'),
											DB::raw('followee_processed_user.protected AS isProtected'), 
											DB::raw('user_dim.user_timeline_url AS user_timeline_url'), 
											DB::raw('user_dim.profile_pic_url AS profile_pic_url'))
								->orderBy('userkey')
								->get();
		$num_people = count($researchPeople);
		$i = 0;
		$socialIndex = -1;
		while($i<$num_people){
			$researchPerson = $researchPeople[$i];

			if($i==0 || $researchPerson->userkey != $socialNodes[$socialIndex]->name){
				
				$socialIndex += 1;
				
				$obj = new \stdClass();
				$obj->name = $researchPerson->userkey;
				$obj->screenname = $researchPerson->screenname;
				$obj->description = $researchPerson->description;
				$obj->user_timeline_url = $researchPerson->user_timeline_url;
				$obj->profile_pic_url = $researchPerson->profile_pic_url;
				$obj->realname = $researchPerson->realname;
				$obj->isProtected = $researchPerson->isProtected;
				$obj->tweet = array();
				$obj->group = $researchPerson->groupid;
				$obj->groupsList = array();
				array_push($obj->groupsList, $researchPerson->groupid);
				array_push($socialNodes, $obj);
			}
			else{
				array_push($socialNodes[$socialIndex]->groupsList, $researchPerson->groupid);
				$socialNodes[$socialIndex]->group = 0;
			}
			$i += 1;
		}

		$nodes = $tweetResultList->join('group_user_mapping', 'group_user_mapping.userkey', '=', 'twitter_analysis_fact.userkey')
								->join('researchcase_usergroup_mapping', 'researchcase_usergroup_mapping.groupid', '=', 'group_user_mapping.groupid')
								->where('researchcase_usergroup_mapping.researchcasekey','=',$caseId)
								->join('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')  
								->select(DB::raw('group_user_mapping.userkey AS userkey'), 
											DB::raw('tweet_dim.text AS text'),
											DB::raw('tweet_dim.number_of_retweet AS number_of_retweet'),
											DB::raw('tweet_detail_dim.created_at AS created_at'),
											DB::raw('twitter_analysis_fact.activitytypekey AS activitytypekey'))
								->distinct()
								->orderBy('userkey')
								->orderBy('created_at')
								->get();
		
		$socialIndex = 0;
		foreach ($nodes as $node) {
			$tweet = new \stdClass();
			$tweet->text = $node->text;
			$tweet->activitytypekey = $node->activitytypekey;
			$tweet->created_at = $node->created_at;
			$tweet->number_of_retweet = $node->number_of_retweet;

			while($socialNodes[$socialIndex]->name < $node->userkey){
				$socialIndex+=1;
			}
			array_push($socialNodes[$socialIndex]->tweet, $tweet);
		}
		// echo '-----------------------------------------<br/><pre>';
		// var_dump($socialNodes);
		// echo "</pre>";

		$tempTransitions = array();
		$startDateCarbon = Carbon::createFromFormat('Y-m-d H:i:s',$startDate." 00:00:00");
		$endDateCarbon = Carbon::createFromFormat('Y-m-d H:i:s',$endDate." 23:00:00");
		foreach($socialNodes as $socialNode){
			if(count($socialNode->tweet)>0){
				$nodeDate = Carbon::createFromFormat('Y-m-d H:i:s', $socialNode->tweet[0]->created_at);
				$transition = new \stdClass();
				$transition->count = $startDateCarbon->diffInHours($nodeDate);
				$transition->node = $socialNode->name;
				array_push($tempTransitions, $transition);
			}
		}
		usort($tempTransitions, array($this,"TransitionCMP"));
		$tranIndex = -1;
		foreach($tempTransitions as $tempTransition){
			if($tranIndex==-1 || $tempTransition->count != $socialTransitions[$tranIndex]->count){
				$tranIndex += 1;
				$obj = new \stdClass();
				$obj->count = $tempTransition->count;
				$obj->nodes = array();
				array_push($socialTransitions, $obj);
			}
			array_push($socialTransitions[$tranIndex]->nodes, $tempTransition->node);
		}

		return $startDateCarbon->diffInHours($endDateCarbon);
		

	}


	public function analyse(){		
		$input = Input::all();
		if($input['type']=='text'){
			return AnalysisController::analyseByText();
		}
		else{
			return AnalysisController::analyseByUser();
		}
	}

	public function analyseByText(){
		$testStart = Carbon::now();
		$testTimeArray = array();
		$timestamp = date('Y-m-d_H-i-s_').rand(1000,9999);
		$input = Input::all();
		$caseID = $input['caseID'];
		$searchText = $input['searchText'];
		$startDate = $input['startDate'];
		$endDate = $input['endDate'];
		if($input['type']=='text'){
			$tweetResultList = TwitterAnalysisFact::searchByText($searchText,$startDate,$endDate,$caseID);
		}
		else{
			$tweetResultList = TwitterAnalysisFact::searchByUser($searchText,$startDate,$endDate,$caseID);
		}
		
		$tweetResult = $tweetResultList->get();

		//Prepare Data for tweet graph
		$allTweetQuery = clone $tweetResultList;
		$tweetMonth = array();
		$tweetWeek = array();
		$tweetDay = array();
		$tweetHour = array();
		AnalysisController::groupTweetForTweetGraph($allTweetQuery,$startDate,$endDate,$tweetMonth,$tweetWeek,$tweetDay,$tweetHour);
		$testTimeArray["groupTweet"] = Carbon::now()->diffInSeconds($testStart);
		//prepare data for social graph
		$socialNodes = array();
		$socialLinks = array();
		$socialTransitions = array();

		$tweetResultListForSocialGraph = clone $tweetResultList;

		$selectedCaseGroup = ResearchCaseDim::find($caseID);
		$allGroups = $selectedCaseGroup->userGroups;
		$existMemberGroup = array();
		foreach ($allGroups as $group) {
			if(count($group->users)>0)	array_push($existMemberGroup, $group);
		}

		$slidebarLength = AnalysisController::prepareDataForSocialGraph($tweetResultListForSocialGraph, $startDate, $endDate, $caseID, $socialNodes, $socialLinks, $socialTransitions);
		$socialGraphData = new \stdClass();
		$socialGraphData->nodes = $socialNodes;
		$socialGraphData->links = $socialLinks;
		$socialGraphData->transitions = $socialTransitions;
		$socialGraphData->groups = $existMemberGroup;
		$socialGraphData = json_encode($socialGraphData, JSON_UNESCAPED_UNICODE);
		$testTimeArray["speedGraph"] = Carbon::now()->diffInSeconds($testStart);

		$countAllTweet = sizeof($tweetResult);
		if($countAllTweet==0){
			$filename = 'report'.$timestamp.'.pdf';
			$fpdf = new PDF();
			$fpdf->AliasNbPages('tp');
	        $fpdf->AddFont('browa','','browa.php');
	        $fpdf->AddFont('browa','B','browab.php');		
			$fpdf->AddFont('browa','I','browai.php');
			$fpdf->AddFont('browa','BI','browaz.php');
			$fpdf->SetFont('browa','B',18);
			$fpdf->SetLeftMargin(10);
	        //------------------Page1----------------------
	        $fpdf->AddPage();
	        $fpdf->MultiCell(0,15,iconv('UTF-8','cp874','รายงานผลการวิเคราะห์ข้อมูลทวิตเตอร์โดยระบบ CU.Tweet'),0,'C');
	        $fpdf->SetFont('browa','B',16);
	        $x = $fpdf->GetX();
			$y = $fpdf->GetY();
	        if($input['type']=='text'){
	        	$fpdf->MultiCell(50,10,iconv('UTF-8','cp874','ค้นหาโดยข้อความ/ทวีต : '));
	        }
	        else{
	        	$fpdf->MultiCell(50,10,iconv('UTF-8','cp874','ค้นหาโดยชื่อผู้ใช้ทวิตเตอร์ : '));
	        }
	        $fpdf->SetXY($x + 50, $y);
	        $fpdf->SetFont('browa','',16);
	        $fpdf->MultiCell(0,10,iconv('UTF-8','cp874',$searchText));
	        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','(ค้นหาจากกรณีศึกษา '.ResearchCaseDim::find($caseID)->name.' ตั้งแต่วันที่ '.$startDate.' ถึงวันที่ '.$endDate.')'));
	        $fpdf->SetFont('browa','B',16);
	        $fpdf->MultiCell(0,10,iconv('UTF-8','cp874','ผลการค้นหา : '));
	        $fpdf->SetFont('browa','',16);
	        $fpdf->SetX(25);
	        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','ไม่พบข้อมูลทวีตที่ท่านต้องการค้นหา'));
	        $fpdf->Output(public_path().'/report/'.$filename ,'F');

	        //------------------Create CSV File---------------------
	        $filenameCSV = 'report'.$timestamp.'.csv';
	        $file = fopen(public_path().'/reportCSV/'.$filenameCSV,"w");
	        fputcsv($file, [iconv('UTF-8','cp874','รายงานผลการวิเคราะห์ข้อมูลทวิตเตอร์โดยระบบ CU.Tweet')]);
	        if($input['type']=='text'){
	        	fputcsv($file, [iconv('UTF-8','cp874','ค้นหาโดย'),iconv('UTF-8','cp874','ข้อความ/ทวีต')]);
	        }
	        else{
	        	fputcsv($file, [iconv('UTF-8','cp874','ค้นหาโดย'),iconv('UTF-8','cp874','ชื่อผู้ใช้ทวิตเตอร์')]);
	        }
	        fputcsv($file,[iconv('UTF-8','cp874','คำค้นหา'),iconv('UTF-8','cp874',$searchText)]);
	        fputcsv($file,[iconv('UTF-8','cp874','ค้นหาจากกรณีศึกษา '),iconv('UTF-8','cp874',ResearchCaseDim::find($caseID)->name)]);
	        fputcsv($file,[iconv('UTF-8','cp874','ตั้งแต่วันที่ '),iconv('UTF-8','cp874',' '.$startDate)]);
	        fputcsv($file,[iconv('UTF-8','cp874','ถึงวันที่ '),iconv('UTF-8','cp874',' '.$endDate)]);
	        //------------------SpeedAndLifeCycleGraph--------------
	        fputcsv($file,[]);
	        fputcsv($file,[iconv('UTF-8','cp874','ไม่พบข้อมูลทวีตที่ท่านต้องการค้นหา')]);	        
	        fclose($file);
	        //------------------------------------------------------
			$result = ['type'=>$input['type'],
					'caseID' => $caseID,
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'countAllTweet'=>$countAllTweet,
					'researchCase' => ResearchCaseDim::lists('name', 'researchcasekey'),
					'cases'=> ResearchCaseDim::caseData(),
					'filename'=>$filename,
					'filenameCSV'=>$filenameCSV];
			return View::make('layouts.notFound',$result);
		}
		
		

        						// ->get();
  //       var_dump($topFollowerList);
		// return View::make('blank_page');
		$tweetResultListTemp = clone $tweetResultList; 
		$tweetResultList = array();
		for($i=0;$i<=20;$i++) $tweetResultList[$i] = clone $tweetResultListTemp;   
        

		$countAllImpression = $tweetResultList[1]->sum('twitter_analysis_fact.number_of_follower');		
		$countActList = $tweetResultList[2]					
					->select(
						'twitter_analysis_fact.activitytypekey',						
						DB::raw('count(*) as totalNumber')
						)
					->groupBy('twitter_analysis_fact.activitytypekey')
					->orderBy('twitter_analysis_fact.activitytypekey','asc')
					->get();
		$contributorKeyList = $tweetResultList[3]
								->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')
								->leftJoin('user_statistics_dim','twitter_analysis_fact.userstatisticskey','=','user_statistics_dim.userstatisticskey')
								->select('user_dim.userkey',
									'user_dim.screenname',
									'twitter_analysis_fact.activitytypekey',
									'user_statistics_dim.followers_count',
									DB::raw('count(*) as totalNumber')
									)
								->groupBy('user_dim.userkey','user_dim.screenname','twitter_analysis_fact.activitytypekey')
								->orderBy('user_statistics_dim.followers_count','desc')
								->get();
		$sourceKeyList = $tweetResultList[4]
							->select('twitter_analysis_fact.sourcekey',
									DB::raw('count(*) as totalNumber')
								)
							->groupBy('twitter_analysis_fact.sourcekey')
							->orderBy('totalNumber','desc')
							->get();
		$countRetweetTime = $tweetResultList[5]->where('twitter_analysis_fact.activitytypekey','=','3')
                 ->select('twitter_analysis_fact.tweetkey', DB::raw('count(*) as totalRetweet'))
                 ->groupBy('twitter_analysis_fact.tweetkey')
                 ->orderBy('totalRetweet','desc')
                 ->get();

        $timelineList = $tweetResultList[7]
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')        		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')
        		->leftJoin('twitter_analysis_fact as original_fact','tweet_dim.tweetkey','=','original_fact.tweetkey')
        		->where('original_fact.activitytypekey','<',3)        		
        		->leftJoin('user_dim as user_original','original_fact.userkey','=','user_original.userkey')
        		->leftJoin('source_dim as source_original','original_fact.sourcekey','=','source_original.sourcekey')
        		->leftJoin('tweet_detail_dim as tweet_detail_original','original_fact.tweetdetailkey','=','tweet_detail_original.tweetdetailkey')
        		->leftJoin('tweet_dim as tweet_original','original_fact.tweetkey','=','tweet_original.tweetkey')
        		->select('user_dim.screenname as real_screenname',
        			'source_dim.sourcename as real_sourcename',
        			'tweet_detail_dim.created_at as real_created_at',
        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
        			'twitter_analysis_fact.tweetkey as real_tweetkey',
        			'tweet_original.text as original_text',
        			'tweet_detail_original.created_at as original_created_at',
        			'source_original.sourcename as original_sourcename',
        			'user_original.name as original_name',
        			'user_original.screenname as original_screenname',
        			'user_original.profile_pic_url as original_pic',
        			'date_dim.abbr_nameofday as nameday',
        			'date_dim.date as date',
        			'date_dim.abbr_nameofmonth as month',
        			'date_dim.year as year',
        			'date_dim.thedate as thedate')
        		->get();

        $topFollowerList = array_merge(array(),$timelineList);
        usort($topFollowerList,'AnalysisController::cmpByNumberOfFollowerDesc');
   //              	echo "<pre>";
   //   		var_dump($topFollowerList);
			// echo "</pre>";
			// return View::make('blank_page');
        $tweetInterestList = $tweetResultList[8]
        		->where('activitytypekey',1)
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')
        		->rightJoin('group_user_mapping','twitter_analysis_fact.userkey','=','group_user_mapping.userkey') 
        		->join('researchcase_usergroup_mapping', function($join)
			        {
			            $join->on('twitter_analysis_fact.researchcasekey','=','researchcase_usergroup_mapping.researchcasekey')
			            	->on('group_user_mapping.groupid','=','researchcase_usergroup_mapping.groupid');
			        })	        		
        		->leftJoin('usergroup','group_user_mapping.groupid','=','usergroup.groupid')       		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')        		
        		->select('user_dim.screenname as real_screenname',
        			'user_dim.name as real_name',
        			'user_dim.profile_pic_url as real_pic',
        			'source_dim.sourcename as real_sourcename',
        			'tweet_detail_dim.created_at as real_created_at',
        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
        			'twitter_analysis_fact.tweetkey as real_tweetkey',
        			'tweet_dim.text as original_text',
        			'usergroup.groupid as groupid',
        			'usergroup.groupname as groupname',
        			'date_dim.abbr_nameofday as nameday',
        			'date_dim.date as date',
        			'date_dim.abbr_nameofmonth as month',
        			'date_dim.year as year',
        			'date_dim.thedate as thedate'
        			);        		
        $tweetInterestDetailList = $tweetInterestList->get();
        $tweetInterestCountList = $tweetInterestList
        							->select('usergroup.groupid','usergroup.groupname as groupname', DB::raw('count(*) as totalTweet'))
					                ->groupBy('usergroup.groupid')
					        		->get();

   //      	echo "<pre>";
   //   		var_dump($tweetInterestDetailList);
			// echo "</pre>";
			// return View::make('blank_page');

		$replyInterestList = $tweetResultList[9]
        		->where('activitytypekey',2)
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')
        		->rightJoin('group_user_mapping','twitter_analysis_fact.userkey','=','group_user_mapping.userkey') 
        		->join('researchcase_usergroup_mapping', function($join)
			        {
			            $join->on('twitter_analysis_fact.researchcasekey','=','researchcase_usergroup_mapping.researchcasekey')
			            	->on('group_user_mapping.groupid','=','researchcase_usergroup_mapping.groupid');
			        })
        		->leftJoin('usergroup','group_user_mapping.groupid','=','usergroup.groupid')       		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')        		
        		->select('user_dim.screenname as real_screenname',
        			'user_dim.name as real_name',
        			'user_dim.profile_pic_url as real_pic',
        			'source_dim.sourcename as real_sourcename',
        			'tweet_detail_dim.created_at as real_created_at',
        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
        			'twitter_analysis_fact.tweetkey as real_tweetkey',
        			'tweet_dim.text as original_text',
        			'usergroup.groupid as groupid',
        			'usergroup.groupname as groupname',
        			'date_dim.abbr_nameofday as nameday',
        			'date_dim.date as date',
        			'date_dim.abbr_nameofmonth as month',
        			'date_dim.year as year',
        			'date_dim.thedate as thedate'
        			);        		
        $replyInterestDetailList = $replyInterestList->get();
        $replyInterestCountList = $replyInterestList
        							->select('usergroup.groupid','usergroup.groupname as groupname', DB::raw('count(*) as totalReply'))
					                ->groupBy('usergroup.groupid')
					        		->get();


		$retweetInterestList = $tweetResultList[10]
				->where('twitter_analysis_fact.activitytypekey',3)  
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')   
        		->rightJoin('group_user_mapping','twitter_analysis_fact.userkey','=','group_user_mapping.userkey') 
        		->join('researchcase_usergroup_mapping', function($join)
			        {
			            $join->on('twitter_analysis_fact.researchcasekey','=','researchcase_usergroup_mapping.researchcasekey')
			            	->on('group_user_mapping.groupid','=','researchcase_usergroup_mapping.groupid');
			        })
        		->leftJoin('usergroup','group_user_mapping.groupid','=','usergroup.groupid')      		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')
        		->leftJoin('twitter_analysis_fact as original_fact','tweet_dim.tweetkey','=','original_fact.tweetkey')
        		->where('original_fact.activitytypekey','<',3)        		
        		->leftJoin('user_dim as user_original','original_fact.userkey','=','user_original.userkey')
        		->leftJoin('source_dim as source_original','original_fact.sourcekey','=','source_original.sourcekey')
        		->leftJoin('tweet_detail_dim as tweet_detail_original','original_fact.tweetdetailkey','=','tweet_detail_original.tweetdetailkey')
        		->leftJoin('tweet_dim as tweet_original','original_fact.tweetkey','=','tweet_original.tweetkey')
        		->select('user_dim.screenname as real_screenname',
        			'source_dim.sourcename as real_sourcename',
        			'tweet_detail_dim.created_at as real_created_at',
        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
        			'twitter_analysis_fact.tweetkey as real_tweetkey',
        			'tweet_original.text as original_text',
        			'tweet_detail_original.created_at as original_created_at',
        			'source_original.sourcename as original_sourcename',
        			'user_original.name as original_name',
        			'user_original.screenname as original_screenname',
        			'user_original.profile_pic_url as original_pic',
        			'usergroup.groupid as groupid',
        			'usergroup.groupname as groupname',
        			'date_dim.abbr_nameofday as nameday',
        			'date_dim.date as date',
        			'date_dim.abbr_nameofmonth as month',
        			'date_dim.year as year',
        			'date_dim.thedate as thedate');
        		
        $retweetInterestDetailList = $retweetInterestList->get();
        $retweetInterestCountList = $retweetInterestList
        							->select('usergroup.groupid','usergroup.groupname as groupname', DB::raw('count(*) as totalRetweet'))
					                ->groupBy('usergroup.groupid')
					        		->get();
		usort($tweetInterestDetailList,"AnalysisController::cmpByGroupidAscTimeDesc");
		usort($retweetInterestDetailList,"AnalysisController::cmpByGroupidAscTimeDesc");
		usort($replyInterestDetailList,"AnalysisController::cmpByGroupidAscTimeDesc");
		
		$beRetweetedInterestCountList = $tweetResultList[11]
        		->where('twitter_analysis_fact.activitytypekey','<',3)
        		->leftJoin('user_dim','twitter_analysis_fact.userkey','=','user_dim.userkey')
        		->rightJoin('group_user_mapping','twitter_analysis_fact.userkey','=','group_user_mapping.userkey') 
        		->join('researchcase_usergroup_mapping', function($join)
			        {
			            $join->on('twitter_analysis_fact.researchcasekey','=','researchcase_usergroup_mapping.researchcasekey')
			            	->on('group_user_mapping.groupid','=','researchcase_usergroup_mapping.groupid');
			        })
        		->leftJoin('usergroup','group_user_mapping.groupid','=','usergroup.groupid')     
        		->leftJoin('twitter_analysis_fact as all_fact','tweet_dim.tweetkey','=','all_fact.tweetkey')
        		->where('all_fact.objectid','<>','twitter_analysis_fact.objectid')
				->leftJoin('date_dim as all_fact_date_dim','all_fact.datekey','=','all_fact_date_dim.datekey')
				->where('all_fact_date_dim.thedate','>=',new DateTime($startDate))
				->where('all_fact_date_dim.thedate','<=',new DateTime($endDate))
				->select('usergroup.groupid','usergroup.groupname as groupname', DB::raw('count(*) as totalBeRetweeted'))
				->groupBy('usergroup.groupid')
				->get();
		$testTimeArray["queryDatabase"] = Carbon::now()->diffInSeconds($testStart);

		$totalGroup = array();
		foreach($tweetInterestCountList as $aGroup){
			$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
									  'groupname'=>$aGroup->groupname,
									  'tweetCount'=>$aGroup->totalTweet,
									  'retweetCount'=>0,
									  'replyCount'=>0,
									  'beRetweetedCount'=>0];
		}
		foreach($retweetInterestCountList as $aGroup){
			if(array_key_exists($aGroup->groupid, $totalGroup)) 
				$totalGroup[$aGroup->groupid]['retweetCount'] = $aGroup->totalRetweet;
			else
				$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
									  'groupname'=>$aGroup->groupname,
									  'tweetCount'=>0,
									  'retweetCount'=>$aGroup->totalRetweet,
									  'replyCount'=>0,
									  'beRetweetedCount'=>0];
		}
		foreach($replyInterestCountList as $aGroup){
			if(array_key_exists($aGroup->groupid, $totalGroup)) 
				$totalGroup[$aGroup->groupid]['replyCount'] = $aGroup->totalReply;
			else
				$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
									  'groupname'=>$aGroup->groupname,
									  'tweetCount'=>0,
									  'retweetCount'=>0,
									  'replyCount'=>$aGroup->totalReply,
									  'beRetweetedCount'=>0];
		}
		foreach($beRetweetedInterestCountList as $aGroup){
			if(array_key_exists($aGroup->groupid, $totalGroup)) 
				$totalGroup[$aGroup->groupid]['beRetweetedCount'] = $aGroup->totalBeRetweeted;
		}

		ksort($totalGroup);
   //      	echo "<pre>";
   //   		var_dump($totalGroup);
			// echo "</pre>";
			// return View::make('blank_page');		

		$testTimeArray["phpProcessTotalGroup"] = Carbon::now()->diffInSeconds($testStart);
		$topRetweetedList = $tweetResultList[12]
				->where('twitter_analysis_fact.activitytypekey','=',3)
        		->leftJoin('twitter_analysis_fact as original_fact','twitter_analysis_fact.tweetkey','=','original_fact.tweetkey')
        		->where('original_fact.activitytypekey','<',3)        		
        		->leftJoin('user_dim as user_original','original_fact.userkey','=','user_original.userkey')
        		->leftJoin('source_dim as source_original','original_fact.sourcekey','=','source_original.sourcekey')
        		->leftJoin('tweet_detail_dim as tweet_detail_original','original_fact.tweetdetailkey','=','tweet_detail_original.tweetdetailkey')
        		->leftJoin('tweet_dim as tweet_original','original_fact.tweetkey','=','tweet_original.tweetkey')
        		->select(
        			'tweet_original.text as original_text',
        			'tweet_detail_original.created_at as original_created_at',
        			'source_original.sourcename as original_sourcename',
        			'user_original.userkey as original_userkey',
        			'user_original.name as original_name',
        			'user_original.screenname as original_screenname',
        			'user_original.profile_pic_url as original_pic',
        			DB::raw('count(*) as totalRetweet'))
        		->groupBy('original_fact.tweetkey')
        		->orderBy('totalRetweet','desc')
        		->get();
        $retweetedCountOfUser = array();  
		$maxRTCount = -1;
        $maxRetweetedUserKey = NULL;
        foreach($topRetweetedList as $anOriginalTweet){
			if(array_key_exists($anOriginalTweet->original_userkey,$retweetedCountOfUser)) $retweetedCountOfUser[$anOriginalTweet->original_userkey] += $anOriginalTweet->totalRetweet;
			else $retweetedCountOfUser[$anOriginalTweet->original_userkey] = $anOriginalTweet->totalRetweet;
			if($retweetedCountOfUser[$anOriginalTweet->original_userkey]>$maxRTCount){
        		$maxRTCount = $retweetedCountOfUser[$anOriginalTweet->original_userkey];
        		$maxRetweetedUserID = $anOriginalTweet->original_userkey;
        	}
        }
        $maxRetweetedUser = ['count'=>$maxRTCount,'screenname'=>UserDim::find($maxRetweetedUserID)->screenname,'pic'=>UserDim::find($maxRetweetedUserID)->profile_pic_url];
		 //        	echo "<pre>";
   //   		var_dump($topRetweetedList);
			// echo "</pre>";
			// return View::make('blank_page');	
        if(sizeof($topRetweetedList)<=10) $top10RetweetedList = $topRetweetedList;
        else $top10RetweetedList = array_slice($topRetweetedList, 0,10);
        $testTimeArray["phpProcessTopRetweetedList"] = Carbon::now()->diffInSeconds($testStart);
		$contributorList = array();
		foreach($contributorKeyList as $aContributorAndType){
			if(!array_key_exists($aContributorAndType->userkey,$contributorList)){
				$contributorList[$aContributorAndType->userkey] = [	'userkey'=>$aContributorAndType->userkey,
																	'screenname'=>$aContributorAndType->screenname,
																	'followerCount'=>$aContributorAndType->followers_count,
																	'tweetCount'=>0,
																	'retweetCount'=>0,
																	'replyCount'=>0,
																	'allActivityCount'=>0
																	];
			}
			if ($aContributorAndType->activitytypekey==3) {
				$contributorList[$aContributorAndType->userkey]['retweetCount'] = $aContributorAndType->totalNumber;
				$contributorList[$aContributorAndType->userkey]['allActivityCount'] += $aContributorAndType->totalNumber;
			}
			else if ($aContributorAndType->activitytypekey==1) {
				$contributorList[$aContributorAndType->userkey]['tweetCount'] = $aContributorAndType->totalNumber;
				$contributorList[$aContributorAndType->userkey]['allActivityCount'] += $aContributorAndType->totalNumber;
			}
			else {
				$contributorList[$aContributorAndType->userkey]['replyCount'] = $aContributorAndType->totalNumber;
				$contributorList[$aContributorAndType->userkey]['allActivityCount'] += $aContributorAndType->totalNumber;
			}				
		}
		reset($contributorList);
		$maxFol_key = key($contributorList);
		$maxFollowerUser = ['count'=>$contributorList[$maxFol_key]["followerCount"],'screenname'=>$contributorList[$maxFol_key]["screenname"],'pic'=>UserDim::find($maxFol_key)->profile_pic_url];
		 //        	echo "<pre>";
   //   		var_dump($contributorList);
			// echo "</pre>";
			// return View::make('blank_page');	

		$sourceList = array();
		foreach($sourceKeyList as $aKey){
			$sourceList[$aKey->sourcekey] = $aKey->totalNumber;
		}

		$TwUserList = array();
		$RtUserList = array();
		$RpUserList = array();
		$TwRtUserList = array();
		$RtRpUserList = array();
		$TwRpUserList = array();
		$TwRtRpUserList = array();
		// usort($contributorList,"ContributorData::cmpByFollowerCountDesc");
		// reset($contributorList);
		foreach($contributorList as $aUserStat){			
			$TW = ($aUserStat['tweetCount'] > 0);
			$RT = ($aUserStat['retweetCount'] > 0);
			$RP = ($aUserStat['replyCount'] > 0);
			if($TW){
				array_push($TwUserList,$aUserStat);
			}
			if($RT){
				array_push($RtUserList,$aUserStat);
			}
			if($RP){
				array_push($RpUserList,$aUserStat);
			}
			if($TW or $RT){
				array_push($TwRtUserList,$aUserStat);
			}
			if($TW or $RP){
				array_push($TwRpUserList,$aUserStat);
			}
			if($RT or $RP){
				array_push($RtRpUserList,$aUserStat);
			}
			if($TW or $RT or $RP){
				array_push($TwRtRpUserList,$aUserStat);
			}
		}
		$testTimeArray["phpProcessGroupActivityType"] = Carbon::now()->diffInSeconds($testStart);
		// $print = json_encode($TwUserList);
		//     echo "<pre>";
  //    		var_dump($print);
		// 	echo "</pre>";
		// 	return View::make('blank_page');
		$perPage = 10;
		$TwUserList = array_chunk($TwUserList,$perPage);
		$RtUserList = array_chunk($RtUserList,$perPage);	
		$RpUserList = array_chunk($RpUserList,$perPage);
		$TwRtUserList = array_chunk($TwRtUserList,$perPage);
		$RtRpUserList = array_chunk($RtRpUserList,$perPage);
		$TwRpUserList = array_chunk($TwRpUserList,$perPage);
		$TwRtRpUserList = array_chunk($TwRtRpUserList,$perPage);
		
		usort($contributorList,"AnalysisController::cmpByAllActivityCountDesc");
		reset($contributorList);
			// 	    echo "<pre>";
   //   		var_dump($contributorList);
			// echo "</pre>";
			// return View::make('blank_page');
		$maxAct_key = key($contributorList);
		$maxActivityUser = ['count'=>$contributorList[$maxAct_key]["allActivityCount"],'screenname'=>$contributorList[$maxAct_key]["screenname"],'pic'=>UserDim::find($contributorList[$maxAct_key]["userkey"])->profile_pic_url];
		$testTimeArray["phpProcessContributorActivityChunk"] = Carbon::now()->diffInSeconds($testStart);
		

		$sourceProportion = array();
		for($i = 1;$i<=5;$i+=1){
			if(sizeof($sourceList)==0) break;
			$maxs = array_keys($sourceList, max($sourceList));
			$sourceProportion[$i] = ['sourceName'=>SourceDim::find($maxs[0])->sourcename,
									'count'=>max($sourceList)];
			unset($sourceList[$maxs[0]]);
		}
		if(sizeof($sourceList)>0) {
			$sourceProportion[6] = ['sourceName'=>'Others',
									'count'=>array_sum($sourceList)];
		}
		$countAct = ['tweet'=>0,'retweet'=>0,'reply'=>0];
		foreach($countActList as $anAct){
			if($anAct->activitytypekey==1) $countAct['tweet'] = $anAct->totalNumber;
			else if($anAct->activitytypekey==3) $countAct['retweet'] = $anAct->totalNumber;
			else $countAct['reply'] = $anAct->totalNumber;
		}

		// ----- Statistics Tab -----
		$countAllContributor = sizeof($contributorList);
		
		$testTimeArray["phpProcessSourceFinish"] = Carbon::now()->diffInSeconds($testStart);
		//-------------------------GenImageForReport---------------
		//-----------ActivityPic------------------
		$jsonString = "{
			  	title:{
			      text:''
				 },
			 	 plotOptions: {
			            pie: {
			                dataLabels: {
			                    enabled: true,
			                    format: '<b>{point.name}</b>:<br>{point.y:,.0f} ({point.percentage:.1f} %)',
			                    style: {
			                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
			                    }
			                }
			            }
			        },
				        series: [{
				            type: 'pie',
				            name: 'Application',
				            data: [
								['Tweets',". $countAct['tweet'] ."],
				                ['Retweets',".$countAct['retweet']."],
				                ['Replies',". $countAct['reply']."],
        						]
				        }]

				}";
		$activityImageName = 'report'.$timestamp.'_activityChart.png';
        HighchartsAPI::callForImage($activityImageName,$jsonString,'450');
        //-----------DevicePic------------------
		$jsonString = "{
			  	title:{
			      text:''
				 },
			 	 plotOptions: {
			            pie: {
			                dataLabels: {
			                    enabled: true,
			                    format: '<b>{point.name}</b>:<br>{point.y:,.0f} ({point.percentage:.1f} %)',
			                    style: {
			                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
			                    }
			                }
			            }
			        },
				        series: [{
				            type: 'pie',
				            name: 'Application',
				            data: [";
		foreach($sourceProportion as $aSource){
            		$jsonString .= "['".$aSource['sourceName']."',".$aSource['count']."],";
        }
        $jsonString .= "]
				        }]

				}";
		$deviceImageName = 'report'.$timestamp.'_deviceChart.png';
        HighchartsAPI::callForImage($deviceImageName,$jsonString,'450');
        //-------------------------InterestingContributorGraph1----
   		$jsonString=" {
				        chart: {
				            type: 'column'
				        },
				        title: {
				            text: ''
				        },
				        xAxis: {
				            categories: [";
				            	for($i=1;$i<=count($totalGroup);$i++){
				            		$jsonString.="'Group".$i."',";
				            	}
				            	$jsonString.="],
				            title: {
				                text: null
				            }
				        },
				        yAxis: {
				            min: 0,
				            title: {
				                text: 'Number of Tweets',
				                align: 'high'
				            },
				            labels: {
				                overflow: 'justify'
				            }
				        },
				        plotOptions: {
				            column: {
				                dataLabels: {
				                    enabled: true,
				                    color: '#666',
				                }
				            }
				        },
				        legend: {
				            layout: 'vertical',
				            align: 'right',
				            verticalAlign: 'top',
				            x: -40,
				            y: 100,
				            floating: true,
				            borderWidth: 1,
				            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				            shadow: true
				        },
				        credits: {
				            enabled: false
				        },
				        series: [{
				            name: 'Tweet',
				            data: [";
				            	foreach($totalGroup as $aGroup){
				            		$jsonString.=$aGroup['tweetCount'].",";
				            	}
				            $jsonString.="]
				        }, {
				            name: 'Retweet',
				            data: [";
				            	foreach($totalGroup as $aGroup){
				            		$jsonString.=$aGroup['retweetCount'].",";
				            	}
				            $jsonString.="]
				        }, {
				            name: 'Reply',
				            data: [";
				            	foreach($totalGroup as $aGroup){
				            		$jsonString.=$aGroup['replyCount'].",";
				            	}
				            $jsonString.="]
				        }, {
				            name: 'BeRetweeted',
				            data: [";
				            	foreach($totalGroup as $aGroup){
				            		$jsonString.=$aGroup['beRetweetedCount'].",";
				            	}
				            $jsonString.="]
				        }
				        ]
				    }";
		$interestingContributor1ImageName = 'report'.$timestamp.'_interestingContributor1Chart.png';
        HighchartsAPI::callForImage($interestingContributor1ImageName,$jsonString,'450');
        //-------------------------InterestingContributorGraph2----
   		$jsonString="{
				        chart: {
				            type: 'column'
				        },
				        title: {
				            text: ''
				        },
				        xAxis: {
				            categories: ['Tweet', 'Retweet', 'Reply'],
				            title: {
				                text: null
				            }
				        },
				        yAxis: {
				            min: 0,
				            title: {
				                text: 'Number of Tweets',
				                align: 'high'
				            },
				            labels: {
				                overflow: 'justify'
				            }
				        },
				        plotOptions: {
				            column: {
				                dataLabels: {
				                    enabled: true,
				                    color: '#666',
				                }
				            }
				        },
				        legend: {
				            layout: 'vertical',
				            align: 'right',
				            verticalAlign: 'top',
				            x: -40,
				            y: 100,
				            floating: true,
				            borderWidth: 1,
				            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				            shadow: true
				        },
				        credits: {
				            enabled: false
				        },
				        series: [";
				        $index=1;
				        foreach($totalGroup as $aGroup){
				        	$jsonString.="{
				        		name: 'Group".$index."',".
				        		"data: [".$aGroup['tweetCount'].",".$aGroup['retweetCount'].",".$aGroup['replyCount']."]
				        	},";
				        	$index++;
				        }
				        $jsonString.="]
				    }";
		$interestingContributor2ImageName = 'report'.$timestamp.'_interestingContributor2Chart.png';
        HighchartsAPI::callForImage($interestingContributor2ImageName,$jsonString,'450');

        //-----------speedAndlifecyclePic------------------

        //----------- All -------------
		$dayDataForAll = '[';
		$length = count($tweetDay[0]);
		$countLength = 0;
		foreach($tweetDay[0] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForAll .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForAll .= ',';
		}
		$dayDataForAll .= ']';
		
		//--------- ActivityType ------------
		$dayDataForType = "[{name: 'Tweet', data:[";
		$length = count($tweetDay[1][0]);
		$countLength = 0;
		foreach($tweetDay[1][0] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForType .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForType .= ',';
		}
		$dayDataForType .= "]},{name: 'Retweet', data:[";
		$length = count($tweetDay[1][1]);
		$countLength = 0;
		foreach($tweetDay[1][1] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForType .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForType .= ',';
		}
		$dayDataForType .= "]},{name: 'Reply', data:[";
		$length = count($tweetDay[1][2]);
		$countLength = 0;
		foreach($tweetDay[1][2] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForType .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForType .= ',';
		}
		$dayDataForType .= ']}]';

		//-------------- Application -------------
		$dayDataForApplication = "[{name: 'Twitter', data:[";
		$length = count($tweetDay[2][0]);
		$countLength = 0;
		foreach($tweetDay[2][0] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForApplication .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForApplication .= ',';
		}
		$dayDataForApplication .= "]},{name: 'Facebook', data:[";
		$length = count($tweetDay[2][1]);
		$countLength = 0;
		foreach($tweetDay[2][1] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForApplication .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForApplication .= ',';
		}
		$dayDataForApplication .= "]},{name: 'Official news', data:[";
		$length = count($tweetDay[2][2]);
		$countLength = 0;
		foreach($tweetDay[2][2] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForApplication .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForApplication .= ',';
		}
		$dayDataForApplication .= "]},{name: 'Others', data:[";
		$length = count($tweetDay[2][3]);
		$countLength = 0;
		foreach($tweetDay[2][3] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForApplication .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForApplication .= ',';
		}
		$dayDataForApplication .= ']}]';

        $jsonString = "{
				chart: {
					type: 'area',
					isZoomed: false
				},
				credits: {
					enabled : false
				},
				title: {
						text: '',
				},
				xAxis: {
					type: 'datetime',
					title: {
						text: 'Date-Time'
					},
					minTickInterval: 86400000,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true
				},
				yAxis: {
					floor: 0,
					labels: {
						align: 'right',
						x: -3
					},
					title: {
						text: 'Number of Tweets'
					},
					lineWidth: 2,
					opposite: false,
					offset: 0
					
				},
				rangeSelector:{
					buttons : [{
						type : 'all',
						text : 'All'
					}],
					selected : 0,
					inputEnabled : true,
					inputEditDateFormat: '%Y-%m-%d'
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: 'horizontal',
					verticalAlign: 'top',
					borderWidth: 1
					
				},
				plotOptions: {
					area: {
						marker: {
							radius: 0,
						}
					}
				},
				series: [{
					name: 'All',
					color: 'rgba(150, 150, 255, 0.5)',
					data: ".$dayDataForAll.",
					fillColor : {
						linearGradient : {
							x1: 0,
							y1: 0,
							x2: 0,
							y2: 1
						},
						stops : [
							[0, Highcharts.getOptions().colors[0]],
							[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
						]
					}
				}]
			}";
		$speedAllActivityImageName = 'report'.$timestamp.'_speedAllActivity.png';
        HighchartsAPI::callForImage($speedAllActivityImageName,$jsonString,'600');


        $jsonString = "{
				chart: {
					type: 'line',
					isZoomed: false,
				},
				title: {
						text: '',
				},
				credits: {
					enabled : false
				},
				navigator: {
		            margin: 10
		        },
				xAxis: {
					type: 'datetime',
					title: {
						text: 'Date-Time'
					},
					minTickInterval: 86400000,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true,
				},
				yAxis: {
					floor: 0,
					labels: {
						align: 'right',
						x: -3
					},
					title: {
						text: 'Number of Tweets'
					},
					
					lineWidth: 2,
					opposite: false,
					offset: 0
					
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: 'horizontal',
					verticalAlign: 'top',
					borderWidth: 1
					
				},
				plotOptions: {
					line: {
						marker: {
							radius: 0,
						}
					}
				},
				series: ".$dayDataForType."}";
		
		$speedActivityTypeImageName = 'report'.$timestamp.'_speedActivityType.png';
        HighchartsAPI::callForImage($speedActivityTypeImageName,$jsonString,'600');

        $jsonString = "{
				chart: {
					renderTo: 'applicationGraph',
					type: 'line',
				},
				title: {
						text: '',
				},
				credits: {
					enabled : false
				},
				navigator: {
		            margin: 10
		        },
				xAxis: {
					type: 'datetime',
					title: {
						text: 'Date-Time'
					},
					minTickInterval: 86400000,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true
				},
				yAxis: {
					floor: 0,
					labels: {
						align: 'right',
						x: -3
					},
					title: {
						text: 'Number of Tweets'
					},
					
					lineWidth: 2,
					opposite: false,
					offset: 0
					
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: 'horizontal',
					verticalAlign: 'top',
					borderWidth: 1
					
				},
				plotOptions: {
					line: {
						marker: {
							radius: 0
						}
					}
				},
				series: ".$dayDataForApplication."
			}";
		
		$speedApplicationImageName = 'report'.$timestamp.'_speedApplication.png';
        HighchartsAPI::callForImage($speedApplicationImageName,$jsonString,'600');
        $testTimeArray["callImage"] = Carbon::now()->diffInSeconds($testStart);
   //              		                	echo "<pre>";
   //   		var_dump($topFollowerList);
			// echo "</pre>";
			// return View::make('blank_page');
		//-------------------------GenReport-----------------------	
			
		$filename = 'report'.$timestamp.'.pdf';
		$fpdf = new PDF();
		$fpdf->AliasNbPages('tp');
        $fpdf->AddFont('browa','','browa.php');
        $fpdf->AddFont('browa','B','browab.php');		
		$fpdf->AddFont('browa','I','browai.php');
		$fpdf->AddFont('browa','BI','browaz.php');
		$fpdf->SetFont('browa','B',18);
		$fpdf->SetLeftMargin(10);
        //------------------Page1----------------------
        $fpdf->AddPage();
        $fpdf->MultiCell(0,15,iconv('UTF-8','cp874','รายงานผลการวิเคราะห์ข้อมูลทวิตเตอร์โดยระบบ CU.Tweet'),0,'C');
        $fpdf->SetFont('browa','B',16);
        $x = $fpdf->GetX();
		$y = $fpdf->GetY();
        if($input['type']=='text'){
        	$fpdf->MultiCell(50,10,iconv('UTF-8','cp874','ค้นหาโดยข้อความ/ทวีต : '));
        }
        else{
        	$fpdf->MultiCell(50,10,iconv('UTF-8','cp874','ค้นหาโดยชื่อผู้ใช้ทวิตเตอร์ : '));
        }
        $fpdf->SetXY($x + 50, $y);
        $fpdf->SetFont('browa','',16);
        $fpdf->MultiCell(0,10,iconv('UTF-8','cp874',$searchText));
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','(ค้นหาจากกรณีศึกษา '.ResearchCaseDim::find($caseID)->name.' ตั้งแต่วันที่ '.$startDate.' ถึงวันที่ '.$endDate.')'));
        $fpdf->SetFont('browa','B',16);
        $fpdf->MultiCell(0,10,iconv('UTF-8','cp874','ผลการค้นหา : '));
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1. ค่าสถิติเบื้องต้น'));
        $fpdf->SetFont('browa','',16);
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1.1 จำนวนทวีตทั้งหมด = '.number_format($countAllTweet).' ทวีต'));
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1.2 จำนวนผู้ใช้ทั้งหมด = '.number_format($countAllContributor).' คน'));
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1.3 จำนวนครั้งการเข้าถึง = '.number_format($countAllImpression).' ครั้ง'));
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1.4 สัดส่วนประเภทของทวีต'));
        $fpdf->Image(public_path().'/reportImage/'.$activityImageName,25);
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1.5 สัดส่วนแอพพลิเคชั่นที่ใช้')); 
        $fpdf->Image(public_path().'/reportImage/'.$deviceImageName,25);
        $fpdf->AddPage();
		$fpdf->setX(25);
        $fpdf->MultiCell(0,15,iconv('UTF-8','cp874','1.6 สิบทวีตที่ถูกรีทวีตสูงสุด'));
        $fpdf->SetFont('browa','B',14);
        $fpdf->SetWidths(array(15,28,70,25,25,24));
        $fpdf->SetAligns(array('C','C','C','C','C','C'));
        $fpdf->Row(array(iconv('UTF-8','cp874','อันดับที่'),
        					iconv('UTF-8','cp874','ชื่อผู้ใช้'),
        					iconv('UTF-8','cp874','ข้อความที่ทวีต'),
        					iconv('UTF-8','cp874','แอพพลิเคชั่น'),
        					iconv('UTF-8','cp874','เวลาที่ทวีต'),
        					iconv('UTF-8','cp874','จำนวนรีทวีต')
        	));
        $fpdf->SetFont('browa','',13);
        $fpdf->SetAligns(array('C','L','L','C','C','C'));
        foreach($top10RetweetedList as $key=>$anOriginalTweet){
        	$fpdf->Row(array(@iconv('UTF-8','cp874//IGNORE',$key+1),
        					@iconv('UTF-8','cp874//IGNORE',$anOriginalTweet->original_name."\xA").@iconv('UTF-8','cp874//IGNORE',"@".$anOriginalTweet->original_screenname),
        					@iconv('UTF-8','cp874//IGNORE',$anOriginalTweet->original_text),
        					@iconv('UTF-8','cp874//IGNORE',$anOriginalTweet->original_sourcename),
        					@iconv('UTF-8','cp874//IGNORE',$anOriginalTweet->original_created_at),
        					@iconv('UTF-8','cp874//IGNORE',$anOriginalTweet->totalRetweet)
        	));        	
        }
        //------------------Page3----------------------
        $fpdf->AddPage();
        $fpdf->SetFont('browa','B',16);
        $fpdf->MultiCell(0,15,iconv('UTF-8','cp874','2. กราฟข้อมูลทวีต'));
        $fpdf->SetFont('browa','',16);
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','2.1 กราฟปริมาณข้อมูลทวิตเตอร์ในภาพรวม'));
        $fpdf->Image(public_path().'/reportImage/'.$speedAllActivityImageName,25);
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','2.2 กราฟปริมาณข้อมูลทวิตเตอร์แบ่งตามประเภทกิจกรรม'));
        $fpdf->Image(public_path().'/reportImage/'.$speedActivityTypeImageName,25);
        //------------------Page4----------------------
        $fpdf->AddPage();
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','2.3 กราฟปริมาณข้อมูลทวิตเตอร์แบ่งตามประเภทแอพพลิเคชั่น'));
        $fpdf->Image(public_path().'/reportImage/'.$speedApplicationImageName,25);
        $fpdf->SetFont('browa','B',16);
        $fpdf->MultiCell(0,15,iconv('UTF-8','cp874','3. ผู้มีส่วนร่วมที่สำคัญ'));
        $fpdf->SetFont('browa','',16);
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','3.1 ผู้มีส่วนร่วมที่มีผู้ติดตามมากที่สุด คือ @'.$maxFollowerUser['screenname'].' (มีผู้ติดตามทั้งสิ้น '.number_format($maxFollowerUser['count']).' คน)'));
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','3.2 ผู้มีส่วนร่วมที่ถูกรีทวีตมากที่สุด คือ @'.$maxRetweetedUser['screenname'].' (ถูกรีทวีตทั้งสิ้น '.number_format($maxRetweetedUser['count']).' ครั้ง)'));
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','3.3 ผู้ที่มีส่วนร่วมมากที่สุด คือ @'.$maxActivityUser['screenname'].' (มีส่วนร่วม '.number_format($maxActivityUser['count']).' ครั้ง)'));
        if(count($totalGroup)==0){
        	$fpdf->SetFont('browa','B',16);
	        $fpdf->MultiCell(0,10,iconv('UTF-8','cp874','4. กลุ่มตัวอย่างผู้ใช้ทวิตเตอร์'));
	        $fpdf->SetFont('browa','',16);
	        $fpdf->setX(25);
	        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','ไม่มีสมาชิกในกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์ใดมีส่วนร่วมกับการค้นหานี้'));
        }
        //------------------Page5----------------------
        else{
	        $fpdf->AddPage();
	        $fpdf->SetFont('browa','B',16);
	        $fpdf->MultiCell(0,10,iconv('UTF-8','cp874','4. กลุ่มตัวอย่างผู้ใช้ทวิตเตอร์'));
	        $fpdf->SetFont('browa','',16);
	        $fpdf->setX(25);
	        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','สำหรับกราฟในข้อ 4.1 และ 4.2 Group หมายเลขต่างๆ หมายถึงกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์ดังนี้'));
	        $index = 0;
	        foreach($totalGroup as $aGroup){
	        	$fpdf->setX(35);
	        	$fpdf->MultiCell(0,8,iconv('UTF-8','cp874','Group'.($index+1).' - '.$aGroup['groupname']));
	        	$index++;
	        }
	        $fpdf->setX(25);
	        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','4.1 กราฟแสดงจำนวนทวีตแบ่งตามกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์'));
	        $fpdf->Image(public_path().'/reportImage/'.$interestingContributor1ImageName,25);
	        $fpdf->setX(25);
	        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','4.2  กราฟแสดงจำนวนทวีตแบ่งตามประเภทของทวีต'));
	        $fpdf->Image(public_path().'/reportImage/'.$interestingContributor2ImageName,25);
	    }
        //------------------OutputPage-----------------
        $fpdf->Output(public_path().'/report/'.$filename ,'F');
        $testTimeArray["genPDF"] = Carbon::now()->diffInSeconds($testStart);
        //------------------Create CSV File---------------------
        $filenameCSV = 'report'.$timestamp.'.csv';
        $file = fopen(public_path().'/reportCSV/'.$filenameCSV,"w");
        fputcsv($file, [iconv('UTF-8','cp874','รายงานผลการวิเคราะห์ข้อมูลทวิตเตอร์โดยระบบ CU.Tweet')]);
        if($input['type']=='text'){
        	fputcsv($file, [iconv('UTF-8','cp874','ค้นหาโดย'),iconv('UTF-8','cp874','ข้อความ/ทวีต')]);
        }
        else{
        	fputcsv($file, [iconv('UTF-8','cp874','ค้นหาโดย'),iconv('UTF-8','cp874','ชื่อผู้ใช้ทวิตเตอร์')]);
        }
        fputcsv($file,[iconv('UTF-8','cp874','คำค้นหา'),iconv('UTF-8','cp874',$searchText)]);
        fputcsv($file,[iconv('UTF-8','cp874','ค้นหาจากกรณีศึกษา '),iconv('UTF-8','cp874',ResearchCaseDim::find($caseID)->name)]);
        fputcsv($file,[iconv('UTF-8','cp874','ตั้งแต่วันที่ '),iconv('UTF-8','cp874',' '.$startDate)]);
        fputcsv($file,[iconv('UTF-8','cp874','ถึงวันที่ '),iconv('UTF-8','cp874',' '.$endDate)]);
        //------------------SpeedAndLifeCycleGraph--------------
        fputcsv($file,[]);
        fputcsv($file,[iconv('UTF-8','cp874','1. กราฟข้อมูลทวีต')]);
        fputcsv($file,['Date','Tweets','Retweets','Replies']);
        $graphTweetLen = count($tweetDay[1][0]);
       	for($i=0; $i<$graphTweetLen; $i+=1){
       		fputcsv($file,[' '.(Carbon::createFromDate($tweetDay[1][0][$i]["year"], $tweetDay[1][0][$i]["month"], $tweetDay[1][0][$i]["day"])->toDateString()),$tweetDay[1][0][$i]["num_of_activity"],$tweetDay[1][2][$i]["num_of_activity"],$tweetDay[1][1][$i]["num_of_activity"]]);
       	}
        
        //------------------Contributors--------------
        fputcsv($file,[]);
        fputcsv($file,[iconv('UTF-8','cp874','2. บุคคลที่เกี่ยวข้องทั้งหมด')]);
        fputcsv($file,['Twitter Account','Tweets','Retweets','Replies','Followers']);
        foreach ($TwRtRpUserList as $key => $aSmallList) {
        	foreach ($aSmallList as $key => $aUser) {
        		fputcsv($file,[iconv('UTF-8','cp874','@'.$aUser['screenname']),number_format($aUser['tweetCount']),number_format($aUser['retweetCount']),number_format($aUser['replyCount']),number_format($aUser['followerCount'])]);
        	}
        }
        //------------------Contributors--------------
        fputcsv($file,[]);
        fputcsv($file,[iconv('UTF-8','cp874','3. กลุ่มตัวอย่างผู้ใช้ทวิตเตอร์')]);
        fputcsv($file,['Group','Tweets','Retweets','Replies','BeRetweeted']);
        foreach ($totalGroup as $key => $aGroup) {
        	fputcsv($file,[iconv('UTF-8','cp874',$aGroup['groupname']),number_format($aGroup['tweetCount']),number_format($aGroup['retweetCount']),number_format($aGroup['replyCount']),number_format($aGroup['beRetweetedCount'])]);
        }
        //------------------TweetTimeline--------------
        fputcsv($file,[]);
        fputcsv($file,[iconv('UTF-8','cp874','4. ทวีตทั้งหมดเรียงตามเวลา')]);
        fputcsv($file,['Date-Time','Screenname','Text','Source']);
        foreach ($timelineList as $key => $aTweet) {
        	if($aTweet->real_activitytypekey==3){
        		fputcsv($file,[' '.$aTweet->real_created_at, '@'.$aTweet->real_screenname, @iconv('UTF-8','cp874//IGNORE','RT@'.$aTweet->original_screenname.':'.$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->real_sourcename)]);
        	}
        	else{
        		fputcsv($file,[' '.$aTweet->original_created_at, '@'.$aTweet->original_screenname, @iconv('UTF-8','cp874//IGNORE',$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->original_sourcename)]);
        	}
        }
        fclose($file);
        $testTimeArray["genCSV"] = Carbon::now()->diffInSeconds($testStart);

        //------------------------------------------------------
		$result = ['type'=>$input['type'],
					'caseID' => $caseID,
					'researchCase' => ResearchCaseDim::lists('name', 'researchcasekey'),
					'cases'=> ResearchCaseDim::caseData(),
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'countAllTweet'=>$countAllTweet,
					'countAllContributor'=>$countAllContributor,
					'countAllImpression'=>$countAllImpression,
					'countAct'=> $countAct,
					'sourceProportion'=>$sourceProportion,
					'topRetweetedList'=>$topRetweetedList,
					'top10RetweetedList'=>$top10RetweetedList,
					'topFollowerList'=>$topFollowerList,
					'timelineList'=>$timelineList,
					'maxFollowerUser'=>$maxFollowerUser,
					'maxRetweetedUser' =>$maxRetweetedUser,
					'maxActivityUser'=>$maxActivityUser,
					'tweetMonth' => $tweetMonth,
					'tweetWeek' => $tweetWeek,
					'tweetDay' => $tweetDay,
					'tweetHour' => $tweetHour,
					'TwUserList'=>$TwUserList,
					'RtUserList'=>$RtUserList, 
					'RpUserList'=>$RpUserList, 
					'TwRtUserList'=>$TwRtUserList,
					'RtRpUserList'=>$RtRpUserList,
					'TwRpUserList'=>$TwRpUserList, 
					'TwRtRpUserList'=>$TwRtRpUserList,
					'perPage'=>$perPage,
					'tweetInterestDetailList'=>$tweetInterestDetailList,
					'retweetInterestDetailList'=>$retweetInterestDetailList,
					'replyInterestDetailList'=>$replyInterestDetailList,
					'totalGroupDetail'=>$totalGroup,
					'socialGraphData' => $socialGraphData,
					'slidebarLength' => $slidebarLength,
					'filename' => $filename,
					'filenameCSV' => $filenameCSV
				];
		// $result = $input;
		// return View::make('blank_page');
		return View::make('layouts.mainResultByText',$result);
	}

	public function analyseByUser()
	{
		$timestamp = date('Y-m-d_H-i-s_').rand(1000,9999);
		$input = Input::all();
		$caseID = $input['caseID'];
		$searchText = $input['searchText'];
		$startDate = $input['startDate'];
		$endDate = $input['endDate'];
		if($input['type']=='text'){
			$tweetResultList = TwitterAnalysisFact::searchByText($searchText,$startDate,$endDate,$caseID);
		}
		else{
			$tweetResultList = TwitterAnalysisFact::searchByUser($searchText,$startDate,$endDate,$caseID);
		}
		
		$tweetResult = $tweetResultList->get();

		//Prepare Data for tweet graph
		$allTweetQuery = clone $tweetResultList;
		$tweetMonth = array();
		$tweetWeek = array();
		$tweetDay = array();
		$tweetHour = array();
		AnalysisController::groupTweetForTweetGraph($allTweetQuery,$startDate,$endDate,$tweetMonth,$tweetWeek,$tweetDay,$tweetHour);


		$countAllTweet = sizeof($tweetResult);
		if($countAllTweet==0){
			$filename = 'report'.$timestamp.'.pdf';
			$fpdf = new PDF();
			$fpdf->AliasNbPages('tp');
	        $fpdf->AddFont('browa','','browa.php');
	        $fpdf->AddFont('browa','B','browab.php');		
			$fpdf->AddFont('browa','I','browai.php');
			$fpdf->AddFont('browa','BI','browaz.php');
			$fpdf->SetFont('browa','B',18);
			$fpdf->SetLeftMargin(10);
	        //------------------Page1----------------------
	        $fpdf->AddPage();
	        $fpdf->MultiCell(0,15,iconv('UTF-8','cp874','รายงานผลการวิเคราะห์ข้อมูลทวิตเตอร์โดยระบบ CU.Tweet'),0,'C');
	        $fpdf->SetFont('browa','B',16);
	        $x = $fpdf->GetX();
			$y = $fpdf->GetY();
	        if($input['type']=='text'){
	        	$fpdf->MultiCell(50,10,iconv('UTF-8','cp874','ค้นหาโดยข้อความ/ทวีต : '));
	        }
	        else{
	        	$fpdf->MultiCell(50,10,iconv('UTF-8','cp874','ค้นหาโดยชื่อผู้ใช้ทวิตเตอร์ : '));
	        }
	        $fpdf->SetXY($x + 50, $y);
	        $fpdf->SetFont('browa','',16);
	        $fpdf->MultiCell(0,10,iconv('UTF-8','cp874',$searchText));
	        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','(ค้นหาจากกรณีศึกษา '.ResearchCaseDim::find($caseID)->name.' ตั้งแต่วันที่ '.$startDate.' ถึงวันที่ '.$endDate.')'));
	        $fpdf->SetFont('browa','B',16);
	        $fpdf->MultiCell(0,10,iconv('UTF-8','cp874','ผลการค้นหา : '));
	        $fpdf->SetFont('browa','',16);
	        $fpdf->SetX(25);
	        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','ไม่พบข้อมูลทวีตที่ท่านต้องการค้นหา'));
	        $fpdf->Output(public_path().'/report/'.$filename ,'F');
	        //------------------Create CSV File---------------------
	        $filenameCSV = 'report'.$timestamp.'.csv';
	        $file = fopen(public_path().'/reportCSV/'.$filenameCSV,"w");
	        fputcsv($file, [iconv('UTF-8','cp874','รายงานผลการวิเคราะห์ข้อมูลทวิตเตอร์โดยระบบ CU.Tweet')]);
	        if($input['type']=='text'){
	        	fputcsv($file, [iconv('UTF-8','cp874','ค้นหาโดย'),iconv('UTF-8','cp874','ข้อความ/ทวีต')]);
	        }
	        else{
	        	fputcsv($file, [iconv('UTF-8','cp874','ค้นหาโดย'),iconv('UTF-8','cp874','ชื่อผู้ใช้ทวิตเตอร์')]);
	        }
	        fputcsv($file,[iconv('UTF-8','cp874','คำค้นหา'),iconv('UTF-8','cp874',$searchText)]);
	        fputcsv($file,[iconv('UTF-8','cp874','ค้นหาจากกรณีศึกษา '),iconv('UTF-8','cp874',ResearchCaseDim::find($caseID)->name)]);
	        fputcsv($file,[iconv('UTF-8','cp874','ตั้งแต่วันที่ '),iconv('UTF-8','cp874',' '.$startDate)]);
	        fputcsv($file,[iconv('UTF-8','cp874','ถึงวันที่ '),iconv('UTF-8','cp874',' '.$endDate)]);
	        //------------------SpeedAndLifeCycleGraph--------------
	        fputcsv($file,[]);
	        fputcsv($file,[iconv('UTF-8','cp874','ไม่พบข้อมูลทวีตที่ท่านต้องการค้นหา')]);	        
	        fclose($file);
	        //------------------------------------------------------
			$result = ['type'=>$input['type'],
					'caseID' => $caseID,
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'countAllTweet'=>$countAllTweet,
					'researchCase' => ResearchCaseDim::lists('name', 'researchcasekey'),
					'cases'=> ResearchCaseDim::caseData(),
					'filename' => $filename,
					'filenameCSV' => $filenameCSV];
			return View::make('layouts.notFound',$result);
		}

 //        						// ->get();
 //  //       var_dump($topFollowerList);
	// 	// return View::make('blank_page');
		$tweetResultListTemp = clone $tweetResultList; 
		$tweetResultList = array();
		for($i=0;$i<=20;$i++) $tweetResultList[$i] = clone $tweetResultListTemp;   
        

		$countAllImpression = $tweetResultList[1]->sum('twitter_analysis_fact.number_of_follower');
		$contributorKeyList = $tweetResultList[3]->select('twitter_analysis_fact.userstatisticskey')->distinct()->get();
		$countActList = $tweetResultList[2]					
					->select(
						'twitter_analysis_fact.activitytypekey',						
						DB::raw('count(*) as totalNumber')
						)
					->groupBy('twitter_analysis_fact.activitytypekey')
					->orderBy('twitter_analysis_fact.activitytypekey','asc')
					->get();
		// var_dump($countActList);
		// return View::make('blank_page');
		$sourceKeyList = $tweetResultList[4]
							->select('twitter_analysis_fact.sourcekey',
									DB::raw('count(*) as totalNumber')
								)
							->groupBy('twitter_analysis_fact.sourcekey')
							->orderBy('totalNumber','desc')
							->get();

        $timelineList = $tweetResultList[7]
        		->leftJoin('tweet_dim','twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey')       		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')
        		->leftJoin('twitter_analysis_fact as original_fact','tweet_dim.tweetkey','=','original_fact.tweetkey')
        		->where('original_fact.activitytypekey','<',3)        		
        		->leftJoin('user_dim as user_original','original_fact.userkey','=','user_original.userkey')
        		->leftJoin('source_dim as source_original','original_fact.sourcekey','=','source_original.sourcekey')
        		->leftJoin('tweet_detail_dim as tweet_detail_original','original_fact.tweetdetailkey','=','tweet_detail_original.tweetdetailkey')
        		->leftJoin('tweet_dim as tweet_original','original_fact.tweetkey','=','tweet_original.tweetkey')
        		->select('user_dim.screenname as real_screenname',
        			'source_dim.sourcename as real_sourcename',
        			'tweet_detail_dim.created_at as real_created_at',
        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
        			'twitter_analysis_fact.tweetkey as real_tweetkey',
        			'tweet_original.text as original_text',
        			'tweet_detail_original.created_at as original_created_at',
        			'source_original.sourcename as original_sourcename',
        			'user_original.name as original_name',
        			'user_original.screenname as original_screenname',
        			'user_original.profile_pic_url as original_pic',
        			'date_dim.abbr_nameofday as nameday',
        			'date_dim.date as date',
        			'date_dim.abbr_nameofmonth as month',
        			'date_dim.year as year',
        			'date_dim.thedate as thedate')
        		->get();

			$topRetweetedList = $tweetResultList[11]
				->where('twitter_analysis_fact.activitytypekey','<',3)   
				->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->leftJoin('tweet_dim','twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey')
				->leftJoin('twitter_analysis_fact as all_fact','tweet_dim.tweetkey','=','all_fact.tweetkey')
				->leftJoin('date_dim as all_fact_date_dim','all_fact.datekey','=','all_fact_date_dim.datekey')
				->where('all_fact_date_dim.thedate','>=',new DateTime($startDate))
				->where('all_fact_date_dim.thedate','<=',new DateTime($endDate))
				->select('user_dim.screenname as screenname',
					'user_dim.name as name',
					'user_dim.profile_pic_url as pic',
        			'source_dim.sourcename as sourcename',
        			'tweet_dim.text as text',
        			'tweet_detail_dim.created_at as created_at',
        			'twitter_analysis_fact.tweetkey',
        			DB::raw('count(*) as totalRetweet')) 
        		->groupBy('twitter_analysis_fact.tweetkey')
				->orderBy('totalRetweet','desc')       			
        		->get();
        	// totalRetweet also counts the original tweet edit this in view
        	$retweetInterestList = $tweetResultList[12] //original = retweet by interesting contributor
        		->where('twitter_analysis_fact.activitytypekey','<',3)    
        		->leftJoin('tweet_dim','twitter_analysis_fact.tweetkey','=','tweet_dim.tweetkey')       		                
        		->leftJoin('source_dim','twitter_analysis_fact.sourcekey','=','source_dim.sourcekey')
        		->leftJoin('tweet_detail_dim','twitter_analysis_fact.tweetdetailkey','=','tweet_detail_dim.tweetdetailkey')
        		->orderBy('tweet_detail_dim.created_at','desc')
        		->leftJoin('twitter_analysis_fact as original_fact','tweet_dim.tweetkey','=','original_fact.tweetkey')
        		->where('original_fact.activitytypekey','=',3)        		
        		->leftJoin('date_dim as original_fact_date_dim','original_fact.datekey','=','original_fact_date_dim.datekey')
				->where('original_fact_date_dim.thedate','>=',new DateTime($startDate))
				->where('original_fact_date_dim.thedate','<=',new DateTime($endDate))
				->rightJoin('group_user_mapping','original_fact.userkey','=','group_user_mapping.userkey')
				->rightJoin('usergroup','usergroup.groupid','=','group_user_mapping.groupid')
				->where('group_user_mapping.groupid','<>',"NULL")
				->leftJoin('researchcase_usergroup_mapping','researchcase_usergroup_mapping.groupid','=','group_user_mapping.groupid')
				->where('researchcase_usergroup_mapping.researchcasekey',$caseID)
        		->leftJoin('user_dim as user_original','original_fact.userkey','=','user_original.userkey')
        		->leftJoin('source_dim as source_original','original_fact.sourcekey','=','source_original.sourcekey')
        		->leftJoin('tweet_detail_dim as tweet_detail_original','original_fact.tweetdetailkey','=','tweet_detail_original.tweetdetailkey')
        		->leftJoin('tweet_dim as tweet_original','original_fact.tweetkey','=','tweet_original.tweetkey')
        		->select('user_dim.screenname as real_screenname',
        			'source_dim.sourcename as real_sourcename',
        			'tweet_detail_dim.created_at as real_created_at',
        			'twitter_analysis_fact.number_of_follower as real_no_of_follower',
        			'twitter_analysis_fact.activitytypekey as real_activitytypekey',
        			'twitter_analysis_fact.tweetkey as real_tweetkey',
        			'tweet_original.text as original_text',
        			'tweet_detail_original.created_at as original_created_at',
        			'source_original.sourcename as original_sourcename',
        			'user_original.name as original_name',
        			'user_original.screenname as original_screenname',
        			'user_original.profile_pic_url as original_pic',
        			'original_fact_date_dim.abbr_nameofday as nameday',
        			'original_fact_date_dim.date as date',
        			'original_fact_date_dim.abbr_nameofmonth as month',
        			'original_fact_date_dim.year as year',
        			'original_fact_date_dim.thedate as thedate',
        			'usergroup.groupid as groupid',
					'usergroup.groupname as groupname')
				->orderBy('groupid','asc')
				->orderBy('original_fact_date_dim.thedate','desc');

    		$retweetInterestList2 = clone $retweetInterestList;
			$retweetInterestDetailList = $retweetInterestList
											->get();
			$retweetInterestCountList = $retweetInterestList2
											->select(
												'usergroup.groupid as groupid',
												'usergroup.groupname as groupname',
												DB::raw('count(*) as totalCountInAGroup')
												)
											->groupBy('usergroup.groupid')
											->orderBy('groupid','asc') 
											->get();


		$top10RetweetedList = array();
        if(sizeof($topRetweetedList)<=10) $top10RetweetedList = $topRetweetedList;
        else $top10RetweetedList = array_slice($topRetweetedList, 0,10);

		$sourceList = array();
		foreach($sourceKeyList as $aKey){
			$sourceList[$aKey->sourcekey] = $aKey->totalNumber;
		}
			
		$sourceProportion = array();
		for($i = 1;$i<=5;$i+=1){
			if(sizeof($sourceList)==0) break;
			$maxs = array_keys($sourceList, max($sourceList));
			$sourceProportion[$i] = ['sourceName'=>SourceDim::find($maxs[0])->sourcename,
									'count'=>max($sourceList)];
			unset($sourceList[$maxs[0]]);
		}
		if(sizeof($sourceList)>0) {
			$sourceProportion[6] = ['sourceName'=>'Others',
									'count'=>array_sum($sourceList)];
		}

		$countAct = ['tweet'=>0,'retweet'=>0,'reply'=>0];
		foreach($countActList as $anAct){
			if($anAct->activitytypekey==1) $countAct['tweet'] = $anAct->totalNumber;
			else if($anAct->activitytypekey==3) $countAct['retweet'] = $anAct->totalNumber;
			else $countAct['reply'] = $anAct->totalNumber;
		}
	 	// ----- Statistics Tab -----
		
		$countAllContributor = sizeof($contributorKeyList);
		
		$countAllFollower = 0;
		$user = UserDim::where('name', '=', $searchText)
				->orWhere('screenname', '=', $searchText)
				->firstOrFail();
		$info = TwitterAPIHelper::getUserInfo($user->screenname);
		if(!empty($info)){
			$countAllFollower = $info['followers_count'];
		}

		$followeeInterestList = FolloweeMapping::where('followeeid','=',$user->userid)
									->leftJoin('user_dim','followee_mapping.userkey','=','user_dim.userkey')
									->leftJoin('group_user_mapping','group_user_mapping.userkey','=','followee_mapping.userkey')
									->leftJoin('usergroup','usergroup.groupid','=','group_user_mapping.groupid')
									->where('group_user_mapping.groupid','<>',"NULL")
									->leftJoin('researchcase_usergroup_mapping','researchcase_usergroup_mapping.groupid','=','group_user_mapping.groupid')
									->where('researchcase_usergroup_mapping.researchcasekey',$caseID)
									->select('user_dim.screenname as screenname',
										'user_dim.name as name',
										'user_dim.profile_pic_url as pic',
										'user_dim.description as description',
										'usergroup.groupid as groupid',
										'usergroup.groupname as groupname'
										);
		$followeeInterestList2 = clone $followeeInterestList;
		$followeeInterestDetailList = $followeeInterestList
										->orderBy('groupid','asc')  
										->get();
		$followeeInterestCountList = $followeeInterestList2
										->select(
											'usergroup.groupid as groupid',
											'usergroup.groupname as groupname',
											DB::raw('count(*) as totalCountInAGroup')
											)
										->groupBy('usergroup.groupid')
										->orderBy('groupid','asc') 
										->get();
		
		$totalGroup = array();
		foreach($followeeInterestCountList as $aGroup){
			$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
									  'groupname'=>$aGroup->groupname,
									  'followeeCount'=>$aGroup->totalCountInAGroup,
									  'retweetCount'=>0];
		}
		foreach($retweetInterestCountList as $aGroup){
			if(array_key_exists($aGroup->groupid, $totalGroup)) 
				$totalGroup[$aGroup->groupid]['retweetCount'] = $aGroup->totalCountInAGroup;
			else
				$totalGroup[$aGroup->groupid] = ['groupid'=>$aGroup->groupid, 
									  'groupname'=>$aGroup->groupname,
									  'followeeCount'=>0,
									  'retweetCount'=>$aGroup->totalCountInAGroup];
		}
		
		ksort($totalGroup);

		// $hisGroup = $user->groups;
		$hisGroup = DB::table('user_dim')
					->where(function($query) use($searchText)
			            {
			                $query->where('user_dim.name','=',$searchText)
							->orWhere('user_dim.screenname','=',$searchText);
			            })
					->leftJoin('group_user_mapping','group_user_mapping.userkey','=','user_dim.userkey')
					->leftJoin('researchcase_usergroup_mapping','researchcase_usergroup_mapping.groupid','=','group_user_mapping.groupid')
					->where('researchcase_usergroup_mapping.researchcasekey',$caseID)
					->leftJoin('usergroup','usergroup.groupid','=','group_user_mapping.groupid')
					->get();

		//-------------------------GenImageForReport---------------
		//-----------ActivityPic------------------
		$jsonString = "{
			  	title:{
			      text:''
				 },
			 	 plotOptions: {
			            pie: {
			                dataLabels: {
			                    enabled: true,
			                    format: '<b>{point.name}</b>:<br>{point.y:,.0f} ({point.percentage:.1f} %)',
			                    style: {
			                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
			                    }
			                }
			            }
			        },
				        series: [{
				            type: 'pie',
				            name: 'Application',
				            data: [
								['Tweets',". $countAct['tweet'] ."],
				                ['Retweets',".$countAct['retweet']."],
				                ['Replies',". $countAct['reply']."],
        						]
				        }]

				}";
		$activityImageName = 'report'.$timestamp.'_activityChart.png';
        HighchartsAPI::callForImage($activityImageName,$jsonString,'450');
        //-----------DevicePic------------------
		$jsonString = "{
			  	title:{
			      text:''
				 },
			 	 plotOptions: {
			            pie: {
			                dataLabels: {
			                    enabled: true,
			                    format: '<b>{point.name}</b>:<br>{point.y:,.0f} ({point.percentage:.1f} %)',
			                    style: {
			                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
			                    }
			                }
			            }
			        },
				        series: [{
				            type: 'pie',
				            name: 'Application',
				            data: [";
		foreach($sourceProportion as $aSource){
            		$jsonString .= "['".$aSource['sourceName']."',".$aSource['count']."],";
        }
        $jsonString .= "]
				        }]

				}";
		$deviceImageName = 'report'.$timestamp.'_deviceChart.png';
        HighchartsAPI::callForImage($deviceImageName,$jsonString,'450');
        //-------------------------InterestingContributorGraph1----
   		$jsonString=" {
				        chart: {
				            type: 'column'
				        },
				        title: {
				            text: ''
				        },
				        xAxis: {
				            categories: [";
				            	for($i=1;$i<=count($totalGroup);$i++){
				            		$jsonString.="'Group".$i."',";
				            	}
				            	$jsonString.="],
				            title: {
				                text: null
				            }
				        },
				        yAxis: {
				            min: 0,
				            title: {
				                text: 'Number of Followee / Retweets',
				                align: 'high'
				            },
				            labels: {
				                overflow: 'justify'
				            }
				        },
				        plotOptions: {
				            column: {
				                dataLabels: {
				                    enabled: true,
				                    color: '#666',
				                }
				            }
				        },
				        legend: {
				            layout: 'vertical',
				            align: 'right',
				            verticalAlign: 'top',
				            x: -40,
				            y: 100,
				            floating: true,
				            borderWidth: 1,
				            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				            shadow: true
				        },
				        credits: {
				            enabled: false
				        },
				        series: [{
				            name: 'Followee',
				            data: [";
				            	foreach($totalGroup as $aGroup){
				            		$jsonString.=$aGroup['followeeCount'].",";
				            	}
				            $jsonString.="]
				        }, {
				            name: 'Retweet',
				            data: [";
				            	foreach($totalGroup as $aGroup){
				            		$jsonString.=$aGroup['retweetCount'].",";
				            	}
				            $jsonString.="]
				        }
				        ]
				    }";
		$interestingContributor1ImageName = 'report'.$timestamp.'_interestingContributor1Chart.png';
        HighchartsAPI::callForImage($interestingContributor1ImageName,$jsonString,'450');

        //-----------speedAndlifecyclePic------------------

        //----------- All -------------
		$dayDataForAll = '[';
		$length = count($tweetDay[0]);
		$countLength = 0;
		foreach($tweetDay[0] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForAll .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForAll .= ',';
		}
		$dayDataForAll .= ']';
		
		//--------- ActivityType ------------
		$dayDataForType = "[{name: 'Tweet', data:[";
		$length = count($tweetDay[1][0]);
		$countLength = 0;
		foreach($tweetDay[1][0] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForType .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForType .= ',';
		}
		$dayDataForType .= "]},{name: 'Retweet', data:[";
		$length = count($tweetDay[1][1]);
		$countLength = 0;
		foreach($tweetDay[1][1] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForType .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForType .= ',';
		}
		$dayDataForType .= "]},{name: 'Reply', data:[";
		$length = count($tweetDay[1][2]);
		$countLength = 0;
		foreach($tweetDay[1][2] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForType .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForType .= ',';
		}
		$dayDataForType .= ']}]';

		//-------------- Application -------------
		$dayDataForApplication = "[{name: 'Twitter', data:[";
		$length = count($tweetDay[2][0]);
		$countLength = 0;
		foreach($tweetDay[2][0] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForApplication .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForApplication .= ',';
		}
		$dayDataForApplication .= "]},{name: 'Facebook', data:[";
		$length = count($tweetDay[2][1]);
		$countLength = 0;
		foreach($tweetDay[2][1] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForApplication .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForApplication .= ',';
		}
		$dayDataForApplication .= "]},{name: 'Official news', data:[";
		$length = count($tweetDay[2][2]);
		$countLength = 0;
		foreach($tweetDay[2][2] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForApplication .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForApplication .= ',';
		}
		$dayDataForApplication .= "]},{name: 'Others', data:[";
		$length = count($tweetDay[2][3]);
		$countLength = 0;
		foreach($tweetDay[2][3] as $tweetByDay){
			$tweetDayDate = Carbon::createFromDate($tweetByDay["year"], $tweetByDay["month"], $tweetByDay["day"]);   
			$dayDataForApplication .=  '['.($tweetDayDate->timestamp*1000).','.$tweetByDay['num_of_activity'].']';
			$countLength += 1;
			if($countLength < $length)	$dayDataForApplication .= ',';
		}
		$dayDataForApplication .= ']}]';

        $jsonString = "{
				chart: {
					type: 'area'
				},
				credits: {
					enabled : false
				},
				title: {
						text: '',
				},
				xAxis: {
					type: 'datetime',
					title: {
						text: 'Date-Time'
					},
					minTickInterval: 86400000,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true
				},
				yAxis: {
					floor: 0,
					labels: {
						align: 'right',
						x: -3
					},
					title: {
						text: 'Number of Tweets'
					},
					lineWidth: 2,
					opposite: false,
					offset: 0
					
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: 'horizontal',
					verticalAlign: 'top',
					borderWidth: 1
					
				},
				plotOptions: {
					area: {
						marker: {
							radius: 0,
						}
					}
				},
				series: [{
					name: 'All',
					color: 'rgba(150, 150, 255, 0.5)',
					data: ".$dayDataForAll.",
					fillColor : {
						linearGradient : {
							x1: 0,
							y1: 0,
							x2: 0,
							y2: 1
						},
						stops : [
							[0, Highcharts.getOptions().colors[0]],
							[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
						]
					}
				}]
			}";
		$speedAllActivityImageName = 'report'.$timestamp.'_speedAllActivity.png';
        HighchartsAPI::callForImage($speedAllActivityImageName,$jsonString,'600');


        $jsonString = "{
				chart: {
					type: 'line',
				},
				title: {
						text: '',
				},
				credits: {
					enabled : false
				},
				navigator: {
		            margin: 10
		        },
				xAxis: {
					type: 'datetime',
					title: {
						text: 'Date-Time'
					},
					minTickInterval: 86400000,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true,
				},
				yAxis: {
					floor: 0,
					labels: {
						align: 'right',
						x: -3
					},
					title: {
						text: 'Number of Tweets'
					},
					
					lineWidth: 2,
					opposite: false,
					offset: 0
					
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: 'horizontal',
					verticalAlign: 'top',
					borderWidth: 1
					
				},
				plotOptions: {
					line: {
						marker: {
							radius: 0,
						}
					}
				},
				series: ".$dayDataForType."}";
		
		$speedActivityTypeImageName = 'report'.$timestamp.'_speedActivityType.png';
        HighchartsAPI::callForImage($speedActivityTypeImageName,$jsonString,'600');

        $jsonString = "{
				chart: {
					renderTo: 'applicationGraph',
					type: 'line',
				},
				title: {
						text: '',
				},
				credits: {
					enabled : false
				},
				navigator: {
		            margin: 10
		        },
				xAxis: {
					type: 'datetime',
					title: {
						text: 'Date-Time'
					},
					minTickInterval: 86400000,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true
				},
				yAxis: {
					floor: 0,
					labels: {
						align: 'right',
						x: -3
					},
					title: {
						text: 'Number of Tweets'
					},
					
					lineWidth: 2,
					opposite: false,
					offset: 0
					
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: 'horizontal',
					verticalAlign: 'top',
					borderWidth: 1
					
				},
				plotOptions: {
					line: {
						marker: {
							radius: 0
						}
					}
				},
				series: ".$dayDataForApplication."
			}";
		
		$speedApplicationImageName = 'report'.$timestamp.'_speedApplication.png';
        HighchartsAPI::callForImage($speedApplicationImageName,$jsonString,'600');

		//-------------------------GenReport-----------------------	
			
		$filename = 'report'.$timestamp.'.pdf';
		$fpdf = new PDF();
		$fpdf->AliasNbPages('tp');
        $fpdf->AddFont('browa','','browa.php');
        $fpdf->AddFont('browa','B','browab.php');		
		$fpdf->AddFont('browa','I','browai.php');
		$fpdf->AddFont('browa','BI','browaz.php');
		$fpdf->SetFont('browa','B',18);
		$fpdf->SetLeftMargin(10);
        //------------------Page1----------------------
        $fpdf->AddPage();
        $fpdf->MultiCell(0,15,iconv('UTF-8','cp874','รายงานผลการวิเคราะห์ข้อมูลทวิตเตอร์โดยระบบ CU.Tweet'),0,'C');
        $fpdf->SetFont('browa','B',16);
        $x = $fpdf->GetX();
		$y = $fpdf->GetY();
        if($input['type']=='text'){
        	$fpdf->MultiCell(50,10,iconv('UTF-8','cp874','ค้นหาโดยข้อความ/ทวีต : '));
        }
        else{
        	$fpdf->MultiCell(50,10,iconv('UTF-8','cp874','ค้นหาโดยชื่อผู้ใช้ทวิตเตอร์ : '));
        }
        $fpdf->SetXY($x + 50, $y);
        $fpdf->SetFont('browa','',16);
        $fpdf->MultiCell(0,10,iconv('UTF-8','cp874',$searchText));
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','(ค้นหาจากกรณีศึกษา '.ResearchCaseDim::find($caseID)->name.' ตั้งแต่วันที่ '.$startDate.' ถึงวันที่ '.$endDate.')'));
        $fpdf->SetFont('browa','B',16);
        $fpdf->MultiCell(0,10,iconv('UTF-8','cp874','ผลการค้นหา : '));
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1. ค่าสถิติเบื้องต้น'));
        $fpdf->SetFont('browa','',16);
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1.1 จำนวนทวีตทั้งหมด = '.number_format($countAllTweet).' ทวีต'));
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1.2 จำนวนผู้ติดตามทั้งหมด = '.number_format($countAllFollower).' คน'));
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1.3 จำนวนครั้งการเข้าถึง = '.number_format($countAllImpression).' ครั้ง'));
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1.4 สัดส่วนประเภทของทวีต'));
        $fpdf->Image(public_path().'/reportImage/'.$activityImageName,25);
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','1.5 สัดส่วนแอพพลิเคชั่นที่ใช้')); 
        $fpdf->Image(public_path().'/reportImage/'.$deviceImageName,25);
        $fpdf->AddPage();
		$fpdf->setX(25);
        $fpdf->MultiCell(0,15,iconv('UTF-8','cp874','1.6 สิบทวีตที่ถูกรีทวีตสูงสุด'));
        $fpdf->SetFont('browa','B',14);
        $fpdf->SetWidths(array(15,28,70,25,25,24));
        $fpdf->SetAligns(array('C','C','C','C','C','C'));
        $fpdf->Row(array(iconv('UTF-8','cp874','อันดับที่'),
        					iconv('UTF-8','cp874','ชื่อผู้ใช้'),
        					iconv('UTF-8','cp874','ข้อความที่ทวีต'),
        					iconv('UTF-8','cp874','แอพพลิเคชั่น'),
        					iconv('UTF-8','cp874','เวลาที่ทวีต'),
        					iconv('UTF-8','cp874','จำนวนรีทวีต')
        	));
        $fpdf->SetFont('browa','',13);
        $fpdf->SetAligns(array('C','L','L','C','C','C'));
        foreach($top10RetweetedList as $key=>$anOriginalTweet){
        	$fpdf->Row(array(@iconv('UTF-8','cp874//IGNORE',$key+1),
        					@iconv('UTF-8','cp874//IGNORE',$anOriginalTweet->name."\xA").@iconv('UTF-8','cp874//IGNORE',"@".$anOriginalTweet->screenname),
        					@iconv('UTF-8','cp874//IGNORE',$anOriginalTweet->text),
        					@iconv('UTF-8','cp874//IGNORE',$anOriginalTweet->sourcename),
        					@iconv('UTF-8','cp874//IGNORE',$anOriginalTweet->created_at),
        					@iconv('UTF-8','cp874//IGNORE',($anOriginalTweet->totalRetweet-1))
        	));        	
        }
        //------------------Page3----------------------
        $fpdf->AddPage();
        $fpdf->SetFont('browa','B',16);
        $fpdf->MultiCell(0,15,iconv('UTF-8','cp874','2. กราฟข้อมูลทวีต'));
        $fpdf->SetFont('browa','',16);
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','2.1 กราฟปริมาณข้อมูลทวิตเตอร์ในภาพรวม'));
        $fpdf->Image(public_path().'/reportImage/'.$speedAllActivityImageName,25);
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','2.2 กราฟปริมาณข้อมูลทวิตเตอร์แบ่งตามประเภทกิจกรรม'));
        $fpdf->Image(public_path().'/reportImage/'.$speedActivityTypeImageName,25);
        //------------------Page4----------------------
        $fpdf->AddPage();
        $fpdf->setX(25);
        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','2.3 กราฟปริมาณข้อมูลทวิตเตอร์แบ่งตามประเภทแอพพลิเคชั่น'));
        $fpdf->Image(public_path().'/reportImage/'.$speedApplicationImageName,25);
        $fpdf->SetFont('browa','B',16);
        $fpdf->MultiCell(0,15,iconv('UTF-8','cp874','3. กลุ่มตัวอย่างผู้ใช้ทวิตเตอร์'));
        $fpdf->SetFont('browa','',16);
        $fpdf->setX(25);
        if(count($hisGroup)==0){
        	$fpdf->MultiCell(0,8,iconv('UTF-8','cp874','3.1  @'.$user->screenname.' ไม่อยู่ในกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์ใด'));	
        }
        else{
        	$listOfGroup = '';
        	foreach($hisGroup as $aKey=>$aGroup){
        		if($aKey!==0){
        			$listOfGroup .= ', ';
        		} 
        		$listOfGroup .= $aGroup->groupname;
        	}
        	$fpdf->MultiCell(0,8,iconv('UTF-8','cp874','3.1  @'.$user->screenname.' เป็นหนึ่งในสมาชิกของกลุ่มตัวอย่าง '.$listOfGroup));	
        }
        $fpdf->setX(25);
	    $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','3.2 กราฟแสดงจำนวนกิจกรรมของกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์ที่เกี่ยวข้อง'));
        if(count($totalGroup)==0){
        	$fpdf->setX(35);
	        $fpdf->MultiCell(0,8,iconv('UTF-8','cp874','ไม่มีสมาชิกในกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์ใดทำกิจกรรมเกี่ยวข้องกับผู้ใช้คนนี้'));
        }
        else{
        	$index = 0;
	        foreach($totalGroup as $aGroup){
	        	$fpdf->setX(35);
	        	$fpdf->MultiCell(0,8,iconv('UTF-8','cp874','Group'.($index+1).' - '.$aGroup['groupname']));
	        	$index++;
	        }
	        $fpdf->Image(public_path().'/reportImage/'.$interestingContributor1ImageName,25);
        }
       	//------------------OutputPage-----------------
        $fpdf->Output(public_path().'/report/'.$filename ,'F');

        //------------------Create CSV File---------------------
        $filenameCSV = 'report'.$timestamp.'.csv';
        $file = fopen(public_path().'/reportCSV/'.$filenameCSV,"w");
        fputcsv($file, [iconv('UTF-8','cp874','รายงานผลการวิเคราะห์ข้อมูลทวิตเตอร์โดยระบบ CU.Tweet')]);
        if($input['type']=='text'){
        	fputcsv($file, [iconv('UTF-8','cp874','ค้นหาโดย'),iconv('UTF-8','cp874','ข้อความ/ทวีต')]);
        }
        else{
        	fputcsv($file, [iconv('UTF-8','cp874','ค้นหาโดย'),iconv('UTF-8','cp874','ชื่อผู้ใช้ทวิตเตอร์')]);
        }
        fputcsv($file,[iconv('UTF-8','cp874','คำค้นหา'),iconv('UTF-8','cp874',$searchText)]);
        fputcsv($file,[iconv('UTF-8','cp874','ค้นหาจากกรณีศึกษา '),iconv('UTF-8','cp874',ResearchCaseDim::find($caseID)->name)]);
        fputcsv($file,[iconv('UTF-8','cp874','ตั้งแต่วันที่ '),iconv('UTF-8','cp874',' '.$startDate)]);
        fputcsv($file,[iconv('UTF-8','cp874','ถึงวันที่ '),iconv('UTF-8','cp874',' '.$endDate)]);
        //------------------SpeedAndLifeCycleGraph--------------
        fputcsv($file,[]);
        fputcsv($file,[iconv('UTF-8','cp874','1. กราฟข้อมูลทวีต')]);
        fputcsv($file,['Date','Tweets','Retweets','Replies']);
       	$graphTweetLen = count($tweetDay[1][0]);
       	for($i=0; $i<$graphTweetLen; $i+=1){
       		fputcsv($file,[' '.(Carbon::createFromDate($tweetDay[1][0][$i]["year"], $tweetDay[1][0][$i]["month"], $tweetDay[1][0][$i]["day"])->toDateString()),$tweetDay[1][0][$i]["num_of_activity"],$tweetDay[1][2][$i]["num_of_activity"],$tweetDay[1][1][$i]["num_of_activity"]]);
       	}
        //------------------Contributors--------------
        fputcsv($file,[]);
        fputcsv($file,[iconv('UTF-8','cp874','2. กลุ่มตัวอย่างผู้ใช้ทวิตเตอร์')]);
        fputcsv($file,['Group','Followee','Retweets']);
        foreach ($totalGroup as $key => $aGroup) {
        	fputcsv($file,[iconv('UTF-8','cp874',$aGroup['groupname']),number_format($aGroup['followeeCount']),number_format($aGroup['retweetCount'])]);
        }
        //------------------TweetTimeline--------------
        fputcsv($file,[]);
        fputcsv($file,[iconv('UTF-8','cp874','3. ทวีตทั้งหมดเรียงตามเวลา')]);
        fputcsv($file,['Date-Time','Screenname','Text','Source']);
        foreach ($timelineList as $key => $aTweet) {
        	if($aTweet->real_activitytypekey==3){
        		fputcsv($file,[' '.$aTweet->real_created_at, '@'.$aTweet->real_screenname, @iconv('UTF-8','cp874//IGNORE','RT@'.$aTweet->original_screenname.':'.$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->real_sourcename)]);
        	}
        	else{
        		fputcsv($file,[' '.$aTweet->original_created_at, '@'.$aTweet->original_screenname, @iconv('UTF-8','cp874//IGNORE',$aTweet->original_text), @iconv('UTF-8','cp874//IGNORE',$aTweet->original_sourcename)]);
        	}
        }
        fclose($file);        
        //---------------------------------------------

		$result = ['type'=>$input['type'],
					'caseID' => $caseID,
					'researchCase' => ResearchCaseDim::lists('name', 'researchcasekey'),
					'cases'=> ResearchCaseDim::caseData(),
					'searchText'=>$searchText,
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					'user'=>$user,
					'countAllTweet'=>$countAllTweet,
					'countAllContributor'=>$countAllContributor,
					'countAllFollower'=>$countAllFollower,
					'countAllImpression'=>$countAllImpression,
					'countAct'=> $countAct,
					'sourceProportion'=>$sourceProportion,
					'topRetweetedList'=>$topRetweetedList,
					'top10RetweetedList'=>$top10RetweetedList,
					'followeeInterestDetailList'=>$followeeInterestDetailList,
					'followeeInterestCountList'=>$followeeInterestCountList,
					'retweetInterestDetailList'=>$retweetInterestDetailList,
					'retweetInterestCountList'=>$retweetInterestCountList,
					'hisGroup'=>$hisGroup,
					'timelineList'=>$timelineList,
					'tweetMonth' => $tweetMonth,
					'tweetWeek' => $tweetWeek,
					'tweetDay' => $tweetDay,
					'tweetHour' => $tweetHour,
					'totalGroupDetail'=>$totalGroup,
					'filename'=>$filename,
					'filenameCSV'=>$filenameCSV
				];
		// $result = $input;
		return View::make('layouts.mainResultByUser',$result);
	}
}
