<div id="page-wrapper">
	<div class="container-fluid top-buffer">
		<div class="col-lg-12">
			<div class="panel panel-green">
				<div class="panel-heading">
					<h3 class="panel-title onlythaibold" style="font-size:20px;">
						<i class="fa fa-long-arrow-right"></i> 
						กราฟแสดงจำนวนทวีตแบ่งตามกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์&nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="กราฟแท่งแสดงจำนวนทวีตประเภทต่างๆและจำนวนครั้งการถูกรีทวีตของแต่ละกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์"></span>
                    </h3>
				</div>
				<div class="panel-body">
					<div id="container1" style="width:auto; height: 450px; margin: 0 auto"></div>			
				</div>
			</div>			
			<script>
				$(function () {
				    $('#container1').highcharts({
				        chart: {
				            type: 'column'
				        },
				        title: {
				            text: ' '
				        },
				        subtitle: {
				            text: ''
				        },
				        xAxis: {
				            categories: [
				            	@foreach($totalGroupDetail as $aGroup)
				            		{{"'".$aGroup['groupname']."',"}}
				            	@endforeach
				            	],
				            	// ['นักการเมือง', 'สื่อมวลชน', 'นักวิชาการ', 'สำนักข่าว', 'บุคคลทั่วไป'],
				            title: {
				                text: null
				            }
				        },
				        yAxis: {
				            min: 0,
				            title: {
				                text: 'จำนวนทวีต',
				                align: 'high'
				            },
				            labels: {
				                overflow: 'justify'
				            }
				        },
				        tooltip: {
				            valueSuffix: ' ทวีต'
				        },
				        plotOptions: {
				            bar: {
				                dataLabels: {
				                    enabled: true
				                }
				            }
				        },
				        legend: {
				            layout: 'vertical',
				            align: 'right',
				            verticalAlign: 'top',
				            x: -40,
				            y: 100,
				            floating: true,
				            borderWidth: 1,
				            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				            shadow: true
				        },
				        credits: {
				            enabled: false
				        },
				        series: [{
				            name: 'Tweet',
				            data: [
				            	@foreach($totalGroupDetail as $aGroup)
				            		{{$aGroup['tweetCount'].","}}
				            	@endforeach
				            ]
				            // [2507, 331, 405, 203, 2]
				        }, {
				            name: 'Retweet',
				            data: [
				            	@foreach($totalGroupDetail as $aGroup)
				            		{{$aGroup['retweetCount'].","}}
				            	@endforeach
				            ]
				            // [133, 156, 947, 408, 6]
				        }, {
				            name: 'Reply',
				            data: [
				            	@foreach($totalGroupDetail as $aGroup)
				            		{{$aGroup['replyCount'].","}}
				            	@endforeach
				            ]
				            // [973, 914, 312, 732, 34]
				        }, {
				            name: 'BeRetweeted',
				            data: [
				            	@foreach($totalGroupDetail as $aGroup)
				            		{{$aGroup['beRetweetedCount'].","}}
				            	@endforeach
				            ]
				            // [973, 914, 312, 732, 34]
				        }
				        ]
				    });
				});
			</script>
			<br>

			<div class="panel panel-green">
				<div class="panel-heading">
					<h3 class="panel-title onlythaibold" style="font-size:20px;">
						<i class="fa fa-long-arrow-right"></i> 
						กราฟแสดงจำนวนทวีตแบ่งตามประเภทของทวีต&nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="กราฟแท่งที่แสดงว่าแต่ละประเภทกิจกรรม (Tweet, Retweet, Reply) มีกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์ใดมีส่วนร่วมบ้าง"></span>
                    </h3>
				</div>
				<div class="panel-body">
					<div id="container2" style="width:auto; height: 400px; margin: 0 auto"></div>			
				</div>
			</div>			
			<script>
				$(function () {
				    $('#container2').highcharts({
				        chart: {
				            type: 'column'
				        },
				        title: {
				            text: ' '
				        },
				        subtitle: {
				            text: ''
				        },
				        xAxis: {
				            categories: ['Tweet', 'Retweet', 'Reply'],
				            title: {
				                text: null
				            }
				        },
				        yAxis: {
				            min: 0,
				            title: {
				                text: 'จำนวนทวีต',
				                align: 'high'
				            },
				            labels: {
				                overflow: 'justify'
				            }
				        },
				        tooltip: {
				            valueSuffix: ' ทวีต'
				        },
				        plotOptions: {
				            bar: {
				                dataLabels: {
				                    enabled: true
				                }
				            }
				        },
				        legend: {
				            layout: 'vertical',
				            align: 'right',
				            verticalAlign: 'top',
				            x: -40,
				            y: 100,
				            floating: true,
				            borderWidth: 1,
				            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				            shadow: true
				        },
				        credits: {
				            enabled: false
				        },
				        series: [
				        @foreach($totalGroupDetail as $aGroup)
				        	{
				        		name: {{"'".$aGroup['groupname']."',"}}
				        		data: [{{$aGroup['tweetCount']}},{{$aGroup['retweetCount']}},{{$aGroup['replyCount']}}]
				        	},
				        @endforeach
				        // {
				        //     name: 'นักการเมือง',
				        //     data: [2507, 331, 405]
				        // }, {
				        //     name: 'สื่อมวลชน',
				        //     data: [133, 156, 947]
				        // }, {
				        //     name: 'นักวิชาการ',
				        //     data: [973, 914, 312]
				        // }, {
				        //     name: 'สำนักข่าว',
				        //     data: [1204, 166, 512]
				        // }, {
				        //     name: 'บุคคลทั่วไป',
				        //     data: [12, 111, 432]
				        // }
				        ]
				    });
				});
			</script>
			<br>

			<div class="col-lg-12 col-md-12 col-sm-12">                                
                <ul id="pillMenu" class="nav nav-pills" style="font-family:thaisansneue; font-size:18px;">
				  	<li class="active"><a href="#p1" data-toggle="tab">Tweet</a></li>
				  	<li><a href="#p2" data-toggle="tab">Retweet</a></li>
				  	<li><a href="#p3" data-toggle="tab">Reply</a></li>
				</ul>
            </div>
            <br><br>
            <div id="myPillContent" class="tab-content top-buffer">
            	<div class="tab-pane fade in active" id="p1">
            		<div class="panel-group" id="accordion1" style="font-family:thaisansneue; font-size:18px;">
				        <!--  -->
				        @if(sizeof($tweetInterestDetailList)!==0)
				        {{-- */$nowGroupID = NULL;/* --}}
				        {{-- */$nowdate = NULL;/* --}}
				        @foreach($tweetInterestDetailList as $key=>$aTweet)
				        @if($key==0 or $nowGroupID!==$aTweet->groupid)
				        {{-- */$nowGroupID=$aTweet->groupid;/* --}}
				        @if($key!==0)
				                    </ul>						                    
				                </div>
				            </div>
				        </div>
				        @endif
				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion1" href="{{'#collapse1-'.$aTweet->groupid}}" style="font-size:20px;">{{$aTweet->groupname}}</a>
				                    <p class="pull-right">
				                    	<i class="fa fa-comment fa-fw"></i> {{$totalGroupDetail[$aTweet->groupid]['tweetCount']." tweets"}}
                                    </p>
				                </h4>
				            </div>
				            <div id="{{'collapse1-'.$aTweet->groupid}}" class="panel-collapse collapse">
				                <div class="panel-body">
				                	<ul class="chat" style="max-height: 500px; overflow-y: scroll;">
				        @endif
				        @if($key==0 or $nowdate!==$aTweet->thedate)
			            {{-- */$nowdate = $aTweet->thedate;/* --}}
			                			<li class="left clearfix">
			                    			<p style="font-family:thaisansneue; color:rgb(50,150,50); font-size:18px;"><i class="glyphicon glyphicon-calendar"></i>{{$aTweet->nameday." ".$aTweet->date." ".$aTweet->month." ".$aTweet->year}}</p>
			                    		</li>
			            @endif
										<li class="left clearfix">
			                                <span class="chat-img pull-left">
			                                    <a href="http://twitter.com/{{$aTweet->real_screenname}}" target="blank" class="tweet_avatar2">
			                                        <img src="{{$aTweet->real_pic}}" alt="{{$aTweet->real_screenname}}" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
			                                    </a>
			                                </span>
			                                <div class="chat-body clearfix">
			                                    <div class="header">
			                                        <strong class="primary-font"><a href="http://twitter.com/{{$aTweet->real_screenname}}" target="blank" class="tweet_screen_name2 screen_name">{{$aTweet->real_name}}</a></strong> 
			                                        <span style="color:#AAAAAA;">{{"@".$aTweet->real_screenname}}</span>
			                                    </div>
			                                    <p>
			                                        {{$aTweet->original_text}}
			                                    </p>
			                                    <small class="text-muted">
			                                        <span class="glyphicon glyphicon-send"></span> {{$aTweet->real_sourcename}}
			                                        <i class="fa fa-clock-o fa-fw"></i> {{$aTweet->real_created_at}}
			                                    </small>			                                   
			                                </div>
			                            </li>
				        @endforeach                
				                    </ul>						                    
				                </div>
				            </div>
				        </div>
				        @endif
				        
				    </div>
            	</div>

            	<div class="tab-pane fade" id="p2">
            		<div class="panel-group" id="accordion2" style="font-family:thaisansneue; font-size:18px;">
				    					        <!--  -->
				        @if(sizeof($retweetInterestDetailList)!==0)
				        {{-- */$nowGroupID = NULL;/* --}}
				        {{-- */$nowdate = NULL;/* --}}
				        @foreach($retweetInterestDetailList as $key=>$aTweet)
				        @if($key==0 or $nowGroupID!==$aTweet->groupid)
				        {{-- */$nowGroupID=$aTweet->groupid;/* --}}
				        @if($key!==0)
				                    </ul>						                    
				                </div>
				            </div>
				        </div>
				        @endif
				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion1" href="{{'#collapse2-'.$aTweet->groupid}}" style="font-size:20px;">{{$aTweet->groupname}}</a>
				                    <p class="pull-right">
				                    	<i class="fa fa-retweet fa-fw"></i> {{$totalGroupDetail[$aTweet->groupid]['retweetCount']." retweets"}}
                                    </p>
				                </h4>
				            </div>
				            <div id="{{'collapse2-'.$aTweet->groupid}}" class="panel-collapse collapse">
				                <div class="panel-body">
				                	<ul class="chat" style="max-height: 500px; overflow-y: scroll;">
				        @endif
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
			                                    <br>
			                                    <small class="text-muted">
			                                    	<i class="fa fa-retweet fa-fw"></i> Retweeted by <a href="http://twitter.com/{{$aTweet->real_screenname}}" target="blank" class="tweet_screen_name2 screen_name" style="color:rgb(100,100,100)">{{$aTweet->real_screenname}}</a>
				                                	<span class="glyphicon glyphicon-send"></span> {{$aTweet->real_sourcename}}
				                                    <i class="fa fa-clock-o fa-fw"></i> {{$aTweet->real_created_at}}                                 
					                            </small>
			                                </div>
			                            </li>
				        @endforeach                
				                    </ul>						                    
				                </div>
				            </div>
				        </div>
				        @endif 	   
				    </div>
            	</div>

            	<div class="tab-pane fade" id="p3">
            		<div class="panel-group" id="accordion3" style="font-family:thaisansneue; font-size:18px;">
				        				        <!--  -->
				        @if(sizeof($replyInterestDetailList)!==0)
				        {{-- */$nowGroupID = NULL;/* --}}
				        {{-- */$nowdate = NULL;/* --}}
				        @foreach($replyInterestDetailList as $key=>$aTweet)
				        @if($key==0 or $nowGroupID!==$aTweet->groupid)
				        {{-- */$nowGroupID=$aTweet->groupid;/* --}}
				        @if($key!==0)
				                    </ul>						                    
				                </div>
				            </div>
				        </div>
				        @endif
				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion3" href="{{'#collapse3-'.$aTweet->groupid}}" style="font-size:20px;">{{$aTweet->groupname}}</a>
				                    <p class="pull-right">
				                    	<i class="fa fa-reply fa-fw"></i> {{$totalGroupDetail[$aTweet->groupid]['replyCount']." replies"}}
                                    </p>
				                </h4>
				            </div>
				            <div id="{{'collapse3-'.$aTweet->groupid}}" class="panel-collapse collapse">
				                <div class="panel-body">
				                	<ul class="chat" style="max-height: 500px; overflow-y: scroll;">
				        @endif
				        @if($key==0 or $nowdate!==$aTweet->thedate)
			            {{-- */$nowdate = $aTweet->thedate;/* --}}
			                			<li class="left clearfix">
			                    			<p style="font-family:thaisansneue; color:rgb(50,150,50); font-size:18px;"><i class="glyphicon glyphicon-calendar"></i>{{$aTweet->nameday." ".$aTweet->date." ".$aTweet->month." ".$aTweet->year}}</p>
			                    		</li>
			            @endif
										<li class="left clearfix">
			                                <span class="chat-img pull-left">
			                                    <a href="http://twitter.com/{{$aTweet->real_screenname}}" target="blank" class="tweet_avatar2">
			                                        <img src="{{$aTweet->real_pic}}" alt="{{$aTweet->real_screenname}}" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
			                                    </a>
			                                </span>
			                                <div class="chat-body clearfix">
			                                    <div class="header">
			                                        <strong class="primary-font"><a href="http://twitter.com/{{$aTweet->real_screenname}}" target="blank" class="tweet_screen_name2 screen_name">{{$aTweet->real_name}}</a></strong> 
			                                        <span style="color:#AAAAAA;">{{"@".$aTweet->real_screenname}}</span>
			                                    </div>
			                                    <p>
			                                        {{$aTweet->original_text}}
			                                    </p>
			                                    <small class="text-muted">
			                                        <span class="glyphicon glyphicon-send"></span> {{$aTweet->real_sourcename}}
			                                        <i class="fa fa-clock-o fa-fw"></i> {{$aTweet->real_created_at}}
			                                    </small>			                                   
			                                </div>
			                            </li>
				        @endforeach                
				                    </ul>						                    
				                </div>
				            </div>
				        </div>
				        @endif
				    </div>
            	</div>            	
            </div>


		    


		</div>	
	</div>
</div>

