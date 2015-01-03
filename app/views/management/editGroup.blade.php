@extends('management.groupManagement')
@section('addEditGroup')
	<br>
    <h2 class="panel-title onlythaibold" style="font-size:25px;"><i class="fa fa-fw fa-folder-open" style="color:#EBE241;"></i> แก้ไขกลุ่มตัวอย่าง</h2>
    <br>
    <form class="form-horizontal" role="form" method="POST" action="{{{ URL::to('editgroup') }}}" accept-charset="UTF-8">
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">ชื่อกลุ่ม <span class="required">*</span></label>
            <div class="col-sm-5">
                {{ Form::text('name', 'คนดัง', ['class' => 'form-control', 'placeholder' => 'คนดัง', 'required' => 'required']) }}
                <label class="control-label" style="color:darkred; font-size:12px;">&nbsp; หมายเหตุ: ชื่อกลุ่มต้องไม่ซ้ำกับกลุ่มอื่นๆที่มีอยู่ก่อนหน้า</label>
            </div>     
            
            <!-- <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" data-toggle="tooltip" title="ชื่อกลุ่มต้องไม่ซ้ำกับกลุ่มอื่นๆที่มีอยู่ก่อนหน้า"></span>                -->
        </div><!--form-group-->
        <div class="form-group">
            <label for="description" class="col-sm-3 control-label">รายละเอียดของกลุ่ม </label>
            <div class="col-sm-8">
                {{ Form::textarea('description', 'นักคิด นักวิชาการ ดารา', ['class' => 'form-control', 'placeholder' => 'รายละเอียดของกลุ่ม', 'cols' => '30', 'rows' => '3']) }}
            </div>
        </div><!--form-group-->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-8">
                <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                &nbsp;
                <button type="button" class="btn btn-danger" onclick="confirmDeleteGroup()">ลบกลุ่มตัวอย่างนี้</button>
            </div>
        </div>
    </form>

    <br>
    <h2 class="panel-title onlythaibold" style="font-size:25px;"><i class="fa fa-fw fa-user" style="color:#4171EB;"></i> จัดการสมาชิกในกลุ่ม - จำนวนสมาชิกปัจจุบัน: 5 คน</h2>
    <br>
    <form class="form-horizontal" role="form" method="POST" action="{{{ URL::to('addmember') }}}" accept-charset="UTF-8">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">เพิ่มสมาชิก</label>
            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    {{ Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'username', 'required' => 'required']) }}       
                </div>
            </div>        
            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary">เพิ่ม</button>
            </div>
        </div><!--form-group-->
    </form>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title thaibold" style="font-size:20px;">
                    <i class="fa fa-long-arrow-right"></i> 
                    สมาชิกในกลุ่มคนดังทั้งหมด
<!--                     <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="ในกรณีของรีทวีต จำนวน Follower ที่ใช้เรียงจะเป็นของผู้รีทวีต"></span> -->
                </h3>
            </div>
            <div class="panel-body" style="max-height: 500px; overflow-y: scroll;">
                <ul class="chat">                    
                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <a href="http://twitter.com/Keztii_PinkyRox" target="blank" class="tweet_avatar2">
                                <img src="http://pbs.twimg.com/profile_images/378800000107726833/41e20a29a69daca86ee99c62675b5ef2_normal.jpeg" alt="ipd69" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
                            </a>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font"><a href="http://twitter.com/Keztii_PinkyRox" target="blank" class="tweet_screen_name2 screen_name">♡ K-A-T-E ♡</a></strong> 
                                <span style="color:#AAAAAA;">@Keztii_PinkyRox</span>    
                                <span class="chat-img pull-right">                                    
                                    <a href="{{{ URL::to('deleteMember') }}}"><button type="button" class="btn btn-danger" onclick="confirmDelete()">ลบออกจากกลุ่ม</button></a>
                                </span>                            
                            </div>
                            <p>
                                Faculty of Law ABAC ,, My bro: @WayoTS6 @Icemamkak My sis: @bell_belt I ♥ #TheStar6 @MrSingtoTheStar @Obojama @s8shane Harry Potter
                            </p>
                            <small class="text-muted">
                                <i class="fa fa-comment fa-fw"></i> 472 tweets
                                <i class="fa fa-user fa-fw"></i> 62 followers
                                <i class="fa fa-user fa-fw"></i> 113 following
                            </small>
                        </div>
                    </li>  

                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <a href="http://twitter.com/zeza136" target="blank" class="tweet_avatar2">
                                <img src="http://pbs.twimg.com/profile_images/505583292586803200/YntDUqus_normal.jpeg" alt="ipd69" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
                            </a>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font"><a href="http://twitter.com/zeza136" target="blank" class="tweet_screen_name2 screen_name">.</a></strong> 
                                <span style="color:#AAAAAA;">@zeza136</span>    
                                <span class="chat-img pull-right">                                    
                                    <a href="{{{ URL::to('deleteMember') }}}"><button type="button" class="btn btn-danger" onclick="confirmDelete()">ลบออกจากกลุ่ม</button></a>
                                </span>                            
                            </div>
                            <p>
                                Thailand Demo-cracy ไม่เชื่อในคนดี คนดีอย่ากลัวการถูกตรวจสอบ
                            </p>
                            <small class="text-muted">
                                <i class="fa fa-comment fa-fw"></i> 472 tweets
                                <i class="fa fa-user fa-fw"></i> 62 followers
                                <i class="fa fa-user fa-fw"></i> 113 following
                            </small>
                        </div>
                    </li> 

                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <a href="http://twitter.com/iiploii" target="blank" class="tweet_avatar2">
                                <img src="http://pbs.twimg.com/profile_images/539117249580109824/EfTOYDfN_normal.jpeg" alt="ipd69" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
                            </a>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font"><a href="http://twitter.com/iiploii" target="blank" class="tweet_screen_name2 screen_name">฿ถุงน่องหิวเงิน฿</a></strong> 
                                <span style="color:#AAAAAA;">@iiploii</span>    
                                <span class="chat-img pull-right">                                    
                                    <a href="{{{ URL::to('deleteMember') }}}"><button type="button" class="btn btn-danger" onclick="confirmDelete()">ลบออกจากกลุ่ม</button></a>
                                </span>                            
                            </div>
                            <p>
                                อยากได้ทุนไปเรียนเมืองนอก แต่โง่ / Lier, lier, pants on fire  / soy estudiante de español / รับแปลงาน TH-ENG นะ / I'm #ThoMinho
                            </p>
                            <small class="text-muted">
                                <i class="fa fa-comment fa-fw"></i> 472 tweets
                                <i class="fa fa-user fa-fw"></i> 62 followers
                                <i class="fa fa-user fa-fw"></i> 113 following
                            </small>
                        </div>
                    </li> 

                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <a href="http://twitter.com/paint_PMP" target="blank" class="tweet_avatar2">
                                <img src="http://pbs.twimg.com/profile_images/528120071164416001/ocdVT9pB_normal.jpeg" alt="ipd69" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
                            </a>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font"><a href="http://twitter.com/paint_PMP" target="blank" class="tweet_screen_name2 screen_name">Paintttt.</a></strong> 
                                <span style="color:#AAAAAA;">@paint_PMP</span>    
                                <span class="chat-img pull-right">                                    
                                    <a href="{{{ URL::to('deleteMember') }}}"><button type="button" class="btn btn-danger" onclick="confirmDelete()">ลบออกจากกลุ่ม</button></a>
                                </span>                            
                            </div>
                            <p>
                                
                            </p>
                            <small class="text-muted">
                                <i class="fa fa-comment fa-fw"></i> 472 tweets
                                <i class="fa fa-user fa-fw"></i> 62 followers
                                <i class="fa fa-user fa-fw"></i> 113 following
                            </small>
                        </div>
                    </li> 

                    <li class="left clearfix">
                        <span class="chat-img pull-left">
                            <a href="http://twitter.com/chatchamon" target="blank" class="tweet_avatar2">
                                <img src="http://pbs.twimg.com/profile_images/482577002927366144/xUB3iuIF_normal.jpeg" alt="ipd69" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
                            </a>
                        </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font"><a href="http://twitter.com/chatchamon" target="blank" class="tweet_screen_name2 screen_name">Chatchamon Writer</a></strong> 
                                <span style="color:#AAAAAA;">@chatchamon</span>    
                                <span class="chat-img pull-right">                                    
                                    <a href="{{{ URL::to('deleteMember') }}}"><button type="button" class="btn btn-danger" onclick="confirmDelete()">ลบออกจากกลุ่ม</button></a>
                                </span>                            
                            </div>
                            <p>
                                ชัชชมนต์ นักเขียนแจ่มใสค่ะ
                            </p>
                            <small class="text-muted">
                                <i class="fa fa-comment fa-fw"></i> 472 tweets
                                <i class="fa fa-user fa-fw"></i> 62 followers
                                <i class="fa fa-user fa-fw"></i> 113 following
                            </small>
                        </div>
                    </li>                             
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
