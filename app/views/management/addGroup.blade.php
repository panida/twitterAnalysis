@extends('management.groupManagement')
@section('addEditGroup')
	<br>
    <h2 class="panel-title onlythaibold" style="font-size:25px;"><i class="fa fa-plus-circle fa-fw" style="color:green;"></i> เพิ่มกลุ่มตัวอย่างใหม่</h2>
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
    {{Form::open(array('url' => '/groupManagement','method'=>'post','class' => 'form-horizontal','accept-charset'=>'UTF-8'))}}
    <div class="form-group">

        <label for="name" class="col-sm-3 control-label">ชื่อกลุ่ม <span class="required">*</span></label>
        <div class="col-sm-5">
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'ชื่อกลุ่ม', 'required' => 'required']) }}
            <label class="control-label" style="color:darkred; font-size:12px;">&nbsp; หมายเหตุ: ชื่อกลุ่มต้องไม่ซ้ำกับกลุ่มอื่นๆที่มีอยู่ก่อนหน้า</label>
        </div>     
        
        <!-- <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" data-toggle="tooltip" title="ชื่อกลุ่มต้องไม่ซ้ำกับกลุ่มอื่นๆที่มีอยู่ก่อนหน้า"></span>                -->
    </div><!--form-group-->
    <div class="form-group">
        <label for="description" class="col-sm-3 control-label">รายละเอียดของกลุ่ม </label>
        <div class="col-sm-8">
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'รายละเอียดของกลุ่ม', 'cols' => '30', 'rows' => '3']) }}
        </div>
    </div><!--form-group-->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-8">
            {{ Form::submit('บันทึก', array('class'=>'btn btn-success'))}}
        </div>
    </div>

    <br>
    <h2 class="panel-title onlythaibold" style="font-size:25px;"><i class="fa fa-fw fa-user" style="color:#FF0000;"></i> รายการสมาชิกที่ยังประมวลผลไม่เสร็จสิ้น: {{$notFinishedMembers->count()}} คน</h2>
    <br>
    @if($notFinishedMembers->count()!=0)
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-primary">
            
            <div class="panel-body" style="max-height: 500px; overflow-y: scroll;">
                <ul class="chat">    
                    @foreach($notFinishedMembers as $member)                
                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <a href= "{{$member->user->user_timeline_url}}" target="blank" class="tweet_avatar2">
                                <img src="{{$member->user->profile_pic_url}}" alt="ipd69" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
                            </a>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font"><a href="{{$member->user_timeline_url}}" target="blank" class="tweet_screen_name2 screen_name">{{$member->user->name}}</a></strong> 
                                <span style="color:#AAAAAA;">{{'@'.$member->user->screenname}}</span>                                
                            </div>
                            <p>
                                {{$member->user->description}}
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
    @else
    <div class="col-lg-11 col-md-11 col-sm-11 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
        <h5>ไม่มีสมาชิกที่อยู่ระหว่างประมวลผล</h5>
    </div>
    @endif

@stop