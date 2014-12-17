@extends('layouts.mainResult')
@section('additionalAsset')

<style>
.chat {
    margin: 0;
    padding: 0;
    list-style: none;
}

.chat li {
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #999;
}

.chat li.left .chat-body {
    margin-left: 60px;
}

.chat li.right .chat-body {
    margin-right: 60px;
}

.chat li .chat-body p {
    margin: 0;
}

.panel .slidedown .glyphicon,
.chat .glyphicon {
    margin-right: 5px;
}

.chat-panel .panel-body {
    height: 350px;
    overflow-y: scroll;
}


</style>


<script type="text/javascript">
$(function () {
    $('#device').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title:{
            text: ''
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.percentage:.1f}%'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Application',
            data: [
                ['web',   45.0],
                ['android',       26.8],
                ['iphone',    8.5],
                ['black berry',     6.2],
                ['Others',   0.7]
            ]
        }]
    });
});
$(function () {
    $('#activity').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title:{
            text: ''
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '<b>{point.y:.0f}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.0f}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Posts',
            data: [
                ['Tweets',   272.0],
                ['Retweets',       171.0],
                ['replies',    43.0],
            ]
        }]
    });
});
</script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
@stop
@section('TabContent')
<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
	<ul id="tabMenu" class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#statistics" data-toggle="tab">Statistics</a></li>
		<li><a href="#speedAndLifeCycle" data-toggle="tab">Speed and Life Cycle</a></li>
		<li><a href="#contributor" data-toggle="tab">Contributor</a></li>
		<li><a href="#tweetTimeline" data-toggle="tab">Tweet Timeline</a></li>
	</ul>


<div id="myTabContent" class="tab-content">
   <div class="tab-pane fade in active" id="statistics">
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <div style="text-align: right; font-family:cursive;"><h1>486</h1>posts</div>
                    </div> 
                    <div class="col-lg-3">
                        <div style="text-align: right; font-family:cursive;"><h1>1203</h1>users</div>
                    </div>
                    <div class="col-lg-3">
                        <div style="text-align: right; font-family:cursive;"><h1>32599</h1>impressions</div>
                    </div>
                </div>
                <!-- /.row -->
                <br>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Posts Proportion</h3>
                            </div>
                            <div class="panel-body">
                                <div id="activity" style="height:350px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Application Proportion</h3>
                            </div>
                            <div class="panel-body">
                                <div id="device" style="height:350px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Top Retweeted Posts</h3>
                            </div>
                            <div class="panel-body">
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
                                                    <i class="fa fa-clock-o fa-fw"></i> 4 months ago
                                                </small>
                                            </div>
                                            <p>
                                                กูไม่เคยเห็นการทำ "รัฐประหาร" แบบนี้ในโลกนี้! #นี่กูพูดจริงๆ  <a href="http://t.co/qu0RcBP7IJ" rel="nofollow">http://t.co/qu0RcBP7IJ</a>
                                            </p>
                                            <small class="text-muted">
                                                <i class="fa fa-retweet fa-fw"></i> 10 retweets
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
                                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago
                                                </small>
                                            </div>
                                            <p>
                                                สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
                                            </p>
                                            <small class="text-muted">
                                                <i class="fa fa-retweet fa-fw"></i> 9 retweets
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
                                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago
                                                </small>
                                            </div>
                                            <p>
                                                เค้าไม่ได้รังเกียจไทย

                                                แงงงงงงงงง

                                                เค้าเกลียดการยึดอำนาจ เค้าเกลียดการรัฐประหาร เค้าเกลียดเผด็จการ แงงงงงง
                                            </p>
                                            <small class="text-muted">
                                                <i class="fa fa-retweet fa-fw"></i> 7 retweets
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
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
   </div>
   <div class="tab-pane fade" id="speedAndLifeCycle">
      <p>iOS is a mobile operating system developed and distributed by Apple 
         Inc. Originally released in 2007 for the iPhone, iPod Touch, and 
         Apple TV. iOS is derived from OS X, with which it shares the 
         Darwin foundation. iOS is Apple's mobile version of the 
         OS X operating system used on Apple computers.</p>
   </div>
   <div class="tab-pane fade" id="contributor">
      <p>jMeter is an Open Source testing software. It is 100% pure 
      Java application for load and performance testing.</p>
   </div>
   <div class="tab-pane fade" id="tweetTimeline">
      <p>Enterprise Java Beans (EJB) is a development architecture 
         for building highly scalable and robust enterprise level    
         applications to be deployed on J2EE compliant 
         Application Server such as JBOSS, Web Logic etc.
      </p>
   </div>
</div>



















        @stop