<div id="page-wrapper">
	<div class="container-fluid top-buffer">
		<div class="col-lg-12">
			<div class="panel panel-green">
				<div class="panel-heading">
					<h3 class="panel-title thaibold" style="font-size:20px;">
						<i class="fa fa-long-arrow-right"></i> 
						กราฟแสดงจำนวนทวีตแบ่งตามกลุ่มตัวอย่างวิจัย&nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="We ask for your age only for statistical purposes."></span>
                    </h3>
				</div>
				<div class="panel-body">
					<div id="container1" style="width:auto; height: 400px; margin: 0 auto"></div>			
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
				        }
				        // , {
				        //     name: 'Retweeted',
				        //     data: [1204, 166, 512, 321, 12]
				        // }
				        ]
				    });
				});
			</script>
			<br>

			<div class="panel panel-green">
				<div class="panel-heading">
					<h3 class="panel-title thaibold" style="font-size:20px;">
						<i class="fa fa-long-arrow-right"></i> 
						กราฟแสดงจำนวนทวีตแบ่งตามประเภทของทวีต&nbsp;
                        <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" title="We ask for your age only for statistical purposes."></span>
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
				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1-1" style="font-size:20px;">1. นักการเมือง</a>
				                    <p class="pull-right">
				                    	<i class="fa fa-comment fa-fw"></i> 32 tweets
                                    </p>
				                </h4>
				            </div>
				            <div id="collapse1-1" class="panel-collapse collapse">
				                <div class="panel-body">
				                	<ul class="chat" style="max-height: 500px; overflow-y: scroll;">

				                    	<li class="left clearfix">
				                    		<p style="font-family:thaisansneue; color:rgb(50,150,50); font-size:18px;"><i class="glyphicon glyphicon-calendar"></i>พฤหัสบดีที่ 18 ธันวาคม 2557</p>
				                    	</li>

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
				                                        <i class="fa fa-retweet fa-fw"></i> 10 retweets                                        
				                                    </small>
				                                </div>
				                                <p>
				                                    กูไม่เคยเห็นการทำ "รัฐประหาร" แบบนี้ในโลกนี้! #นี่กูพูดจริงๆ  <a href="http://t.co/qu0RcBP7IJ" rel="nofollow">http://t.co/qu0RcBP7IJ</a>
				                                </p>
				                                <small class="text-muted">
				                                	<span class="glyphicon glyphicon-send"></span> Android
				                                    <i class="fa fa-clock-o fa-fw"></i> 4 months ago
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                	<span class="glyphicon glyphicon-send"></span> Web
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
				                                </small>                          
				                                <br>
				                                <small class="text-muted">
			                                    	<i class="fa fa-retweet fa-fw"></i> Retweeted by CpPanida
				                                	<span class="glyphicon glyphicon-send"></span> iPhone
				                                    <i class="fa fa-clock-o fa-fw"></i> about 2 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 7 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    เค้าไม่ได้รังเกียจไทย

				                                    แงงงงงงงงง

				                                    เค้าเกลียดการยึดอำนาจ เค้าเกลียดการรัฐประหาร เค้าเกลียดเผด็จการ แงงงงงง
				                                </p>
				                                <small class="text-muted">
				                                	<span class="glyphicon glyphicon-send"></span> iPhone
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
				                                </small>
				                            </div>
				                        </li>
				                        
				                        <li class="left clearfix">
				                    		<p style="font-family:thaisansneue; color:rgb(50,150,50); font-size:18px;"><i class="glyphicon glyphicon-calendar"></i>พุธที่ 17 ธันวาคม 2557</p>
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
				                                </small>
				                            </div>
				                        </li>

				                        <li class="left clearfix">			                        	
				                    		<p style="font-family:thaisansneue; color:rgb(50,150,50); font-size:18px;"><i class="glyphicon glyphicon-calendar"></i>อังคารที่ 16 ธันวาคม 2557</p>
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
				                                </small>
				                            </div>
				                        </li>
				                    </ul>						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1-2" style="font-size:20px;">2. สื่อมวลชน</a>
				                	<p class="pull-right">
					                	<i class="fa fa-comment fa-fw"></i> 55 tweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse1-2" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1-3" style="font-size:20px;">3. นักวิชาการ</a>
				                	<p class="pull-right">
					                	<i class="fa fa-comment fa-fw"></i> 55 tweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse1-3" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1-4" style="font-size:20px;">4. สำนักข่าว</a>
				                	<p class="pull-right">
					                	<i class="fa fa-comment fa-fw"></i> 55 tweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse1-4" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1-5" style="font-size:20px;">5. บุคคลทั่วไป</a>
				                	<p class="pull-right">
					                	<i class="fa fa-comment fa-fw"></i> 55 tweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse1-5" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>
				    </div>
            	</div>

            	<div class="tab-pane fade" id="p2">
            		<div class="panel-group" id="accordion2" style="font-family:thaisansneue; font-size:18px;">
				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion2" href="#collapse2-1" style="font-size:20px;">1. นักการเมือง</a>
				                    <p class="pull-right">
                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
                                    </p>
				                </h4>
				            </div>
				            <div id="collapse2-1" class="panel-collapse collapse">
				                <div class="panel-body">
				                	<ul class="chat" style="max-height: 500px; overflow-y: scroll;">

				                    	<li class="left clearfix">
				                    		<p style="font-family:thaisansneue; color:rgb(50,150,50); font-size:18px;"><i class="glyphicon glyphicon-calendar"></i>พฤหัสบดีที่ 18 ธันวาคม 2557</p>
				                    	</li>

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
				                                        <i class="fa fa-retweet fa-fw"></i> 10 retweets                                        
				                                    </small>
				                                </div>
				                                <p>
				                                    กูไม่เคยเห็นการทำ "รัฐประหาร" แบบนี้ในโลกนี้! #นี่กูพูดจริงๆ  <a href="http://t.co/qu0RcBP7IJ" rel="nofollow">http://t.co/qu0RcBP7IJ</a>
				                                </p>
				                                <small class="text-muted">
				                                	<span class="glyphicon glyphicon-send"></span> Android
				                                    <i class="fa fa-clock-o fa-fw"></i> 4 months ago
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                	<span class="glyphicon glyphicon-send"></span> Web
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
				                                </small>                          
				                                <br>
				                                <small class="text-muted">
			                                    	<i class="fa fa-retweet fa-fw"></i> Retweeted by CpPanida
				                                	<span class="glyphicon glyphicon-send"></span> iPhone
				                                    <i class="fa fa-clock-o fa-fw"></i> about 2 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 7 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    เค้าไม่ได้รังเกียจไทย

				                                    แงงงงงงงงง

				                                    เค้าเกลียดการยึดอำนาจ เค้าเกลียดการรัฐประหาร เค้าเกลียดเผด็จการ แงงงงงง
				                                </p>
				                                <small class="text-muted">
				                                	<span class="glyphicon glyphicon-send"></span> iPhone
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
				                                </small>
				                            </div>
				                        </li>
				                        
				                        <li class="left clearfix">
				                    		<p style="font-family:thaisansneue; color:rgb(50,150,50); font-size:18px;"><i class="glyphicon glyphicon-calendar"></i>พุธที่ 17 ธันวาคม 2557</p>
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
				                                </small>
				                            </div>
				                        </li>

				                        <li class="left clearfix">			                        	
				                    		<p style="font-family:thaisansneue; color:rgb(50,150,50); font-size:18px;"><i class="glyphicon glyphicon-calendar"></i>อังคารที่ 16 ธันวาคม 2557</p>
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
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
				                                        <i class="fa fa-retweet fa-fw"></i> 9 retweets
				                                    </small>
				                                </div>
				                                <p>
				                                    สื่อเยอรมันเรียกลุงว่าผู้นำรัฐประหาร EUไม่ยอมจัดประชุมทวิภาคีด้วย สรุป รัฐประหารไทยทำเศรษฐกิจทรุด และจะเลวร้ายลงอีก ..หลอกกันได้ไม่นานหรอก
				                                </p>
				                                <small class="text-muted">
				                                    <i class="fa fa-clock-o fa-fw"></i> about 9 hours ago                                    
				                                </small>
				                            </div>
				                        </li>
				                    </ul>						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion2" href="#collapse2-2" style="font-size:20px;">2. สื่อมวลชน</a>
				                	<p class="pull-right">
	                                    <i class="fa fa-retweet fa-fw"></i> 16 retweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse2-2" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion2" href="#collapse2-3" style="font-size:20px;">3. นักวิชาการ</a>
				                	<p class="pull-right">
	                                    <i class="fa fa-retweet fa-fw"></i> 16 retweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse2-3" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion2" href="#collapse2-4" style="font-size:20px;">4. สำนักข่าว</a>
				                	<p class="pull-right">
	                                    <i class="fa fa-retweet fa-fw"></i> 16 retweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse2-4" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion2" href="#collapse2-5" style="font-size:20px;">5. บุคคลทั่วไป</a>
				                	<p class="pull-right">
	                                    <i class="fa fa-retweet fa-fw"></i> 16 retweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse2-5" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>
				    </div>
            	</div>

            	<div class="tab-pane fade" id="p3">
            		<div class="panel-group" id="accordion3" style="font-family:thaisansneue; font-size:18px;">
				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion3" href="#collapse3-1" style="font-size:20px;">1. นักการเมือง</a>
				                    <p class="pull-right">
                                        <i class="fa fa-mail-reply fa-fw"></i> 9 retweets
                                    </p>
				                </h4>
				            </div>
				            <div id="collapse3-1" class="panel-collapse collapse">
				                <div class="panel-body">
				                	7777				                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion3" href="#collapse3-2" style="font-size:20px;">2. สื่อมวลชน</a>
				                	<p class="pull-right">
	                                    <i class="fa fa-mail-reply fa-fw"></i> 16 retweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse3-2" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion3" href="#collapse3-3" style="font-size:20px;">3. นักวิชาการ</a>
				                	<p class="pull-right">
	                                    <i class="fa fa-mail-reply fa-fw"></i> 16 retweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse3-3" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion3" href="#collapse3-4" style="font-size:20px;">4. สำนักข่าว</a>
				                	<p class="pull-right">
	                                    <i class="fa fa-mail-reply fa-fw"></i> 16 retweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse3-4" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>

				        <div class="panel panel-default">
				            <div class="panel-heading">
				                <h4 class="panel-title">
				                    <a data-toggle="collapse" data-parent="#accordion3" href="#collapse3-5" style="font-size:20px;">5. บุคคลทั่วไป</a>
				                	<p class="pull-right">
	                                    <i class="fa fa-mail-reply fa-fw"></i> 16 retweets
	                                </p>
				                </h4>
				            </div>
				            <div id="collapse3-5" class="panel-collapse collapse">
				                <div class="panel-body">
				                	6666						                    
				                </div>
				            </div>
				        </div>
				    </div>
            	</div>            	
            </div>


		    


		</div>	
	</div>
</div>

