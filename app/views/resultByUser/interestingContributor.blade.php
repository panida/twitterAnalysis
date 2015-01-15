<div id="page-wrapper">
	<div class="container-fluid top-buffer">
		<div class="col-lg-12">
			<br>

			<div class="col-lg-12 col-md-12 col-sm-12">                                
                <ul id="pillMenu" class="nav nav-pills" style="font-family:thaisansneue; font-size:18px;">
				  	<li class="active"><a href="#p1" data-toggle="tab">Follow</a></li>
				  	<li><a href="#p2" data-toggle="tab">Retweet</a></li>
				</ul>
            </div>
            <br><br>
            <div id="myPillContent" class="tab-content top-buffer">
            	<div class="tab-pane fade in active" id="p1">
            		<div class="panel-group" id="accordion1" style="font-family:thaisansneue; font-size:18px;">
				        <!--  -->
				        @if(sizeof($tweetInterestDetailList)!==0)
				        {{-- */$nowGroupID = NULL;/* --}}
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
        	
            </div>


		    


		</div>	
	</div>
</div>

