@extends('layouts.default')
@section('customCSS')
	<!-- Custom CSS -->
	<link href="{{URL::asset('css/sb-admin.css')}}" rel="stylesheet">

	<!-- Custom Fonts -->
	
	<!-- statistics CSS-->

	@include('resultByUser.statisticsCSS')
    <!-- speedAndLifeCycle CSS-->
    @include('resultByText.speedAndLifeCycleCSS')
    
    <script>
        $(function() {
            $( document ).tooltip({
                position:{
                    my: "center bottom-10",
                    at: "center top",
                }
                // position:{ my: "left top+15", at: "left bottom", collision: "flipfit" }
            });
        });
    </script>
@stop

@section('content')
	@include('layouts.topSearch')

    @if($countAllTweet>0)
	<!-- /.row -->
	<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
	<ul id="tabMenu" class="nav nav-tabs onlythaibold" role="tablist" style="font-size:20px;">

		<li class="active"><a href="#statistics" onmouseout="resize()" data-toggle="tab">ค่าสถิติเบื้องต้น</a></li>
		<li><a href="#speedAndLifeCycle" onmouseout="resize()" data-toggle="tab">กราฟข้อมูลทวีต</a></li>
		<li><a href="#interestingContributor" onmouseout ="resize()" data-toggle="tab">กลุ่มตัวอย่างผู้ใช้ทวิตเตอร์</a></li>
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
			@include('resultByUser.statistics')       
	   	</div>
        <div class="tab-pane fade" id="speedAndLifeCycle">
            @include('resultByUser.speedAndLifeCycle')
        </div>
        <div class="tab-pane fade" id="interestingContributor">
            @include('resultByUser.interestingContributor')
        </div>
	   	<div class="tab-pane fade" id="tweetTimeline">
            @include('resultByUser.tweetTimeline')
	   	</div>
	</div>
    
    @else
        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
            <p class="thaibold" style="font-size:25px;">ไม่พบข้อมูลทวีตที่ท่านต้องการค้นหา</p>
        </div>
    @endif

@stop


@section('footer')
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    <p>Copyright &copy; CU.Tweet 2014</p>
                </div>
            </div>
        </footer>

    </div>
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
