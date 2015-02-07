<div id="page-wrapper">
	<div class="container-fluid top-buffer">
		<div class="col-lg-12">
			<h2 class="panel-title onlythaibold" style="font-size:20px;">
		        <i class="fa fa-fw fa-user"></i> 
		        {{$user->name}}<span style="color:#AAAAAA;">{{' @'.$user->screenname}}</span>  
		        @if(sizeof($hisGroup)!==0)
		        	&nbsp;เป็นหนึ่งในสมาชิกของกลุ่มตัวอย่าง
		        	@foreach($hisGroup as $aKey=>$aGroup)
		        		@if($aKey!==0)
		        			,&nbsp;
		        		@endif
		        		<a href="{{URL::to('/group/'.$aGroup->groupid)}}" target="blank">{{$aGroup->groupname}}</a>
		        	@endforeach
		        @else
		        	&nbsp;ไม่อยู่ในกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์ใด
		        @endif 
		    </h2>
		    <br>
			<div class="panel panel-green">
				<div class="panel-heading">
					<h3 class="panel-title thaibold" style="font-size:20px;">
						<i class="fa fa-long-arrow-right"></i> 
						กราฟแสดงจำนวนกิจกรรมของกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์ที่เกี่ยวข้อง&nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="กราฟแท่งที่แสดงว่ามีสมาชิกในกลุ่มตัวอย่างผู้ใช้ทวิตเตอร์ใดบ้างที่ติดตามผู้ใช้รายนี้ หรือรีทวีตข้อความของผู้ใช้รายนี้"></span>
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
				                text: 'จำนวน',
				                align: 'high'
				            },
				            labels: {
				                overflow: 'justify'
				            }
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
				            name: 'Followee',
				            data: [
				            	@foreach($totalGroupDetail as $aGroup)
				            		{{$aGroup['followeeCount'].","}}
				            	@endforeach
				            ],
				            tooltip: {
				            	valueSuffix: ' คน'
				        	}
				            // [2507, 331, 405, 203, 2]
				        }, {
				            name: 'Retweet',
				            data: [
				            	@foreach($totalGroupDetail as $aGroup)
				            		{{$aGroup['retweetCount'].","}}
				            	@endforeach
				            ],
				            tooltip: {
				            	valueSuffix: ' ครั้ง'
				        	}
				            // [133, 156, 947, 408, 6]
				        }
				        ]
				    });
				});
			</script>
			<br>

			<div class="col-lg-12 col-md-12 col-sm-12">                                
                <ul id="pillMenu" class="nav nav-pills" style="font-family:thaisansneue; font-size:18px;">
				  	<li class="active"><a href="#p1" data-toggle="tab">Followee</a></li>
				  	<li><a href="#p2" data-toggle="tab">Retweet</a></li>
				</ul>
            </div>
            <br><br>
            <div id="myPillContent" class="tab-content top-buffer">
            	<div class="tab-pane fade in active" id="p1">
            		<div class="panel-group" id="accordion1" style="font-family:thaisansneue; font-size:18px;">
				        <!--  -->
				        @if(sizeof($followeeInterestDetailList)!==0)
				        {{-- */$nowGroupID = NULL; $index=-1;/* --}}
				        @foreach($followeeInterestDetailList as $key=>$aUser)
				        @if($key==0 or $nowGroupID!==$aUser->groupid)
				        {{-- */$nowGroupID=$aUser->groupid; $index+=1;/* --}}
				        @if($key!==0)
				                    </ul>						                    
				                </div>
				            </div>
				        </div>
				        @endif
				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion1" href="{{'#collapse1-'.$aUser->groupid}}" style="font-size:20px;">{{$aUser->groupname}}</a>
				                    <p class="pull-right">
				                    	<i class="fa fa-user fa-fw"></i> {{$followeeInterestCountList[$index]['totalCountInAGroup']}} user
				                    	@if($followeeInterestCountList[$index]['totalCountInAGroup']>1)
				                    		s
				                    	@endif
                                    </p>
				                </h4>
				            </div>
				            <div id="{{'collapse1-'.$aUser->groupid}}" class="panel-collapse collapse">
				                <div class="panel-body">
				                	<ul class="chat" style="max-height: 500px; overflow-y: scroll;">
				        @endif
										<li class="left clearfix">
					                        <span class="chat-img pull-left">
					                            <a href= "http://twitter.com/{{$aUser->screenname}}" target="blank" class="tweet_avatar2">
					                                <img src="{{$aUser->pic}}" alt="{{$aUser->screenname}}" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
					                            </a>
					                        </span>
					                        <div class="chat-body clearfix">
					                            <div class="header">
					                                <strong class="primary-font"><a href="http://twitter.com/{{$aUser->screenname}}" target="blank" class="tweet_screen_name2 screen_name">{{$aUser->name}}</a></strong> 
					                                <span style="color:#AAAAAA;">{{'@'.$aUser->screenname}}</span>    					                                                        
					                            </div>
					                            <p>
					                                {{$aUser->description}}
					                            </p>
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
				        {{-- */$nowGroupID = NULL; $index=-1;/* --}}
				        {{-- */$nowdate = NULL;/* --}}
				        @foreach($retweetInterestDetailList as $key=>$aTweet)
				        @if($key==0 or $nowGroupID!==$aTweet->groupid)
				        {{-- */$nowGroupID=$aTweet->groupid; $index+=1;/* --}}
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
				                    	<i class="fa fa-retweet fa-fw"></i> {{$retweetInterestCountList[$index]->totalCountInAGroup}} retweet
				                    	@if($retweetInterestCountList[$index]->totalCountInAGroup>1)
				                    		s
				                    	@endif
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
			                                        <small class="text-muted">
			                                        	retweeted <a href="http://twitter.com/{{$aTweet->real_screenname}}" target="blank" class="tweet_screen_name2 screen_name" style="color:rgb(100,100,100)">{{$aTweet->real_screenname}}</a>
			                                    	</small>
			                                    </div>
			                                    <p>
			                                        {{$aTweet->original_text}}
			                                    </p>
			                                    <small class="text-muted">			                                    	
				                                	<span class="glyphicon glyphicon-send"></span> {{$aTweet->real_sourcename}}
				                                    <i class="fa fa-clock-o fa-fw"></i> {{$aTweet->real_created_at}}                                 
					                            </small>
					                            <br>
					                            <small class="text-muted">
					                            	Retweeted using
			                                        <span class="glyphicon glyphicon-send"></span> {{$aTweet->original_sourcename}}
			                                        <i class="fa fa-clock-o fa-fw"></i> {{$aTweet->original_created_at}}
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

