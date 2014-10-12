@extends('layouts.mainResult')
@section('TabContent')
<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
	<ul class="nav nav-tabs" role="tablist">
		<li><a href="{{URL::to('result/statistics')}}">Statistics</a></li>
		<li class="active"><a href="{{URL::to('result/speedAndLifeCycle')}}">Speed and Life Cycle</a></li>
		<li><a href="{{URL::to('result/contributor')}}">Contributor</a></li>
		<li><a href="{{URL::to('result/tweetTimeline')}}">Tweet Timeline</a></li>
		<li><a href="{{URL::to('result/device')}}">Device</a></li>
	</ul>
</div>
@stop