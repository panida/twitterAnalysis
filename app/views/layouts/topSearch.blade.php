	<br><br><br>

	<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 top-buffer" style="background-color:rgba(200,210,250,0.5); border-radius: 10px;">

		<div class="row">
			<form class="form-horizontal onlythaibold" style="font-size:23px;"role="search" method="POST" action="{{{ URL::to('result') }}}" accept-charset="UTF-8">
                <div class="form-group" style="margin-left: 10px; margin-bottom: 0px;">
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <h3>ค้นหากรณีศึกษา</h3>
                        {{ Form::select('caseID', array(null=>'กรุณาเลือกกรณีศึกษา')+$researchCase, $caseID , ['class' => 'form-control', 'required' => 'required', 'id'=> 'selectCase', 'style'=>'text-align:center;font-family:tahoma;']) }}
                    </div>

                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <h3>โดย</h3>
                        {{ Form::select('type', array('text'=>'ข้อความ/ทวีต','user'=>'ชื่อผู้ใช้ทวิตเตอร์'), $type, ['class' => 'form-control', 'required' => 'required', 'style'=>'text-align:center;font-family:tahoma;']) }}
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
                    {{Form::hidden('oldSearchText',$searchText)}}
                
                    <div class="col-lg-1 col-md-6 col-sm-6">
                        <h3>&nbsp;</h3>
                    	<button type="submit" class="btn btn-default" id="searchButton" style="background-color:#00aa00; color:white;"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </div>
                </div>
            </form>
		</div>
        <h4 style="margin-left: 10px; color:rgb(50,50,150);">
            <i class="glyphicon glyphicon-calendar"></i>&nbsp;
            <span class="onlythaibold" id="rangeResearchText" style="padding-top:10px;">
                กรณีศึกษา {{$cases[$caseID]['name']}} จัดเก็บข้อมูลตั้งแต่ {{$cases[$caseID]['startdate']}} ถึง {{$cases[$caseID]['enddate']}}
            </span>
        </h4>
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
    $( "#selectCase" ).change(function() {
        var cases = {{json_encode($cases)}};
        $("#datepicker1").val(cases[$("#selectCase").val()]['startdate']);
        $("#datepicker2").val(cases[$("#selectCase").val()]['enddate']);
        if(cases[$("#selectCase").val()]["name"]==null){
            $("#rangeResearchText").text('กรุณาเลือกกรณีศึกษาที่ต้องการค้นหา');
        }
        else{
        $("#rangeResearchText").text(
            'กรณีศึกษา '.concat(cases[$("#selectCase").val()]["name"],' จัดเก็บข้อมูลตั้งแต่ ',cases[$("#selectCase").val()]["startdate"], ' ถึง ', cases[$("#selectCase").val()]["enddate"])
            );
        }
    });
    </script>

	<div class="row">
		<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">			
            <h1 class="page-header onlythaibold">
                @if($type=='text')
				ค้นหาข้อความ/ทวีต: {{$searchText}}
                @else
                ค้นหาผู้ใช้ทวิตเตอร์: {{$searchText}}
                @endif
                <span class="pull-right">
                    @if($countAllTweet<=100000)
                    <a id="csvTag" href="javascript:alert('ขณะนี้ระบบกำลังจัดเตรียมไฟล์ กรุณาลองอีกครั้งเมื่อสัญลักษณ์เป็นสีเขียว')" style="text-decoration:none;">
                    @elseif($countAllTweet<=500000)
                    <a id="csvTag" href="javascript:alert('ไฟล์รีพอร์ทมีขนาดใหญ่เกินไปและอาจประสบปัญหาในการดาวน์โหลด ควรเปลี่ยนคำค้นหาหรือช่วงเวลาการค้นหาให้เฉพาะเจาะจงยิ่งขึ้น')" style="text-decoration:none;">
                    @else
                    <a id="csvTag" href="javascript:alert('ไฟล์รีพอร์ทมีขนาดใหญ่เกินไปและไม่สามารถดาวน์โหลดได้ ควรเปลี่ยนคำค้นหาหรือช่วงเวลาการค้นหาให้เฉพาะเจาะจงยิ่งขึ้น')" style="text-decoration:none;">
                    @endif
                        <i id ="csvLogo" class="fa fa-file-excel-o" style="font-size:22px; color:rgb(200,200,200);"></i>
                    </a>
                    <a href="{{ URL::action('ReportController@getDownloadPDF',[$filename]) }}">
                        <i class="fa fa-file-pdf-o" style="font-size:22px; color:rgb(200,10,10);"></i>
                    </a> 
                </span>
			</h1>            
		</div>
	</div>
    
     <script type="text/javascript">

            $(function() {                  
                $.post("{{url('/')}}/generateCSV",
                {caseID: "{{$caseID}}",
                timestamp:"{{$timestamp}}",
                type: "{{$type}}",
                searchText:"{{$searchText}}",
                startDate:"{{$startDate}}",
                endDate:"{{$endDate}}",
                filename:"{{$filenameCSV}}" }
                ,
                function(data, status){
                    if(status=='success' && {{$countAllTweet}}<=500000){
                        $('#csvLogo').css('color','rgb(10,100,10)');
                        $('#csvTag').attr("href","{{ URL::action('ReportController@getDownloadCSV',[$filenameCSV]) }}");
                    }
                });

                $("#searchButton").click(function(){
                    $(".loader").show();
                });
                // else{
                //     $('#csvLogo').css('color','rgb(10,100,10)');
                //     $('#csvTag').attr("href","{{ URL::action('ReportController@getDownloadCSV',[$filenameCSV]) }}");
                // }
            });



    // $("#tt").click(function(e){
    //     console.log('hey');
    //     e.preventDefault();
    //     $.post("{{url('/')}}/generateCSV",
    //         {caseID: "{{$caseID}}",
    //         type: "{{$type}}",
    //         searchText:"{{$searchText}}",
    //         startDate:"{{$startDate}}",
    //         endDate:"{{$endDate}}",
    //         filename:"{{$filenameCSV}}" }
    //         // ,
    //         // function(data, status){
    //         //     alert("Data: " + data + "\nStatus: " + status);
    //         // });
    // });
    // </script>