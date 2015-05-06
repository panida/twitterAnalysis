@extends('layouts.default')
@section('customCSS')
    <!-- Custom CSS -->
    <link href="css/heroic-features.css" rel="stylesheet">
    <style>
        
        .jumbotron{
            min-height:530px;
            background-color:rgba(200,210,250,0.5);
        }

        .thumbnailFunction{
            padding-top: 20px; 
            height: 280px;
        }
        .thumbnail{
            margin-bottom: 0px;
        }

        .hero-feature{
            margin-bottom: 0px;
        }

    </style>
@stop

@section('content')
    
    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <div class="col-lg-5">
            <header class="jumbotron hero-spacer">
                <h1>CU.Tweet</h1>
                <p class="onlythaibold" style="font-size:30px;">
                    เว็บไซต์ที่คุณสามารถวิเคราะห์การกระจายตัวของทวีตได้อย่างละเอียดและรอบด้าน ภายใต้ฐานข้อมูลทวิตเตอร์ที่มี</p>
                <p><a class="btn btn-primary btn-large" href="{{URL::to('/databaseDetail')}}">ดูชุดฐานข้อมูล</a>
                </p>
            </header>
        </div>

        <div class="col-lg-7">
            <header class="jumbotron hero-spacer">
                <h1 class="onlythaibold">เริ่มค้นหา</h1>
                <form class="form-horizontal onlythaibold" style="font-size:23px;"role="search" method="POST" action="{{{ URL::to('result') }}}" accept-charset="UTF-8">
                    <div class="form-group top-buffer">
                        <label class="col-lg-4 col-md-4 col-sm-4 control-label">กรณีศึกษา</label>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            {{ Form::select('caseID', array(null=>'กรุณาเลือกกรณีศึกษา')+$researchCase, null , ['class' => 'form-control', 'id'=> 'selectCase', 'required' => 'required', 'style'=>'text-align:center;font-family:tahoma;']) }}
                        </div>
                    </div>

                    <div class="form-group top-buffer">
                        <label class="col-lg-4 col-md-4 col-sm-4 control-label">ค้นหาโดย</label>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            {{ Form::select('type', array('text'=>'ข้อความ/ทวีต','user'=>'ชื่อผู้ใช้ทวิตเตอร์'), 'text', ['class' => 'form-control', 'required' => 'required', 'style'=>'text-align:center;font-family:tahoma;']) }}
                        </div>
                    </div>

                    <div class="form-group top-buffer">
                        <label class="col-lg-4 col-md-4 col-sm-4 control-label">คำค้นหา</label>
                        <div class="col-lg-6 col-md-6 col-sm-6">                                        
                            {{ Form::text('searchText', null, ['class' => 'form-control', 'placeholder' => 'คำที่ต้องการค้นหา', 'required' => 'required', 'style'=>'font-family:tahoma;']) }}
                        </div>
                    </div>

                    <div class="form-group top-buffer">
                        <label class="col-lg-4 col-md-4 col-sm-4 control-label">วันที่เริ่มต้น</label>
                        <div class="col-lg-6 col-md-6 col-sm-6">                                       
                            {{Form::text('startDate', null, [
                                "required" => "required", 
                                "class" => "form-control", 
                                "id" => "datepicker1",
                                "placeholder" => "วันที่เริ่มต้น",
                                'style'=>'font-family:tahoma;'
                            ])}} 
                            <!-- {{ Form::text('startDate', null, ['class' => 'form-control', 'placeholder' => 'วันที่เริ่มต้น', 'required' => 'required', 'style'=>'font-family:tahoma;']) }} -->
                        </div>
                    </div>

                    <div class="form-group top-buffer">
                        <label class="col-lg-4 col-md-4 col-sm-4 control-label">วันที่สิ้นสุด</label>
                        <div class="col-lg-6 col-md-6 col-sm-6">  
                            {{Form::text('endDate', null, [
                                "required" => "required", 
                                "class" => "form-control", 
                                "id" => "datepicker2",
                                "placeholder" => "วันที่สิ้นสุด",
                                'style'=>'font-family:tahoma;'
                            ])}}                                     
                            <!-- {{ Form::text('endDate', null, ['class' => 'form-control', 'placeholder' => 'วันที่สิ้นสุด', 'required' => 'required', 'style'=>'font-family:tahoma;']) }} -->
                        </div>
                    </div>
                    <div class="form-group top-buffer">
                        <div class="col-sm-offset-4 col-sm-4">
                            {{Form::submit("ค้นหา",array("class"=>"btn btn-default","id"=>"searchButton","style"=>"background-color:#00aa00; color:white; font-size:23px;"))}}
                        </div>
                    </div>
                </form>
            </header>
        </div>
        <div class="loader"></div>
        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12 onlythaibold">
                <h2>บริการของเรา</h2>
            </div>
        </div>
        <hr>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center col-md-10 col-md-offset-1 onlythaibold">

            <div class="col-md-4 col-sm-6 hero-feature">
                <div class="thumbnail thumbnailFunction">
                    <img class="top-buffer" src="http://assets3.tweetreach.com/images/home_search.png?1418759198" alt="">
                    <div class="caption">
                        <h2>ค้นหา</h2>
                        <h4 style="font-family:thaisansneue;">สามารถค้นหาได้ทั้งข้อความ ชื่อผู้ใช้ Hashtag หรือแม้กระทั่ง URL ใช้งานง่าย คล่องตัว</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 hero-feature">
                <div class="thumbnail thumbnailFunction">
                    <img class="top-buffer" src="http://assets1.tweetreach.com/images/home_analyze.png?1418759198" alt="">
                    <div class="caption">
                        <h2>วิเคราะห์</h2>
                        <h4 style="font-family:thaisansneue;">วิเคราะห์ค่าทางสถิติ อัตราการแพร่กระจายของทวีต เครื่องมือที่ใช้ รวมถึงบุคคลที่มีอิทธิพลจากการค้นหาครั้งนั้นๆ</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 hero-feature">
                <div class="thumbnail thumbnailFunction">
                    <img class="top-buffer" src="http://assets0.tweetreach.com/images/home_report.png?1418759198" alt="">
                    <div class="caption">
                        <h2>รายงานผล</h2>
                        <h4 style="font-family:thaisansneue;">แสดงผลด้วยกราฟและแผนภูมิแบบ Interactive ง่ายต่อการเข้าใจ อีกทั้งสามารถ export รายงานออกเป็นไฟล์ pdf ได้อีกด้วย</h4>
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <!-- /.row -->

        
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
        $( "#selectCase" ).change(function() {
            var cases = {{json_encode($cases)}};
            $("#datepicker1").val(cases[$("#selectCase").val()]['startdate']);
            $("#datepicker2").val(cases[$("#selectCase").val()]['enddate']);
        });
        $("#searchButton").click(function(){
            $(".loader").show();
        });
        </script>
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