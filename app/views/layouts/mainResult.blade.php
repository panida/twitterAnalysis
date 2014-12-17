@extends('layouts.default')
@section('customCSS')
	<!-- Custom CSS -->
	<link href="{{URL::asset('css/sb-admin.css')}}" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="{{URL::asset('font-awesome-4.1.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
	<!-- statistics CSS-->
	@include('result.statisticsCSS')
	@include('result.speedAndLifeCycleCSS')	
@stop

@section('content')
	<br><br><br>

	<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 top-buffer" style="background-color:rgba(200,210,250,0.5); border-radius: 10px;">
        <h3 class="thaibold" style="margin-left: 10px;">
				ค้นหา
		</h3>
		<div class="row">
			<form class="form-horizontal thaibold" style="font-size:23px;"role="search" method="POST" action="{{{ URL::to('result') }}}" accept-charset="UTF-8">
                <div class="form-group" style="margin-left: 10px">
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        {{ Form::select('type', array('text'=>'ข้อความ','user'=>'ชื่อผู้ใช้'), 'text', ['class' => 'form-control', 'required' => 'required', 'style'=>'text-align:center;font-family:tahoma;']) }}
                    </div>
                
                    <div class="col-lg-5 col-md-6 col-sm-6">                                        
                        {{ Form::text('searchText', null, ['class' => 'form-control', 'placeholder' => 'คำที่ต้องการค้นหา', 'required' => 'required', 'style'=>'font-family:tahoma;']) }}
                    </div>
                
                    <div class="col-lg-2 col-md-6 col-sm-6">                                       
                        {{Form::text('startDate', null, [
                            "required" => "required", 
                            "class" => "form-control", 
                            "id" => "datepicker1",
                            "placeholder" => "วันที่เริ่มต้น",
                            'style'=>'font-family:tahoma;'
                        ])}} 
                        <!-- {{ Form::text('startDate', null, ['class' => 'form-control', 'placeholder' => 'วันที่เริ่มต้น', 'required' => 'required', 'style'=>'font-family:tahoma;']) }} -->
                    </div>
                
                    <div class="col-lg-2 col-md-6 col-sm-6">  
                        {{Form::text('endDate', null, [
                            "required" => "required", 
                            "class" => "form-control", 
                            "id" => "datepicker2",
                            "placeholder" => "วันที่สิ้นสุด",
                            'style'=>'font-family:tahoma;'
                        ])}}                                     
                        <!-- {{ Form::text('endDate', null, ['class' => 'form-control', 'placeholder' => 'วันที่สิ้นสุด', 'required' => 'required', 'style'=>'font-family:tahoma;']) }} -->
                    </div>
                
                    <div class="col-lg-1 col-md-6 col-sm-6">
                    	<button type="submit" class="btn btn-default" style="background-color:#00aa00; color:white;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </div>
                </div>
            </form>
		</div>
    </div>
    
    <style>
    .input-group .form-control{
        z-index: 0;
    }
    </style>
    {{ HTML::style('css/jquery-ui.css'); }}
    {{ HTML::script('js/jquery-ui-1.10.4.min.js'); }}
   
    <script>
    $(function() {
        $("#datepicker1").datepicker({
            dateFormat: "yy-mm-dd",
            // minDate: "+1d",
            dayNamesMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
            monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" ]
        });
        $("#datepicker2").datepicker({
            dateFormat: "yy-mm-dd",
            // minDate: "+1d",
            dayNamesMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
            monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" ]
        });
    });
    </script>

	<div class="row">
		<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
			<h1 class="page-header thaibold">
				Search: {{$searchText}}
			</h1>
		</div>
	</div>
	<!-- /.row -->
	<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
	<ul id="tabMenu" class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#statistics" data-toggle="tab">Statistics</a></li>
		<li><a href="#speedAndLifeCycle" data-toggle="tab">Speed and Life Cycle</a></li>
		<li><a href="#contributor" data-toggle="tab">Contributor</a></li>
		<li><a href="#tweetTimeline" data-toggle="tab">Tweet Timeline</a></li>
	</ul>


	<div id="myTabContent" class="tab-content">
	   	<div class="tab-pane fade in active" id="statistics">
			@include('result.statistics')	        
	   	</div>
	   	<div class="tab-pane fade" id="speedAndLifeCycle">
	      	@include('result.speedAndLifeCycle')	
	   	</div>
	   	<div class="tab-pane fade" id="contributor">
	   		@include('result.contributor')
	   	</div>
	   	<div class="tab-pane fade" id="tweetTimeline">
	      	@include('result.tweetTimeline')
	   	</div>
	</div>


@stop


@section('footer')



@stop
