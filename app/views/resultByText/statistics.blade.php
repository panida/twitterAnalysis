<div id="page-wrapper">
    <div class="container-fluid top-buffer">
        <div class="row thaibold">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <h3>จำนวนทวีตทั้งหมด &nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="จำนวนทวีตในกรณีศึกษาทั้งหมดที่มีคำค้นหาอยู่"></span>
                    </h3>
                    <div class="col-lg-6 col-md-6 col-sm-6"><span class="glyphicon glyphicon-comment" style="font-size:80px;" aria-hidden="true"></span></div>
                    <div class="col-lg-6 col-md-6 col-sm-6"><h2>{{number_format($countAllTweet)}}</h2><h3>ทวีต</h3></div>
                </div> 
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <h3>จำนวนผู้ใช้ทั้งหมด &nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="จำนวนผู้มีส่วนร่วมเผยแพร่ทวีตทั้งหมด"></span>
                    </h3>                    
                    <div class="col-lg-6 col-md-6 col-sm-6"><span class="glyphicon glyphicon-user" style="font-size:80px;" aria-hidden="true"></span></div>
                    <div class="col-lg-6 col-md-6 col-sm-6"><h2>{{number_format($countAllContributor)}}</h2><h3>คน</h3></div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <h3>จำนวนครั้งการเข้าถึง &nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="จำนวนผู้ติดตามรวมของทุกทวีตที่ค้นหาได้"></span>
                    </h3>
                    <div class="col-lg-6 col-md-6 col-sm-6"><span class="glyphicon glyphicon-eye-open" style="font-size:80px;" aria-hidden="true"></span></div>
                    <div class="col-lg-6 col-md-6 col-sm-6"><h2>{{number_format($countAllImpression)}}</h2><h3>ครั้ง</h3></div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <br>

        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h3 class="panel-title onlythaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> สัดส่วนประเภทของทวีต</h3>
                </div>
                <div class="panel-body">
                    <div id="activity" style="height:350px"></div>
                </div>
            </div>
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h3 class="panel-title onlythaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> สัดส่วนแอพพลิเคชั่นที่ใช้</h3>
                </div>
                <div class="panel-body">
                    <div id="device" style="height:350px"></div>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h3 class="panel-title onlythaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> 10 ทวีตที่ถูกรีทวีตสูงสุดในช่วงเวลาที่ค้นหา</h3>
                </div>
                <div class="panel-body" style="min-height: 825px; max-height: 825px; overflow-y: scroll;">
                    <ul class="chat">
                        @foreach($top10RetweetedList as $anOriginalTweet)
                            <li class="left clearfix">
                                <span class="chat-img pull-left">
                                    <a href="http://twitter.com/{{$anOriginalTweet['user']->screenname}}" target="blank" class="tweet_avatar2">
                                        <img src="{{$anOriginalTweet['user']->profile_pic_url}}" alt="{{$anOriginalTweet['user']->screenname}}" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
                                    </a>
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font"><a href="http://twitter.com/{{$anOriginalTweet['user']->screenname}}" target="blank" class="tweet_screen_name2 screen_name">{{$anOriginalTweet['user']->name}}</a></strong> 
                                        <span style="color:#AAAAAA;">{{"@".$anOriginalTweet['user']->screenname}}</span>
                                        <small class="pull-right text-muted">
                                            <i class="fa fa-retweet fa-fw"></i> {{$anOriginalTweet['retweetCount']. " retweets"}}                                      
                                        </small>
                                    </div>
                                    <p>
                                        {{$anOriginalTweet['text']}}
                                    </p>
                                    <small class="text-muted">
                                        <span class="glyphicon glyphicon-send"></span> {{$anOriginalTweet['source']}}
                                        <i class="fa fa-clock-o fa-fw"></i> {{$anOriginalTweet['detail']->created_at}}
                                    </small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->


<!-- <li class="left clearfix">
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
</li>        -->