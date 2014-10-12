@extends('layouts.mainResult')

@section('specialCSS')
	<link rel="stylesheet" type="text/css" media="screen" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/master/build/css/bootstrap-datetimepicker.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.1/css/font-awesome.css" rel="stylesheet">
@stop

@section('TabContent')
<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
	<ul class="nav nav-tabs" role="tablist">
		<li><a href="{{URL::to('result/statistics')}}">Statistics</a></li>
		<li><a href="{{URL::to('result/speedAndLifeCycle')}}">Speed and Life Cycle</a></li>
		<li><a href="{{URL::to('result/contributor')}}">Contributor</a></li>
		<li class="active"><a href="{{URL::to('result/tweetTimeline')}}">Tweet Timeline</a></li>
		<li><a href="{{URL::to('result/device')}}">Device</a></li>
	</ul>
</div>

		
	<div class="col-lg-2 col-lg-offset-1 col-md-2 col-md-offset-1" style="margin-top:10px;">
		<div class="container">
		       	<h5>Filter By Date: </h5>
		    	
		        <div class='col-lg-2'>
		        	From
		            <div class="form-group">
		                <div class='input-group date' id='datetimepicker9'>
		                    <input type='text' class="form-control" />
		                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>
		            To
		            <div class="form-group">
		                <div class='input-group date' id='datetimepicker10'>
		                    <input type='text' class="form-control" />
		                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>
		        </div>
		    <script type="text/javascript">
		        $(function () {
		            $('#datetimepicker9').datetimepicker();
		            $('#datetimepicker10').datetimepicker();
		            $("#datetimepicker9").on("dp.change",function (e) {
		               $('#datetimepicker10').data("DateTimePicker").setMinDate(e.date);
		            });
		            $("#datetimepicker10").on("dp.change",function (e) {
		               $('#datetimepicker9').data("DateTimePicker").setMaxDate(e.date);
		            });
		        });
		    </script>
		</div>
	</div>
	<div class="col-lg-7 col-md-7" style="margin-top:10px;">
        <a class="twitter-timeline"  
        	width="600"
        	height="400"
        	href="https://twitter.com/search?q=%E0%B8%A3%E0%B8%B1%E0%B8%90%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B8%AB%E0%B8%B2%E0%B8%A3" 
        	data-widget-id="521198386687401984">
        	ทวีตเกี่ยวกับ "รัฐประหาร"</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>

    	
    <script type="text/javascript" src={{URL::asset("js/moment.js")}}></script>
    <script type="text/javascript" src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/master/src/js/bootstrap-datetimepicker.js"></script>
@stop