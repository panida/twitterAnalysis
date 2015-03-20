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
			                        <a id="timelineSeeMore" class="btn btn-default">See more</a>
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
			                        <a id="topRetweetedSeeMore" class="btn btn-default">See more</a>
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
		                        	<a id="topFollowerSeeMore" class="btn btn-default">See more</a>
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
<script type="text/javascript">
	$(function() {
		var beforeButton = $('<div id="timelinePage0"></div>');
		$("#timelineSeeMore").before(beforeButton);
        $("#timelinePage0").load("./public/ajaxFile/{{$filenameTimeline}} .timelineP0");
        if({{$timelineLastPage}}==0){
			$("#timelineSeeMore").remove();
		}

		var beforeButton = $('<div id="topRetweetedPage0"></div>');
		$("#topRetweetedSeeMore").before(beforeButton);
        $("#topRetweetedPage0").load("./public/ajaxFile/{{$filenameTopRetweeted}} .topRetweetedP0");
        if({{$topRetweetedLastPage}}==0){
			$("#topRetweetedSeeMore").remove();
		}

		var beforeButton = $('<div id="topFollowerPage0"></div>');
		$("#topFollowerSeeMore").before(beforeButton);
        $("#topFollowerPage0").load("./public/ajaxFile/{{$filenameTopFollower}} .topFollowerP0");
        if({{$topFollowerLastPage}}==0){
			$("#topFollowerSeeMore").remove();
		}
	});
	var timelinePage = 1;
	$("#timelineSeeMore").click(function(){
		var beforeButton = $('<div id="timelinePage'+timelinePage+'"></div>');
		$("#timelineSeeMore").before(beforeButton);
        $("#timelinePage"+timelinePage).load("./public/ajaxFile/{{$filenameTimeline}} .timelineP"+timelinePage);
        timelinePage+=1;
	    if(timelinePage>{{$timelineLastPage}}){
			$("#timelineSeeMore").remove();
		}
    });
    var topRetweetedPage = 1;
	$("#topRetweetedSeeMore").click(function(){
		var beforeButton = $('<div id="topRetweetedPage'+topRetweetedPage+'"></div>');
		$("#topRetweetedSeeMore").before(beforeButton);
        $("#topRetweetedPage"+topRetweetedPage).load("./public/ajaxFile/{{$filenameTopRetweeted}} .topRetweetedP"+topRetweetedPage);
        topRetweetedPage+=1;
	    if(topRetweetedPage>{{$topRetweetedLastPage}}){
			$("#topRetweetedSeeMore").remove();
		}
    });
    var topFollowerPage = 1;
	$("#topFollowerSeeMore").click(function(){
		var beforeButton = $('<div id="topFollowerPage'+topFollowerPage+'"></div>');
		$("#topFollowerSeeMore").before(beforeButton);
        $("#topFollowerPage"+topFollowerPage).load("./public/ajaxFile/{{$filenameTopFollower}} .topFollowerP"+topFollowerPage);
        topFollowerPage+=1;
	    if(topFollowerPage>{{$topFollowerLastPage}}){
			$("#topFollowerSeeMore").remove();
		}
    });
</script>