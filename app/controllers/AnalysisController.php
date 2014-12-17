<?php

class AnalysisController extends BaseController {

	public function analyse()
	{
		$input = Input::all();
		$result = $input;
		return Redirect::to('result/statistics')->with('result',$result);
		// return View::make('result.statistics',$result);
	}

	public function showStatistics(){
		$result = Session::get('result');
		return View::make('result.statistics',$result);
	}

	public function showSpeedAndLifeCycle(){
		$result = Session::get('result');
		return View::make('result.speedAndLifeCycle',$result);
	}

	public function showContributor(){
		$result = Session::get('result');
		return View::make('result.contributor',$result);
	}

	public function showTweetTimeline(){
		$result = Session::get('result');
		return View::make('result.tweetTimeline',$result);
	}

}
