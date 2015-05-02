@extends('layouts.default')
@section('customCSS')
	<!-- Custom CSS -->
	<link href="{{URL::asset('css/sb-admin.css')}}" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="{{URL::asset('font-awesome-4.1.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
	<!-- statistics CSS-->
@stop

@section('content')
    @include('layouts.topSearch')
 
    <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
        <p class="thaibold" style="font-size:25px;">ไม่พบข้อมูลทวีตที่ท่านต้องการค้นหา</p>
    </div>

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
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<!-- <script src="http://code.highcharts.com/highcharts.js"></script> -->
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/drilldown.js"></script>





@stop
