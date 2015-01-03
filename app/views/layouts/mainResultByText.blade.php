@extends('layouts.default')
@section('customCSS')
	<!-- Custom CSS -->
	<link href="{{URL::asset('css/sb-admin.css')}}" rel="stylesheet">

	<!-- Custom Fonts -->
	
	<!-- statistics CSS-->
	@include('resultByText.statisticsCSS')
	@include('resultByText.speedAndLifeCycleCSS')	
     <script>
        $(function() {
            $( document ).tooltip({
                position:{
                    my: "center bottom-20",
                    at: "center top",
                }
            });
        });
    </script>
@stop

@section('content')
	<br><br><br>

	<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 top-buffer" style="background-color:rgba(200,210,250,0.5); border-radius: 10px;">
<!--         <h3 class="thaibold" style="margin-left: 10px;">
				ค้นหา
		</h3> -->
		<div class="row">
			<form class="form-horizontal thaibold" style="font-size:23px;"role="search" method="POST" action="{{{ URL::to('result') }}}" accept-charset="UTF-8">
                <div class="form-group" style="margin-left: 10px">
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <h3>ค้นหากรณีศึกษา</h3>
                        {{ Form::select('caseID', array(null=>'กรุณาเลือกกรณีศึกษา')+$researchCase, $caseID , ['class' => 'form-control', 'required' => 'required', 'style'=>'text-align:center;font-family:tahoma;']) }}
                    </div>

                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <h3>โดย</h3>
                        {{ Form::select('type', array('text'=>'ข้อความ','user'=>'ชื่อผู้ใช้'), $type, ['class' => 'form-control', 'required' => 'required', 'style'=>'text-align:center;font-family:tahoma;']) }}
                    </div>
                
                    <div class="col-lg-3 col-md-6 col-sm-6">  
                        <h3>คำค้นหา</h3>                                      
                        {{ Form::text('searchText', $searchText, ['class' => 'form-control', 'placeholder' => 'คำที่ต้องการค้นหา', 'required' => 'required', 'style'=>'font-family:tahoma;']) }}
                    </div>
                
                    <div class="col-lg-2 col-md-6 col-sm-6"> 
                        <h3>วันที่เริ่มต้น</h3>                                      
                        {{Form::text('startDate', $startDate, [
                            "required" => "required", 
                            "class" => "form-control", 
                            "id" => "datepicker1",
                            "placeholder" => "วันที่เริ่มต้น",
                            'style'=>'font-family:tahoma;'
                        ])}} 
                        <!-- {{ Form::text('startDate', null, ['class' => 'form-control', 'placeholder' => 'วันที่เริ่มต้น', 'required' => 'required', 'style'=>'font-family:tahoma;']) }} -->
                    </div>
                
                    <div class="col-lg-2 col-md-6 col-sm-6">  
                        <h3>วันที่สิ้นสุด</h3>
                        {{Form::text('endDate', $endDate, [
                            "required" => "required", 
                            "class" => "form-control", 
                            "id" => "datepicker2",
                            "placeholder" => "วันที่สิ้นสุด",
                            'style'=>'font-family:tahoma;'
                        ])}}                                     
                        <!-- {{ Form::text('endDate', null, ['class' => 'form-control', 'placeholder' => 'วันที่สิ้นสุด', 'required' => 'required', 'style'=>'font-family:tahoma;']) }} -->
                    </div>
                
                    <div class="col-lg-1 col-md-6 col-sm-6">
                        <h3>&nbsp;</h3>
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
			@if($type=='text')
                <h1 class="page-header onlythaibold">
    				ค้นหาข้อความ: {{$searchText}}
    			</h1>
            @else
                <h1 class="page-header onlythaibold">
                    ค้นหาผู้ใช้: {{$searchText}}
                </h1>
            @endif
		</div>
	</div>

    @if($countAllTweet>0)
	<!-- /.row -->
	<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
	<ul id="tabMenu" class="nav nav-tabs onlythaibold" role="tablist" style="font-size:20px;">

		<li class="active"><a href="#statistics" onmouseout="resize()" data-toggle="tab">ค่าสถิติเบื้องต้น</a></li>
		<li><a href="#speedAndLifeCycle" onmouseout="resize()" data-toggle="tab">กราฟข้อมูลทวีต</a></li>
		<li><a href="#contributor" onmouseout="resize();valueChanged();" data-toggle="tab">บุคคลที่เกี่ยวข้อง</a></li>
        <li><a href="#interestingContributor" onmouseout ="resize()" data-toggle="tab">กลุ่มตัวอย่างวิจัย</a></li>
        <li><a href="#twitterSocialGraph" onmouseout="resize()" data-toggle="tab">การแพร่กระจายของทวีต</a></li>
		<li><a href="#tweetTimeline" onmouseout="resize()" data-toggle="tab">รายการทวีตทั้งหมด</a></li>
	</ul>
    <script type="text/javascript">
        function resize()
        {
            $(window).resize();
        }
    </script>

	<div id="myTabContent" class="tab-content">
	   	<div class="tab-pane fade in active" id="statistics">
			@include('resultByText.statistics')	        
	   	</div>
        <div class="tab-pane fade" id="speedAndLifeCycle">
            @include('resultByText.speedAndLifeCycle')    
        </div>
	   	<div class="tab-pane fade" id="contributor">
	   		@include('resultByText.contributor')
	   	</div>
        <div class="tab-pane fade" id="interestingContributor">
            @include('resultByText.interestingContributor')
        </div>
        <div class="tab-pane fade" id="twitterSocialGraph">
            @include('resultByText.twitterSocialGraph')
        </div>
	   	<div class="tab-pane fade" id="tweetTimeline">
	      	@include('resultByText.tweetTimeline')
	   	</div>
	</div>
    
    @else
        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
            <p class="thaibold" style="font-size:25px;">ไม่พบข้อมูลทวีตที่ท่านต้องการค้นหา</p>
        </div>
    @endif

@stop


@section('footer')
<script src="{{URL::asset('js/bootstrap-tabdrop.js')}}"></script>
<script>
$(function(){
    // if($('.nav-pills').tabdrop('layout')==false)
        $('.nav-pills').tabdrop({text: 'More'});    
});
</script>
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<!-- <script src="http://code.highcharts.com/highcharts.js"></script> -->
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/drilldown.js"></script>


@stop
