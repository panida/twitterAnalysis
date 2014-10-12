@extends('layouts.mainResult')
@section('additionalAsset')
<!-- Flot Charts JavaScript -->
<!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
<script src="{{URL::asset('js/plugins/flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('js/plugins/flot/jquery.flot.pie.js')}}"></script>

<style>
#pieflot { width: 300px; height: 300px; }
.legend table, .legend > div { height: 82px !important; opacity: 1 !important; left: 330px; top: 10px; width: 116px !important; }
.legend table { border: none solid #555; padding: 5px; }
#pieHover { width: 350px; height: 150px; }
</style>

<!-- Javascript -->
<script type="text/javascript">

var data = [
{label: "web", data:40},
{label: "android", data: 30},
{label: "iphone", data: 25},
{label: "blackberry", data: 15},
{label: "facebook", data: 18},
{label: "others", data: 10},

];


$(document).ready(function () {
	$.plot($("#pieflot"), data, {
		series: {
			pie: {
				show: true
			}
		},
		grid: {
			hoverable: true
		},
		legend: {
			labelBoxBorderColor: "none"
		}
	});
	$("#pieflot").bind("plothover", pieHover);

});
 
function pieHover(event, pos, obj) {
    if (!obj)
        return;
 
    percent = parseFloat(obj.series.percent).toFixed(2);
    $("#pieHover").html('<span style="font-weight: bold; color: '+obj.series.color+'">'+obj.series.label+' ('+percent+'%)</span>');
}

</script>
@stop

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

			<div class="col-lg-4 col-lg-offset-4 " style="top:50px">					
				<div id="pieflot"></div>
				<div id="pieHover"></div>

			</div>

		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- /#page-wrapper -->
</div>
@stop