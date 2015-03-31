<div id="page-wrapper">
	<div class="container-fluid top-buffer">
		<div class="row thaibold">
            <div class="col-lg-10 col-lg-offset-1">
            	<div class="col-lg-4 col-md-6 col-sm-6">
            		<h3 class="onlythaibold" style="text-align:center;">มีผู้ติดตามมากที่สุด&nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="ผู้ใช้ที่มีผู้จำนวนติดตามมากที่สุดในบรรดาผู้ใช้เผยแพร่ที่ทวีตที่มีคำค้นหา"></span>
                    </h3>
					<div class="panel panel-red">
					    <div class="panel-heading">
					        <div class="row">
					            <div class="col-xs-3">
					                <a href="http://twitter.com/{{$maxFollowerUser['screenname']}}" target="blank" class="avatar" target="_blank"><img alt="{{$maxFollowerUser['screenname']}}" src="{{$maxFollowerUser['pic']}}" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';"/></a>
					            </div>
					            <div class="col-xs-9 text-right">
					            	<div class="huge">{{number_format($maxFollowerUser['count'])}}</div>
					                <div>followers</div>
					            </div>
					        </div>
					    </div>				 
					    <a href="http://twitter.com/{{$maxFollowerUser['screenname']}}" target="blank">
					        <div class="panel-footer">
					            <span class="pull-left">{{"@".$maxFollowerUser['screenname']}}</a></span>
					            <!-- <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span> -->
					            <div class="clearfix"></div>
					        </div>
					    </a>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6">
					<h3 class="onlythaibold" style="text-align:center;">ถูกรีทวีตมากที่สุด&nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="ผู้ใช้ที่ทวีตข้อความที่มีคำค้นหาและข้อความเหล่านั้นถูกรีทวีตต่อรวมมากที่สุด"></span>
                    </h3>
					<div class="panel panel-primary">
					    <div class="panel-heading">
					        <div class="row">
					            <div class="col-xs-3">
					                <a href="http://twitter.com/{{$maxRetweetedUser['screenname']}}" target="blank" class="avatar" target="_blank"><img src="{{$maxRetweetedUser['pic']}}" alt="{{$maxRetweetedUser['screenname']}}" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_3_normal.png';"/></a>
					            </div>
					            <div class="col-xs-9 text-right">
					            	<div class="huge">{{number_format($maxRetweetedUser['count'])}}</div>
					                <div>retweets</div>
					            </div>
					        </div>
					    </div>
					    <a href="http://twitter.com/{{$maxRetweetedUser['screenname']}}" target="blank">
					        <div class="panel-footer">
					            <span class="pull-left">{{"@".$maxRetweetedUser['screenname']}}</a></span>
					            <!-- <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span> -->
					            <div class="clearfix"></div>
					        </div>
					    </a>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6">
					<h3 class="onlythaibold" style="text-align:center;">มีส่วนร่วมมากที่สุด&nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="ผู้ใช้ที่เผยแพร่ทวีตที่มีคำค้นหาบ่อยครั้งที่สุด"></span>
                    </h3>
					<div class="panel panel-yellow">
					    <div class="panel-heading">
					        <div class="row">
					            <div class="col-xs-3">
					                <a href="http://twitter.com/{{$maxActivityUser['screenname']}}" target="blank" class="avatar" target="_blank"><img src="{{$maxActivityUser['pic']}}" alt="{{$maxActivityUser['screenname']}}" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png';"></a>
					            </div>
					            <div class="col-xs-9 text-right">
					            	<div class="huge">{{number_format($maxActivityUser['count'])}}</div>
					                <div>tweets</div>
					            </div>
					        </div>
					    </div>
					    <a href="http://twitter.com/{{$maxActivityUser['screenname']}}" target="blank">
					        <div class="panel-footer">
					            <span class="pull-left">{{"@".$maxActivityUser['screenname']}}</a></span>
					            <!-- <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span> -->
					            <div class="clearfix"></div>
					        </div>
					    </a>
					</div>
				</div>
                <!-- <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3>ผู้ติดตามสูงที่สุด</h3>
                    <div class="col-lg-6"><img src="http://pbs.twimg.com/profile_images/482577002927366144/xUB3iuIF_normal.jpeg"></img></div>
                    <div class="col-lg-6"><h1>Chatchamon Writer</h1><h3>1,048 คน</h3></div>
                </div> 
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3>ถูกรีทวีตมากที่สุด</h3>
                    <div class="col-lg-6"><span class="glyphicon glyphicon-user" style="font-size:80px;" aria-hidden="true"></span></div>
                    <div class="col-lg-6"><h1>472</h1><h3>คน</h3></div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <h3>ถูก mention มากที่สุด</h3>
                    <div class="col-lg-6"><span class="glyphicon glyphicon-eye-open" style="font-size:80px;" aria-hidden="true"></span></div>
                    <div class="col-lg-6"><h1>32,599</h1><h3>ครั้ง</h3></div>
                </div> -->
            </div>
        </div>

        <style type="text/css">
        	.center-align{
        		text-align:center;
        	}
        </style>
        <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h3 class="panel-title onlythaibold" style="font-size:20px;">
                    	<i class="fa fa-long-arrow-right"></i> ผู้ใช้ที่เกี่ยวข้องทั้งหมด
                    	<span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="แสดงผลเฉพาะ 1,000 คนแรกที่มีผู้ติดตามมากที่สุด หากต้องการดูรายชื่อทั้งหมด สามารถดาวน์โหลดได้จาก ไฟล์ .csv"></span>
                    </h3>
                </div>
                <div class="panel-body" style="min-height: 570px; max-height: 570px; overflow-y: scroll;">
                    <div class="row onlythaibold" style="font-size:20px;">
                    	<p style="margin-left:20px;">เลือกดูผู้ใช้ที่&nbsp;
	                   		<input id="cb1" type="checkbox" value="1" onchange="valueChanged()" checked /> Tweet&nbsp;
	                   		<input id="cb2" type="checkbox" value="1" onchange="valueChanged()" checked /> Retweet&nbsp;
	                   		<input id="cb3" type="checkbox" value="1" onchange="valueChanged()" checked /> Reply&nbsp;
                   		</p>
                    </div>	
                    

					<script type="text/javascript">
						function valueChanged()
						{
							$(window).resize();
						    var x=0;
						    if($('#cb1').is(":checked")) x+=1;
						    x*=2;
						    if($('#cb2').is(":checked")) x+=1;
						    x*=2;
						    if($('#cb3').is(":checked")) x+=1;
						    var name="#table"+x;
						    $(".contributorTable").hide();
						    $(name).show();
						
						}
					</script>

					<div class="table-responsive contributorTable" id="table0" style="display: none;">

					</div>

					<div class="table-responsive contributorTable" id="table1" style="display: none;">
						<div class="col-lg-12 col-md-12 col-sm-12"> 
							<p class="col-lg-1 col-md-1 col-sm-1 onlythaibold" style="font-size:22px;">หน้า </p>    
							<ul id="pillMenu1" class="nav nav-pills" style="position: relative;">
							  	<li role="presentation" class="active"><a href="#RP0" data-toggle="tab">1</a></li>
							  	@for($i=2;$i<=count($RpUserList);$i++)
								<li role="presentation"><a href="{{'#RP'.($i-1)}}" data-toggle="tab">{{$i}}</a></li>
								@endfor
							</ul>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div id="myPillContent" class="tab-content top-buffer">          
								@foreach($RpUserList as $key=>$aSmallList)								
									@if($key==0)
						        	<div class="tab-pane fade in active" id="{{'RP'.$key}}">
						        	@else
						        	<div class="tab-pane fade" id="{{'RP'.$key}}">
							        @endif
										<table class="table table-hover table-striped">
									        <thead>
									          	<th>&nbsp;</th>
									          	<th class="center-align">Tweets</th>
									          	<th class="center-align">Retweets</th>
									          	<th class="center-align">Replies</th>
									          	<th class="center-align">Followers</th>
									        </thead>
							        		<tbody>		
									        	@foreach($aSmallList as $aUser)
										        <tr>
										            <td class="screen_name"><a href="http://twitter.com/{{$aUser['screenname']}}" target="blank">{{"@".$aUser['screenname']}}</a></td>
										            <td class="center-align">{{number_format($aUser['tweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['retweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['replyCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['followerCount'])}}</td>
										        </tr> 
										    	@endforeach	  	
								    		</tbody>
										</table>
									</div>								
								@endforeach
							</div>
						</div>
					</div>

					<div class="table-responsive contributorTable" id="table2" style="display: none;">
						<div class="col-lg-12 col-md-12 col-sm-12"> 
							<p class="col-lg-1 col-md-1 col-sm-1 thaibold" style="font-size:22px;">หน้า </p>    
							<ul id="pillMenu2" class="nav nav-pills" style="position: relative;">
							  	<li role="presentation" class="active"><a href="#RT0" data-toggle="tab">1</a></li>
							  	@for($i=2;$i<=count($RtUserList);$i++)
								<li role="presentation"><a href="{{'#RT'.($i-1)}}" data-toggle="tab">{{$i}}</a></li>
								@endfor
							</ul>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div id="myPillContent" class="tab-content top-buffer">          
								@foreach($RtUserList as $key=>$aSmallList)								
									@if($key==0)
						        	<div class="tab-pane fade in active" id="{{'RT'.$key}}">
						        	@else
						        	<div class="tab-pane fade" id="{{'RT'.$key}}">
							        @endif
										<table class="table table-hover table-striped">
									        <thead>
									          	<th>&nbsp;</th>
									          	<th class="center-align">Tweets</th>
									          	<th class="center-align">Retweets</th>
									          	<th class="center-align">Replies</th>
									          	<th class="center-align">Followers</th>
									        </thead>
							        		<tbody>		
									        	@foreach($aSmallList as $aUser)
										        <tr>
										            <td class="screen_name"><a href="http://twitter.com/{{$aUser['screenname']}}" target="blank">{{"@".$aUser['screenname']}}</a></td>
										            <td class="center-align">{{number_format($aUser['tweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['retweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['replyCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['followerCount'])}}</td>
										        </tr> 
										    	@endforeach	  	
								    		</tbody>
										</table>
									</div>								
								@endforeach
							</div>
						</div>
					</div>

					<div class="table-responsive contributorTable" id="table3" style="display: none;">
						<div class="col-lg-12 col-md-12 col-sm-12"> 
							<p class="col-lg-1 col-md-1 col-sm-1 thaibold" style="font-size:22px;">หน้า </p>    
							<ul id="pillMenu3" class="nav nav-pills" style="position: relative;">
							  	<li role="presentation" class="active"><a href="#RTRP0" data-toggle="tab">1</a></li>
							  	@for($i=2;$i<=count($RtRpUserList);$i++)
								<li role="presentation"><a href="{{'#RTRP'.($i-1)}}" data-toggle="tab">{{$i}}</a></li>
								@endfor
							</ul>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div id="myPillContent" class="tab-content top-buffer">          
								@foreach($RtRpUserList as $key=>$aSmallList)								
									@if($key==0)
						        	<div class="tab-pane fade in active" id="{{'RTRP'.$key}}">
						        	@else
						        	<div class="tab-pane fade" id="{{'RTRP'.$key}}">
							        @endif
										<table class="table table-hover table-striped">
									        <thead>
									          	<th>&nbsp;</th>
									          	<th class="center-align">Tweets</th>
									          	<th class="center-align">Retweets</th>
									          	<th class="center-align">Replies</th>
									          	<th class="center-align">Followers</th>
									        </thead>
							        		<tbody>		
									        	@foreach($aSmallList as $aUser)
										        <tr>
										            <td class="screen_name"><a href="http://twitter.com/{{$aUser['screenname']}}" target="blank">{{"@".$aUser['screenname']}}</a></td>
										            <td class="center-align">{{number_format($aUser['tweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['retweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['replyCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['followerCount'])}}</td>
										        </tr> 
										    	@endforeach	  	
								    		</tbody>
										</table>
									</div>								
								@endforeach
							</div>
						</div>
					</div>

					<div class="table-responsive contributorTable" id="table4" style="display: none;">
						<div class="col-lg-12 col-md-12 col-sm-12"> 
							<p class="col-lg-1 col-md-1 col-sm-1 thaibold" style="font-size:22px;">หน้า </p>    
							<ul id="pillMenu4" class="nav nav-pills" style="position: relative;">
							  	<li role="presentation" class="active"><a href="#TW0" data-toggle="tab">1</a></li>
							  	@for($i=2;$i<=count($TwUserList);$i++)
								<li role="presentation"><a href="{{'#TW'.($i-1)}}" data-toggle="tab">{{$i}}</a></li>
								@endfor
							</ul>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div id="myPillContent" class="tab-content top-buffer">          
								@foreach($TwUserList as $key=>$aSmallList)								
									@if($key==0)
						        	<div class="tab-pane fade in active" id="{{'TW'.$key}}">
						        	@else
						        	<div class="tab-pane fade" id="{{'TW'.$key}}">
							        @endif
										<table class="table table-hover table-striped">
									        <thead>
									          	<th>&nbsp;</th>
									          	<th class="center-align">Tweets</th>
									          	<th class="center-align">Retweets</th>
									          	<th class="center-align">Replies</th>
									          	<th class="center-align">Followers</th>
									        </thead>
							        		<tbody>		
									        	@foreach($aSmallList as $aUser)
										        <tr>
										            <td class="screen_name"><a href="http://twitter.com/{{$aUser['screenname']}}" target="blank">{{"@".$aUser['screenname']}}</a></td>
										            <td class="center-align">{{number_format($aUser['tweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['retweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['replyCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['followerCount'])}}</td>
										        </tr> 
										    	@endforeach	  	
								    		</tbody>
										</table>
									</div>								
								@endforeach
							</div>
						</div>
					</div>

					<div class="table-responsive contributorTable" id="table5" style="display: none;">
						<div class="col-lg-12 col-md-12 col-sm-12"> 
							<p class="col-lg-1 col-md-1 col-sm-1 thaibold" style="font-size:22px;">หน้า </p>    
							<ul id="pillMenu5" class="nav nav-pills" style="position: relative;">
							  	<li role="presentation" class="active"><a href="#TWRP0" data-toggle="tab">1</a></li>
							  	@for($i=2;$i<=count($TwRpUserList);$i++)
								<li role="presentation"><a href="{{'#TWRP'.($i-1)}}" data-toggle="tab">{{$i}}</a></li>
								@endfor
							</ul>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div id="myPillContent" class="tab-content top-buffer">          
								@foreach($TwRpUserList as $key=>$aSmallList)								
									@if($key==0)
						        	<div class="tab-pane fade in active" id="{{'TWRP'.$key}}">
						        	@else
						        	<div class="tab-pane fade" id="{{'TWRP'.$key}}">
							        @endif
										<table class="table table-hover table-striped">
									        <thead>
									          	<th>&nbsp;</th>
									          	<th class="center-align">Tweets</th>
									          	<th class="center-align">Retweets</th>
									          	<th class="center-align">Replies</th>
									          	<th class="center-align">Followers</th>
									        </thead>
							        		<tbody>		
									        	@foreach($aSmallList as $aUser)
										        <tr>
										            <td class="screen_name"><a href="http://twitter.com/{{$aUser['screenname']}}" target="blank">{{"@".$aUser['screenname']}}</a></td>
										            <td class="center-align">{{number_format($aUser['tweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['retweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['replyCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['followerCount'])}}</td>
										        </tr> 
										    	@endforeach	  	
								    		</tbody>
										</table>
									</div>								
								@endforeach
							</div>
						</div>
					</div>

					<div class="table-responsive contributorTable" id="table6" style="display: none;">
						<div class="col-lg-12 col-md-12 col-sm-12"> 
							<p class="col-lg-1 col-md-1 col-sm-1 thaibold" style="font-size:22px;">หน้า </p>    
							<ul id="pillMenu6" class="nav nav-pills" style="position: relative;">
							  	<li role="presentation" class="active"><a href="#TWRT0" data-toggle="tab">1</a></li>
							  	@for($i=2;$i<=count($TwRtUserList);$i++)
								<li role="presentation"><a href="{{'#TWRT'.($i-1)}}" data-toggle="tab">{{$i}}</a></li>
								@endfor
							</ul>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div id="myPillContent" class="tab-content top-buffer">          
								@foreach($TwRtUserList as $key=>$aSmallList)								
									@if($key==0)
						        	<div class="tab-pane fade in active" id="{{'TWRT'.$key}}">
						        	@else
						        	<div class="tab-pane fade" id="{{'TWRT'.$key}}">
							        @endif
										<table class="table table-hover table-striped">
									        <thead>
									          	<th>&nbsp;</th>
									          	<th class="center-align">Tweets</th>
									          	<th class="center-align">Retweets</th>
									          	<th class="center-align">Replies</th>
									          	<th class="center-align">Followers</th>
									        </thead>
							        		<tbody>		
									        	@foreach($aSmallList as $aUser)
										        <tr>
										            <td class="screen_name"><a href="http://twitter.com/{{$aUser['screenname']}}" target="blank">{{"@".$aUser['screenname']}}</a></td>
										            <td class="center-align">{{number_format($aUser['tweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['retweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['replyCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['followerCount'])}}</td>
										        </tr> 
										    	@endforeach	  	
								    		</tbody>
										</table>
									</div>								
								@endforeach
							</div>
						</div>
					</div>

                    <div class="table-responsive contributorTable" id="table7">    	
				        <div class="col-lg-12 col-md-12 col-sm-12"> 
							<p class="col-lg-1 col-md-1 col-sm-1 thaibold" style="font-size:22px;">หน้า </p>    
							<ul id="pillMenu7" class="nav nav-pills" style="position: relative;">
							  	<li role="presentation" class="active"><a href="#TWRTRP0" data-toggle="tab">1</a></li>
							  	@for($i=2;$i<=count($TwRtRpUserList);$i++)
								<li role="presentation"><a href="{{'#TWRTRP'.($i-1)}}" data-toggle="tab">{{$i}}</a></li>
								@endfor
							</ul>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div id="myPillContent" class="tab-content top-buffer">          
								@foreach($TwRtRpUserList as $key=>$aSmallList)								
									@if($key==0)
						        	<div class="tab-pane fade in active" id="{{'TWRTRP'.$key}}">
						        	@else
						        	<div class="tab-pane fade" id="{{'TWRTRP'.$key}}">
							        @endif
										<table class="table table-hover table-striped">
									        <thead>
									          	<th>&nbsp;</th>
									          	<th class="center-align">Tweets</th>
									          	<th class="center-align">Retweets</th>
									          	<th class="center-align">Replies</th>
									          	<th class="center-align">Followers</th>
									        </thead>
							        		<tbody>		
									        	@foreach($aSmallList as $aUser)
										        <tr>
										            <td class="screen_name"><a href="http://twitter.com/{{$aUser['screenname']}}" target="blank">{{"@".$aUser['screenname']}}</a></td>
										            <td class="center-align">{{number_format($aUser['tweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['retweetCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['replyCount'])}}</td>
										            <td class="center-align">{{number_format($aUser['followerCount'])}}</td>
										        </tr> 
										    	@endforeach	  	
								    		</tbody>
										</table>
									</div>								
								@endforeach
							</div>
						</div>
		  			</div>
                </div>
            </div>
        </div>
	</div>
</div>
