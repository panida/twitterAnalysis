<div id="page-wrapper">
    <div class="container-fluid top-buffer">
        <div class="row thaibold">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3>จำนวนทวีตทั้งหมด</h3>
                    <div class="col-lg-6"><span class="glyphicon glyphicon-comment" style="font-size:80px;" aria-hidden="true"></span></div>
                    <div class="col-lg-6"><h2>{{$countAllTweet}}</h2><h3>ทวีต</h3></div>
                </div> 
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3>จำนวนผู้ใช้ทั้งหมด</h3>
                    <div class="col-lg-6"><span class="glyphicon glyphicon-user" style="font-size:80px;" aria-hidden="true"></span></div>
                    <div class="col-lg-6"><h2>{{$countAllContributor}}</h2><h3>คน</h3></div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3>จำนวนครั้งการเข้าถึง</h3>
                    <div class="col-lg-6"><span class="glyphicon glyphicon-eye-open" style="font-size:80px;" aria-hidden="true"></span></div>
                    <div class="col-lg-6"><h2>32,599</h2><h3>ครั้ง</h3></div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <br>

        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h3 class="panel-title thaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> สัดส่วนประเภทของทวีต</h3>
                </div>
                <div class="panel-body">
                    <div id="activity" style="height:350px"></div>
                </div>
            </div>
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h3 class="panel-title thaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> สัดส่วนแอพพลิเคชั่นที่ใช้</h3>
                </div>
                <div class="panel-body">
                    <div id="device" style="height:350px">
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h3 class="panel-title thaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> 10 ทวีตที่ถูกรีทวีตสูงสุด</h3>
                </div>
                <div class="panel-body" style="min-height: 825px; max-height: 825px; overflow-y: scroll;">
                    <ul class="chat">
                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <a href="http://twitter.com/ipd69" class="tweet_avatar2">
                                    <img src="http://pbs.twimg.com/profile_images/521337632169553921/A8IMmV6E_normal.jpeg" alt="ipd69" class="avatar">
                                </a>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><a href="http://twitter.com/ipd69" class="tweet_screen_name2 screen_name">พี่ดี้ลำเอียง</a></strong> 
                                    <span style="color:#AAAAAA;">@ipd69</span>
                                    <small class="pull-right text-muted">
                                        <i class="fa fa-retweet fa-fw"></i> 10 retweets                                        
                                    </small>
                                </div>
                                <p>
                                    กูไม่เคยเห็นการทำ "รัฐประหาร" แบบนี้ในโลกนี้! #นี่กูพูดจริงๆ  <a href="http://t.co/qu0RcBP7IJ" rel="nofollow">http://t.co/qu0RcBP7IJ</a>
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> 4 months ago
                                </small>
                            </div>
                        </li>
                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <a href="http://twitter.com/Khunpone" class="tweet_avatar2">
                                    <img src="http://pbs.twimg.com/profile_images/948274723/as015069_normal.jpg" alt="Khunpone" class="avatar">
                                </a>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><a href="http://twitter.com/Khunpone" class="tweet_screen_name2 screen_name">Teerapong Ponesiri</a></strong>
                                    <span style="color:#AAAAAA;">@Khunpone</span>
                                    <small class="pull-right text-muted">
                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
                                    </small>
                                </div>
                                <p>
                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
                                </small>
                            </div>
                        </li>

                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <a href="http://twitter.com/iiDudes" class="tweet_avatar2">
                                    <img src="http://pbs.twimg.com/profile_images/470578977975709696/mW4CDI7S_normal.jpeg" alt="iiDudes" class="avatar">
                                </a>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"> <a href="http://twitter.com/iiDudes" class="tweet_screen_name2 screen_name">นป.นักดมกาวในตำนาน</a></strong>
                                    <span style="color:#AAAAAA;">@iiDudes</span>
                                    <small class="pull-right text-muted">
                                        <i class="fa fa-retweet fa-fw"></i> 7 retweets
                                    </small>
                                </div>
                                <p>
                                    เค้าไม่ได้รังเกียจไทย

                                    แงงงงงงงงง

                                    เค้าเกลียดการยึดอำนาจ เค้าเกลียดการรัฐประหาร เค้าเกลียดเผด็จการ แงงงงงง
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
                                </small>
                            </div>
                        </li>

                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <a href="http://twitter.com/Khunpone" class="tweet_avatar2">
                                    <img src="http://pbs.twimg.com/profile_images/948274723/as015069_normal.jpg" alt="Khunpone" class="avatar">
                                </a>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><a href="http://twitter.com/Khunpone" class="tweet_screen_name2 screen_name">Teerapong Ponesiri</a></strong>
                                    <span style="color:#AAAAAA;">@Khunpone</span>
                                    <small class="pull-right text-muted">
                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
                                    </small>
                                </div>
                                <p>
                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
                                </small>
                            </div>
                        </li>

                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <a href="http://twitter.com/Khunpone" class="tweet_avatar2">
                                    <img src="http://pbs.twimg.com/profile_images/948274723/as015069_normal.jpg" alt="Khunpone" class="avatar">
                                </a>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><a href="http://twitter.com/Khunpone" class="tweet_screen_name2 screen_name">Teerapong Ponesiri</a></strong>
                                    <span style="color:#AAAAAA;">@Khunpone</span>
                                    <small class="pull-right text-muted">
                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
                                    </small>
                                </div>
                                <p>
                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
                                </small>
                            </div>
                        </li>

                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <a href="http://twitter.com/Khunpone" class="tweet_avatar2">
                                    <img src="http://pbs.twimg.com/profile_images/948274723/as015069_normal.jpg" alt="Khunpone" class="avatar">
                                </a>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><a href="http://twitter.com/Khunpone" class="tweet_screen_name2 screen_name">Teerapong Ponesiri</a></strong>
                                    <span style="color:#AAAAAA;">@Khunpone</span>
                                    <small class="pull-right text-muted">
                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
                                    </small>
                                </div>
                                <p>
                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
                                </small>
                            </div>
                        </li>

                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <a href="http://twitter.com/Khunpone" class="tweet_avatar2">
                                    <img src="http://pbs.twimg.com/profile_images/948274723/as015069_normal.jpg" alt="Khunpone" class="avatar">
                                </a>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><a href="http://twitter.com/Khunpone" class="tweet_screen_name2 screen_name">Teerapong Ponesiri</a></strong>
                                    <span style="color:#AAAAAA;">@Khunpone</span>
                                    <small class="pull-right text-muted">
                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
                                    </small>
                                </div>
                                <p>
                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
                                </small>
                            </div>
                        </li>

                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <a href="http://twitter.com/Khunpone" class="tweet_avatar2">
                                    <img src="http://pbs.twimg.com/profile_images/948274723/as015069_normal.jpg" alt="Khunpone" class="avatar">
                                </a>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><a href="http://twitter.com/Khunpone" class="tweet_screen_name2 screen_name">Teerapong Ponesiri</a></strong>
                                    <span style="color:#AAAAAA;">@Khunpone</span>
                                    <small class="pull-right text-muted">
                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
                                    </small>
                                </div>
                                <p>
                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
                                </small>
                            </div>
                        </li>

                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <a href="http://twitter.com/Khunpone" class="tweet_avatar2">
                                    <img src="http://pbs.twimg.com/profile_images/948274723/as015069_normal.jpg" alt="Khunpone" class="avatar">
                                </a>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><a href="http://twitter.com/Khunpone" class="tweet_screen_name2 screen_name">Teerapong Ponesiri</a></strong>
                                    <span style="color:#AAAAAA;">@Khunpone</span>
                                    <small class="pull-right text-muted">
                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
                                    </small>
                                </div>
                                <p>
                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
                                </small>
                            </div>
                        </li>

                        <li class="left clearfix">
                            <span class="chat-img pull-left">
                                <a href="http://twitter.com/Khunpone" class="tweet_avatar2">
                                    <img src="http://pbs.twimg.com/profile_images/948274723/as015069_normal.jpg" alt="Khunpone" class="avatar">
                                </a>
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><a href="http://twitter.com/Khunpone" class="tweet_screen_name2 screen_name">Teerapong Ponesiri</a></strong>
                                    <span style="color:#AAAAAA;">@Khunpone</span>
                                    <small class="pull-right text-muted">
                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
                                    </small>
                                </div>
                                <p>
                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
                                </small>
                            </div>
                        </li>
                    </ul>
                    <!-- /.panel .chat-panel -->
                    <div class="text-right">
                        <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
