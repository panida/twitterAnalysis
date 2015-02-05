@extends('layouts.default')
@section('customCSS')
    <!-- Custom CSS -->
    {{ HTML::style('css/jquery-ui.css'); }}
    {{ HTML::script('js/jquery-ui-1.10.4.min.js'); }}
    {{ HTML::style('css/jquery.asmselect.css'); }}
    {{ HTML::script('js/jquery.asmselect.js'); }}
    <script type="text/javascript">
        $(document).ready(function() {
            $("select[multiple]").asmSelect({
                addItemTarget: 'bottom',
                animate: true,
                highlight: true,
                removeLabel: 'ยกเลิก'
                // sortable: true
            });     

            $("select[multiple]").change(function(e, data) {
                // if it's a sort or an add, then give it a little color animation to highlight it
                if(data.type != 'drop') data.item.animate({ 'backgroundColor': '#ffffcc' }, 20, 'linear', function() {
                    data.item.animate({ 'backgroundColor': '#dddddd' }, 500); 
                }); 
            });        
        }); 

    </script>

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
                        <li>
                            <form action="#" method="post">
                                <label for="interestingGroup">กลุ่มตัวอย่างผู้ใช้ทวิตเตอร์ที่สนใจ : </label>
                                <select id="interestingGroup" multiple="multiple" name="interestingGroup[]" size="4" title="-----เพิ่มกลุ่มตัวอย่าง-----">
                                    <option selected="selected">หน่วยราชการ</option>      
                                    <option selected="selected">นักการเมือง</option>
                                    <option selected="selected">คนดัง</option>
                                    <option selected="selected">เสื้อแดง</option>
                                    <option selected="selected">เสื้อเหลือง/ฟ้า/หลากสี</option>
                                    <option selected="selected">สำนักข่าว</option>
                                    <option selected="selected">นักข่าว</option>
                                    <option>test</option>                                                
                                </select>
                                <p><input type="submit" name="save" value="บันทึกการแก้ไข" /></p>
                            </form>
                        </li>
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