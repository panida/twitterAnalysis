<?php

class ResearchCaseDim extends Eloquent
{
	protected $table = 'research_case_dim';
	
	public $timestamps = false;

	public $errors;

	protected $primaryKey = "researchcasekey";


	public static function caseData(){
		$allCase = ResearchCaseDim::select('researchcasekey','name','startdate','enddate')->get();
		$cases[null] =  [	'name'=>null,
							'startdate'=>null,
							'enddate'=>null];
		foreach($allCase as $aCase){
			$cases[$aCase->researchcasekey] = [	'name'=>$aCase->name,
												'startdate'=>date_format(date_create($aCase->startdate),'Y-m-d'),
												'enddate'=>date_format(date_create($aCase->enddate),'Y-m-d')];
		}
		return $cases;
	}

	public function userGroups()
    {
        return $this->belongsToMany('UserGroup', 'researchcase_usergroup_mapping', 'researchcasekey', 'groupid');
    }

}