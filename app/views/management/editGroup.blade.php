@extends('management.groupManagement')
@section('addEditGroup')
	<br>
    <h2 class="panel-title onlythaibold" style="font-size:25px;"><i class="fa fa-fw fa-folder-open" style="color:#EBE241;"></i> แก้ไขกลุ่มตัวอย่าง</h2>
    <br>
    @if (Session::get('error'))
        <div class="alert alert-danger">
        @if (is_array(Session::get('error')))
            {{ head(Session::get('error')) }}
        @else
            {{{ Session::get('error') }}}
        @endif
        </div>
    @endif
    @if (Session::get('notice'))
        <div class="alert alert-success">{{ Session::get('notice') }}</div>
    @endif
    {{Form::open(array('url' => '/group/'.$groupDetail->groupid,'method'=>'post','class' => 'form-horizontal','accept-charset'=>'UTF-8'))}}    
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">ชื่อกลุ่ม <span class="required">*</span></label>
            <div class="col-sm-5">
                {{ Form::text('name', $groupDetail->groupname, ['class' => 'form-control', 'placeholder' => 'ชื่อกลุ่ม', 'required' => 'required']) }}
                <label class="control-label" style="color:darkred; font-size:12px;">&nbsp; หมายเหตุ: ชื่อกลุ่มต้องไม่ซ้ำกับกลุ่มอื่นๆที่มีอยู่ก่อนหน้า</label>
            </div>     
            
            <!-- <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" data-toggle="tooltip" title="ชื่อกลุ่มต้องไม่ซ้ำกับกลุ่มอื่นๆที่มีอยู่ก่อนหน้า"></span>                -->
        </div><!--form-group-->
        <div class="form-group">
            <label for="description" class="col-sm-3 control-label">รายละเอียดของกลุ่ม </label>
            <div class="col-sm-8">
                {{ Form::textarea('description', $groupDetail->description, ['class' => 'form-control', 'placeholder' => 'รายละเอียดของกลุ่ม', 'cols' => '30', 'rows' => '3']) }}
            </div>
        </div><!--form-group-->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-8">
                {{ Form::submit('บันทึกการแก้ไข', array('class'=>'btn btn-primary'))}}
                &nbsp;
                <a href="{{{ URL::to('deleteGroup/'.$groupDetail->groupid) }}}"><button type="button" class="btn btn-danger" onclick="confirmDeleteGroup()">ลบกลุ่มตัวอย่างนี้</button></a>
            </div>
        </div>
    </form>

    <br>
    <h2 class="panel-title onlythaibold" style="font-size:25px;"><i class="fa fa-fw fa-user" style="color:#4171EB;"></i> จัดการสมาชิกในกลุ่ม - จำนวนสมาชิกปัจจุบัน: {{$members->count()}} คน</h2>
    <br>
    {{Form::open(array('url' => '/group/addMember/'.$groupDetail->groupid,'method'=>'post','class' => 'form-horizontal','accept-charset'=>'UTF-8'))}}    
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">เพิ่มสมาชิก</label>
            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    {{ Form::text('screen_name', null, ['class' => 'form-control', 'placeholder' => 'screen name', 'required' => 'required']) }}       
                </div>
            </div>        
            <div class="col-sm-3">
                {{ Form::submit('เพิ่ม', array('class'=>'btn btn-primary'))}}
            </div>
        </div><!--form-group-->
    </form>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title thaibold" style="font-size:20px;">
                    <i class="fa fa-long-arrow-right"></i> 
                    สมาชิกในกลุ่ม{{$groupDetail->groupname}}ทั้งหมด
<!--                     <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="ในกรณีของรีทวีต จำนวน Follower ที่ใช้เรียงจะเป็นของผู้รีทวีต"></span> -->
                </h3>
            </div>
            <div class="panel-body" style="max-height: 500px; overflow-y: scroll;">
                <ul class="chat">    
                    @foreach($members as $member)                
                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <a href= "{{$member->user_timeline_url}}" target="blank" class="tweet_avatar2">
                                <img src="{{$member->profile_pic_url}}" alt="ipd69" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
                            </a>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font"><a href="{{$member->user_timeline_url}}" target="blank" class="tweet_screen_name2 screen_name">{{$member->name}}</a></strong> 
                                <span style="color:#AAAAAA;">{{'@'.$member->screenname}}</span>    
                                <span class="chat-img pull-right">                                    
                                    <a href="{{{ URL::to('deleteMember/'.$groupDetail->groupid.'/'.$member->userkey) }}}"><button type="button" class="btn btn-danger" onclick="confirmDelete()">ลบออกจากกลุ่ม</button></a>
                                </span>                            
                            </div>
                            <p>
                                {{$member->description}}
                            </p>
                            <!-- <small class="text-muted">
                                <i class="fa fa-comment fa-fw"></i> 472 tweets
                                <i class="fa fa-user fa-fw"></i> 62 followers
                                <i class="fa fa-user fa-fw"></i> 113 following
                            </small> -->
                        </div>
                    </li> 
                    @endforeach                            
                </ul>
                <!-- /.panel .chat-panel -->                                
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            var r = confirm("คุณมั่นใจหรือไม่ที่จะลบสมาชิกคนนี้ออกจากกลุ่ม");
            if (r == true) {
                window.location.href = 'http://www.thaicreate.com';
            } else {
                window.location.href = '#';
            }
        }

        function confirmDeleteGroup() {
            var r = confirm("หากลบกลุ่มตัวอย่างนี้แล้วจะไม่สามารถเรียกคือนข้อมูลใดๆเกี่ยวกับกลุ่มตัวอย่างนี้ได้ คุณมั่นใจที่จะลบกลุ่มตัวอย่างวิจัยนี้ใช่หรือไม่");
            if (r == true) {
                window.location.href = "{{{ URL::to('deletegroup') }}}";
            } else {
                window.location.href = '#';
            }
        }
    </script>


@stop
