<div id="page-wrapper">
	<div class="container-fluid top-buffer">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<br>
			<h2 class="panel-title onlythaibold" style="font-size:25px;"><i class="fa fa-fw fa-user" style="color:#4171EB;"></i> จำนวนผู้ติดตาม: {{number_format($countAllFollower)}} คน</h2>
	        <br>
	        <div class="panel panel-green">
	            <div class="panel-heading">
	                <h3 class="panel-title onlythaibold" style="font-size:20px;">
	                    <i class="fa fa-long-arrow-right"></i> 
	                    ผู้ติดตามของ {{$searchText}} 50 คนล่าสุด
	<!--                     <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="ในกรณีของรีทวีต จำนวน Follower ที่ใช้เรียงจะเป็นของผู้รีทวีต"></span> -->
	                </h3>
	            </div>
	            <div class="panel-body" style="max-height: 500px; overflow-y: scroll;">
	            	@foreach($recentFollowerList as $aFollower)
	            	<a href= "http://twitter.com/{{$aFollower['screen_name']}}" target="blank" class="tweet_avatar2">
	                	<img src="{{$aFollower['profile_image_url']}}" alt="{{$aFollower['screen_name']}}" title="{{'@'.$aFollower['screen_name']}}" class="avatar" onerror="if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';">
	                </a>
	                @endforeach
	                <div class="text-right onlythaibold">
                        <a href="http://twitter.com/{{$user->screenname}}/followers" style="font-size:18px;" target="blank">ดูทั้งหมด <i class="fa fa-arrow-circle-right"></i></a>
                    </div>                                     
	            </div>
	        </div>
	    </div>
	</div>
</div>
