@extends('layouts.mainResult')
@section('TabContent')
<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
	<ul class="nav nav-tabs" role="tablist">
		<li><a href="{{URL::to('result/statistics')}}">Statistics</a></li>
		<li><a href="{{URL::to('result/speedAndLifeCycle')}}">Speed and Life Cycle</a></li>
		<li><a href="{{URL::to('result/contributor')}}">Contributor</a></li>
		<li><a href="{{URL::to('result/tweetTimeline')}}">Tweet Timeline</a></li>
		<li class="active"><a href="{{URL::to('result/device')}}">Device</a></li>
	</ul>
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="col-lg-6">

				<div class="flot-chart">
					<div class="flot-chart-content" id="flot-pie-chart" style="padding: 0px; position: relative;"><canvas class="base" width="336" height="400"></canvas><canvas class="overlay" width="336" height="400" style="position: absolute; left: 0px; top: 0px;"></canvas><div class="legend"><div style="position: absolute; width: 57px; height: 68px; top: 5px; right: 5px; opacity: 0.85; background-color: rgb(255, 255, 255);"> </div><table style="position:absolute;top:5px;right:5px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(237,194,64);overflow:hidden"></div></div></td><td class="legendLabel">Series 0</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(175,216,248);overflow:hidden"></div></div></td><td class="legendLabel">Series 1</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(203,75,75);overflow:hidden"></div></div></td><td class="legendLabel">Series 2</td></tr><tr><td class="legendColorBox"><div style="border:1px solid #ccc;padding:1px"><div style="width:4px;height:0;border:5px solid rgb(77,167,77);overflow:hidden"></div></div></td><td class="legendLabel">Series 3</td></tr></tbody></table></div></div>
				</div>
				<div class="text-right">
					<a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>


		</div>
	</div>
</div>
@stop