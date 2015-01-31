@extends('layouts.default')
@section('customCSS')
    <!-- Custom CSS -->


@stop

@section('content')
    <br><br>
    <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
        <h1 class="page-header onlythaibold">
            ชุดฐานข้อมูล
        </h1>
        <h3 class="onlythaibold">
            @if(sizeof($db)==0)
            <i class="fa fa-fw fa-database" style="color:grey;"></i> ปัจจุบันระบบ CU.Tweet ไม่มีฐานข้อมูลกรณีศึกษา
            @else
            <i class="fa fa-fw fa-database" style="color:grey;"></i> ปัจจุบันระบบ CU.Tweet มีฐานข้อมูลกรณีศึกษาทั้งสิ้น {{sizeof($db)}} กรณี ได้แก่
            @endif
        </h3>
        <br>
        @if(sizeof($db)>0)
        <div class="panel-group" id="accordion1" style="font-family:thaisansneue; font-size:18px;">
            @foreach($db as $aCase)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion1" href="{{'#collapse1-'.$aCase->researchcasekey}}" style="font-size:20px;">{{$aCase->name}}</a>
                    </h4>
                </div>
                <div id="{{'collapse1-'.$aCase->researchcasekey}}" class="panel-collapse collapse">
                    <div class="panel-body">
                    <ul>
                        <li>ทวีตประกอบไปด้วยคำว่า : {{$aCase->keywords}}</li>
                        <li>วันที่เริ่มเก็บข้อมูล : {{(new DateTime($aCase->startdate))->format('l d/m/Y')}}</li>
                        <li>วันสิ้นสุดการเก็บข้อมูล : {{(new DateTime($aCase->enddate))->format('l d/m/Y')}}</li>
                        <li>รายละเอียดกรณีศึกษา : {{$aCase->description}}</li>
                    </ul>               
                    </div>
                </div>
            </div> 
            @endforeach           
        </div>
        @endif
        <hr>


@stop

@section('footer')
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; CU.Tweet 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->
@stop