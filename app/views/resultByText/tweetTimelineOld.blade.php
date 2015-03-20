<div id="page-wrapper">
    <div class="container-fluid top-buffer">
		<div class="col-lg-12 col-md-12 col-sm-12">
			
			
            <div class="col-lg-8 col-md-8 col-sm-8">                 
            	<p class="col-lg-3 col-md-3 col-sm-3 onlythaibold" style="font-size:22px;">แสดงผลเรียงตาม </p>               
                <ul id="pillMenu" class="nav nav-pills" style="font-family:thaisansneue; font-size:20px;">
				  	<li class="active"><a href="#time" data-toggle="tab">Timeline</a></li>
				  	<li><a href="#retweet" data-toggle="tab">Total Retweets</a></li>
				  	<li><a href="#follower" data-toggle="tab">Total Follower</a></li>
				</ul>
            </div>


            <div id="myPillContent" class="tab-content top-buffer">
            	<div class="tab-pane fade in active" id="time">
		            <div class="col-lg-12 col-md-12 col-sm-12">
			            <div class="panel panel-green">
			                <div class="panel-heading">
			                    <h3 class="panel-title onlythaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> รายการทวีตเรียงตามเวลา</h3>
			                </div>
			                <div class="panel-body" style="max-height: 500px; overflow-y: scroll;">
			                    <ul class="chat">
			                    	{{-- */$nowdate = NULL;/* --}}
			                		@foreach($timelineList as $key=>$aTweet)
			                			@if($key==0 or $nowdate!==$aTweet->thedate)
			                			{{-- */$nowdate = $aTweet->thedate;/* --}}
			                			<li class="left clearfix">
			                    			<p style="font-family:thaisansneue; color:rgb(50,150,50); font-size:18px;"><i class="glyphicon glyphicon-calendar"></i>{{$aTweet->nameday." ".$aTweet->date." ".$aTweet->month." ".$aTweet->year}}</p>
			                    		</li>
			                    		@endif
			                            <li class="left clearfix">
			                                <span class="chat-img pull-left">
			                                    <a href="http://twitter.com/{{$aTweet->original_screenname}}" target="blank" class="tweet_avatar2">
			                                        <img src="{{$aTweet->original_pic}}" alt="{{$aTweet->original_screenname}}" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
			                                    </a>
			                                </span>
			                                <div class="chat-body clearfix">
			                                    <div class="header">
			                                        <strong class="primary-font"><a href="http://twitter.com/{{$aTweet->original_screenname}}" target="blank" class="tweet_screen_name2 screen_name">{{$aTweet->original_name}}</a></strong> 
			                                        <span style="color:#AAAAAA;">{{"@".$aTweet->original_screenname}}</span>
			                                    </div>
			                                    <p>
			                                        {{$aTweet->original_text}}
			                                    </p>
			                                    <small class="text-muted">
			                                        <span class="glyphicon glyphicon-send"></span> {{$aTweet->original_sourcename}}
			                                        <i class="fa fa-clock-o fa-fw"></i> {{$aTweet->original_created_at}}
			                                    </small>
			                                    @if($aTweet->real_activitytypekey==3)
			                                    <br>
			                                    <small class="text-muted">
			                                    	<i class="fa fa-retweet fa-fw"></i> Retweeted by <a href="http://twitter.com/{{$aTweet->real_screenname}}" target="blank" class="tweet_screen_name2 screen_name" style="color:rgb(100,100,100)">{{$aTweet->real_screenname}}</a>
				                                	<span class="glyphicon glyphicon-send"></span> {{$aTweet->real_sourcename}}
				                                    <i class="fa fa-clock-o fa-fw"></i> {{$aTweet->real_created_at}}                                 
					                            </small>
					                            @endif
			                                </div>
			                            </li>
			                        @endforeach
			                    </ul>
			                    
			                    <!-- /.panel .chat-panel -->			                    
			                </div>
			            </div>
			        </div>
			    </div>




			    <div class="tab-pane fade" id="retweet">
			    	<div class="col-lg-12 col-md-12 col-sm-12">
			            <div class="panel panel-green">
			                <div class="panel-heading">
			                    <h3 class="panel-title onlythaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> รายการทวีตเรียงตามจำนวนรีทวีต</h3>
			                </div>
			                <div class="panel-body" style="max-height: 500px; overflow-y: scroll;">
			                    <ul class="chat">
			                        @foreach($topRetweetedList as $anOriginalTweet)
			                            <li class="left clearfix">
			                                <span class="chat-img pull-left">
			                                    <a href="http://twitter.com/{{$anOriginalTweet->original_screenname}}" target="blank" class="tweet_avatar2">
			                                        <img src="{{$anOriginalTweet->original_pic}}" alt="{{$anOriginalTweet->original_screenname}}" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
			                                    </a>
			                                </span>
			                                <div class="chat-body clearfix">
			                                    <div class="header">
			                                        <strong class="primary-font"><a href="http://twitter.com/{{$anOriginalTweet->original_screenname}}" target="blank" class="tweet_screen_name2 screen_name">{{$anOriginalTweet->original_name}}</a></strong> 
			                                        <span style="color:#AAAAAA;">{{"@".$anOriginalTweet->original_screenname}}</span>
			                                        <small class="pull-right text-muted">
			                                            <i class="fa fa-retweet fa-fw"></i> {{$anOriginalTweet->totalRetweet. " retweets"}}                                      
			                                        </small>
			                                    </div>
			                                    <p>
			                                        {{$anOriginalTweet->original_text}}
			                                    </p>
			                                    <small class="text-muted">
			                                        <span class="glyphicon glyphicon-send"></span> {{$anOriginalTweet->original_sourcename}}
			                                        <i class="fa fa-clock-o fa-fw"></i> {{$anOriginalTweet->original_created_at}}
			                                    </small>
			                                </div>
			                            </li>
			                        @endforeach
			                    </ul>
			                    <!-- /.panel .chat-panel -->			                    
			                </div>
			            </div>
			        </div>
			    </div>

			    
			    <div class="tab-pane fade" id="follower">
			    	<div class="col-lg-12 col-md-12 col-sm-12">
			            <div class="panel panel-green">
			                <div class="panel-heading">
			                    <h3 class="panel-title onlythaibold" style="font-size:20px;">
			                    	<i class="fa fa-long-arrow-right"></i> 
			                    	รายการทวีตเรียงตามจำนวนผู้ติดตาม
									<span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="ในกรณีของรีทวีต จำนวน Follower ที่ใช้เรียงจะเป็นของผู้รีทวีต"></span>
			                    </h3>
			                </div>
			                <div class="panel-body" style="max-height: 500px; overflow-y: scroll;">
			                    <ul class="chat">
			                        @foreach($topFollowerList as $aTweet)
			                            <li class="left clearfix">
			                                <span class="chat-img pull-left">
			                                    <a href="http://twitter.com/{{$aTweet->original_screenname}}" target="blank" class="tweet_avatar2">
			                                        <img src="{{$aTweet->original_pic}}" alt="{{$aTweet->original_screenname}}" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
			                                    </a>
			                                </span>
			                                <div class="chat-body clearfix">
			                                    <div class="header">
			                                        <strong class="primary-font"><a href="http://twitter.com/{{$aTweet->original_screenname}}" target="blank" class="tweet_screen_name2 screen_name">{{$aTweet->original_name}}</a></strong> 
			                                        <span style="color:#AAAAAA;">{{"@".$aTweet->original_screenname}}</span>
			                                        <small class="pull-right text-muted">
			                                        	<i class="fa fa-users fa-fw"></i> {{$aTweet->real_no_of_follower. " followers"}}  
			                                        </small>
			                                    </div>
			                                    <p>
			                                        {{$aTweet->original_text}}
			                                    </p>
			                                    <small class="text-muted">
			                                        <span class="glyphicon glyphicon-send"></span> {{$aTweet->original_sourcename}}
			                                        <i class="fa fa-clock-o fa-fw"></i> {{$aTweet->original_created_at}}
			                                    </small>
			                                    @if($aTweet->real_activitytypekey==3)
			                                    <br>
			                                    <small class="text-muted">
			                                    	<i class="fa fa-retweet fa-fw"></i> Retweeted by <a href="http://twitter.com/{{$aTweet->real_screenname}}" target="blank" class="tweet_screen_name2 screen_name" style="color:rgb(100,100,100)">{{$aTweet->real_screenname}}</a>
				                                	<span class="glyphicon glyphicon-send"></span> {{$aTweet->real_sourcename}}
				                                    <i class="fa fa-clock-o fa-fw"></i> {{$aTweet->real_created_at}}                                 
					                            </small>
					                            @endif
			                                </div>
			                            </li>
			                        @endforeach			                        
			                    </ul>
			                    <!-- /.panel .chat-panel -->			                    
			                </div>
			            </div>
			        </div>
			    </div>
		    </div>
			<!--<a class="twitter-timeline"  
			width="600"
			height="400"
			href="https://twitter.com/search?q=%E0%B8%A3%E0%B8%B1%E0%B8%90%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B8%AB%E0%B8%B2%E0%B8%A3" 
			data-widget-id="521198386687401984">
			ทวีตเกี่ยวกับ "รัฐประหาร"</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>-->
		</div>
	</div>
</div>
