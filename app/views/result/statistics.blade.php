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
@stop
@section('TabContent')
<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
	<ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="{{URL::to('result/statistics')}}">Statistics</a></li>
		<li><a href="{{URL::to('result/speedAndLifeCycle')}}">Speed and Life Cycle</a></li>
		<li><a href="{{URL::to('result/contributor')}}">Contributor</a></li>
		<li><a href="{{URL::to('result/tweetTimeline')}}">Tweet Timeline</a></li>
		<li><a href="{{URL::to('result/device')}}">Device</a></li>
	</ul>

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
                <div class="col-lg-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Posts Proportion</h3>
                        </div>
                        <div class="panel-body">
                            <canvas width="300" height="300" ></canvas>
						    <script>
						      var canvas        = $( 'canvas' )
						        , lowestValue   = 0.0000367     // Minimum supported value
						        , emptySection  = {
						              value     : lowestValue
						            , color     : '#e8e8e8'
						            , highlight : '#e8e8e8'
						            , label     : ''
						          }
						        , data = [
						              {
						                  value     : 272
						                , color     : '#F7464A'
						                , highlight : '#FF5A5E'
						                , label     : 'Tweet'
						              }
						            , {
						                  value     : 171
						                , color     : '#15D42F'
						                , highlight : '#39D44D'
						                , label     : 'Retweet'
						                }
						            , {
						                  value     : 43
						                , color     : '#FAEC23'
						                , highlight : '#FAEC60'
						                , label     : 'Reply'
						              }
						          ]
						        , options = {
						              'percentageInnerCutout': 50
						            , 'showTooltips'         : true
						            , 'animateScale'         : true
						            
						          }
						        , chart   = {};

						        // Get the segments that have bigger value than the minimum supported.
						        data = data.filter( function( el ) {
						          return el.value > lowestValue;
						        });

						        // If there are no valid segments, inlude two new ones an set the value of one of them to 1
						        // so that the chart appears.
						        if ( data.length === 0 ) {
						          data.push( $.extend( true, {}, emptySection ) );
						          data.push( $.extend( true, {}, emptySection ) );

						          data[ 0 ].value = 1;

						        // If there's only one segment, we need to validate is it's value is bigger that the minimum supported.
						        // If not, then set it's value to 1 so the chart appears and include a new segment to prevent the bug.
						        } else if ( data.length === 1 ) {
						          if ( data[ 0 ].value < lowestValue ) {
						            data[ 0 ].value = 1;
						          }

						          data.push( emptySection );
						        }

						        // Create the chart.
						        chart = new Chart( canvas.get( 0 ).getContext( '2d' ) ).Doughnut( data, options );

						    </script>
                            <div class="text-right">
                                <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
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
                                                <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago</small>
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
                                                <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago</small>
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
@stop