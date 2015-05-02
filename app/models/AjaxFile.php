<?php

class AjaxFile
{		
	public static function generateTimelineFile($timestamp,$timelineList,$writeMode){
		$filenameTimeline = 'timeline'.$timestamp.'.txt';
        $file = fopen(public_path().'/ajaxFile/'.$filenameTimeline,$writeMode);
		$nowdate = NULL;
		foreach($timelineList as $key=>$aTweet){
			if($writeMode=="w") $pageNo = floor($key/20);
			else $pageNo = 50+floor($key/20);
            if($key==0 or $nowdate!==$aTweet->thedate){
				$nowdate = $aTweet->thedate;
				fwrite($file,
				'<li class="left clearfix timelineP'.$pageNo.'">
        			<p style="font-family:thaisansneue; color:rgb(50,150,50); font-size:18px;"><i class="glyphicon glyphicon-calendar"></i>'.$aTweet->nameday." ".$aTweet->date." ".$aTweet->month." ".$aTweet->year.'</p>
        		</li>'
        		);
			}
			fwrite($file,
				'<li class="left clearfix timelineP'.$pageNo.'">
                    <span class="chat-img pull-left">
                        <a href="http://twitter.com/'.$aTweet->original_screenname.'" target="blank" class="tweet_avatar2">
                            <img src="'.$aTweet->original_pic.'" alt="'.$aTweet->original_screenname.'" class="avatar" onerror="if (this.src != \'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png\') this.src = \'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png\';">
                        </a>
                    </span>
                    <div class="chat-body clearfix">
                        <div class="header">
                            <strong class="primary-font"><a href="http://twitter.com/'.$aTweet->original_screenname.'" target="blank" class="tweet_screen_name2 screen_name">'.$aTweet->original_name.'</a></strong> 
                            <span style="color:#AAAAAA;">@'.$aTweet->original_screenname.'</span>
                        </div>
                        <p>'.
                            $aTweet->original_text.
                        '</p>
                        <small class="text-muted">
                            <span class="glyphicon glyphicon-send"></span>'.$aTweet->original_sourcename.'
                            <i class="fa fa-clock-o fa-fw"></i>'.$aTweet->original_created_at.
                        '</small>'
			);               			
			if($aTweet->real_activitytypekey==3){
				fwrite($file,
					'<br>
                    <small class="text-muted">
                    	<i class="fa fa-retweet fa-fw"></i> Retweeted by <a href="http://twitter.com/'.$aTweet->real_screenname.'" target="blank" class="tweet_screen_name2 screen_name" style="color:rgb(100,100,100)">'.$aTweet->real_screenname.'</a>
                    	<span class="glyphicon glyphicon-send"></span>'.$aTweet->real_sourcename.
                        '<i class="fa fa-clock-o fa-fw"></i>'.$aTweet->real_created_at.                                
                    '</small>'
				);
				
			}
			fwrite($file,  '</div>
			            </li>');                               					                          
		}
		fclose($file);
		return $filenameTimeline;
	}

	public static function generateTopRetweetedFileSearchByText($timestamp,$topRetweetedList,$writeMode){
		$filenameTopRetweetedList = 'topRetweetedList'.$timestamp.'.txt';
        $file = fopen(public_path().'/ajaxFile/'.$filenameTopRetweetedList,$writeMode);
		$key = 0;
		foreach($topRetweetedList as $anOriginalTweet){
            if($writeMode=="w") $pageNo = floor($key/20);
            else $pageNo = 50+floor($key/20);			
			fwrite($file,
				'<li class="left clearfix topRetweetedP'.$pageNo.'">
                    <span class="chat-img pull-left">
                        <a href="http://twitter.com/'.$anOriginalTweet->original_screenname.'" target="blank" class="tweet_avatar2">
                            <img src="'.$anOriginalTweet->original_pic.'" alt="'.$anOriginalTweet->original_screenname.'" class="avatar" onerror="if (this.src != \'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png\') this.src = \'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png\';">
                        </a>
                    </span>
                    <div class="chat-body clearfix">
                        <div class="header">
                            <strong class="primary-font"><a href="http://twitter.com/'.$anOriginalTweet->original_screenname.'" target="blank" class="tweet_screen_name2 screen_name">'.$anOriginalTweet->original_name.'</a></strong> 
                            <span style="color:#AAAAAA;">@'.$anOriginalTweet->original_screenname.'</span>
                            <small class="pull-right text-muted">
                                <i class="fa fa-retweet fa-fw"></i> '.number_format($anOriginalTweet->totalRetweet).' retweets                                      
                            </small>
                        </div>
                        <p>'.
                            $anOriginalTweet->original_text.
                        '</p>
                        <small class="text-muted">
                            <span class="glyphicon glyphicon-send"></span>'.$anOriginalTweet->original_sourcename.
                            '<i class="fa fa-clock-o fa-fw"></i>'.$anOriginalTweet->original_created_at.
                        '</small>
                    </div>
                </li>'     
			); 
			$key+=1;     	                                           					                          
		}
		fclose($file);
		return $filenameTopRetweetedList;
	}

	public static function generateTopFollowerFile($timestamp,$topFollowerList,$writeMode){
		$filenameTopFollowerList = 'topFollowerList'.$timestamp.'.txt';
        $file = fopen(public_path().'/ajaxFile/'.$filenameTopFollowerList,$writeMode);
		$key = 0;
		foreach($topFollowerList as $aTweet){
			if($writeMode=="w") $pageNo = floor($key/20);
            else $pageNo = 50+floor($key/20);			
			fwrite($file,
				'<li class="left clearfix topFollowerP'.$pageNo.'">
                    <span class="chat-img pull-left">
                        <a href="http://twitter.com/'.$aTweet->original_screenname.'" target="blank" class="tweet_avatar2">
                            <img src="'.$aTweet->original_pic.'" alt="'.$aTweet->original_screenname.'" class="avatar" onerror="if (this.src != \'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png\') this.src = \'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png\';">
                        </a>
                    </span>
                    <div class="chat-body clearfix">
                        <div class="header">
                            <strong class="primary-font"><a href="http://twitter.com/'.$aTweet->original_screenname.'" target="blank" class="tweet_screen_name2 screen_name">'.$aTweet->original_name.'</a></strong> 
                            <span style="color:#AAAAAA;">@'.$aTweet->original_screenname.'</span>
                            <small class="pull-right text-muted">
                            	<i class="fa fa-users fa-fw"></i> '.number_format($aTweet->real_no_of_follower).' followers  
                            </small>
                        </div>
                        <p>'.
                            $aTweet->original_text.
                        '</p>
                        <small class="text-muted">
                            <span class="glyphicon glyphicon-send"></span>'.$aTweet->original_sourcename.
                            '<i class="fa fa-clock-o fa-fw"></i>'.$aTweet->original_created_at.
                        '</small>' 
			); 
			if($aTweet->real_activitytypekey==3){
			fwrite($file,
				'<br>
                <small class="text-muted">
                	<i class="fa fa-retweet fa-fw"></i> Retweeted by <a href="http://twitter.com/'.$aTweet->real_screenname.'" target="blank" class="tweet_screen_name2 screen_name" style="color:rgb(100,100,100)">'.$aTweet->real_screenname.'</a>
                	<span class="glyphicon glyphicon-send"></span>'.$aTweet->real_sourcename.
                    '<i class="fa fa-clock-o fa-fw"></i>'.$aTweet->real_created_at.                                 
                '</small>'
				);
			}
			fwrite($file,  '</div>
			            </li>');  
			$key+=1;     	                                           					                          
		}
		fclose($file);
		return $filenameTopFollowerList;
	}

	public static function generateTopRetweetedFileSearchByUser($timestamp,$topRetweetedList){
		$filenameTopRetweetedList = 'topRetweetedList'.$timestamp.'.txt';
        $file = fopen(public_path().'/ajaxFile/'.$filenameTopRetweetedList,"w");
		$key = 0;
		foreach($topRetweetedList as $anOriginalTweet){
			$pageNo = floor($key/20);			
			fwrite($file,
   				'<li class="left clearfix topRetweetedP'.$pageNo.'">
                    <span class="chat-img pull-left">
                        <a href="http://twitter.com/'.$anOriginalTweet->screenname.'" target="blank" class="tweet_avatar2">
                            <img src="'.$anOriginalTweet->pic.'" alt="'.$anOriginalTweet->screenname.'" class="avatar" onerror="if (this.src != \'http://a0.twimg.com/sticky/default_profile_images/default_profile_6_normal.png\') this.src = \'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png\';">
                        </a>
                    </span>
                    <div class="chat-body clearfix">
                        <div class="header">
                            <strong class="primary-font"><a href="http://twitter.com/'.$anOriginalTweet->screenname.'" target="blank" class="tweet_screen_name2 screen_name">'.$anOriginalTweet->name.'</a></strong> 
                            <span style="color:#AAAAAA;">@'.$anOriginalTweet->screenname.'</span>
                            <small class="pull-right text-muted">
                                <i class="fa fa-retweet fa-fw"></i> '.number_format($anOriginalTweet->totalRetweet-1). ' retweets                                     
                            </small>
                        </div>
                        <p>'.
                            $anOriginalTweet->text.
                        '</p>
                        <small class="text-muted">
                            <span class="glyphicon glyphicon-send"></span>'.$anOriginalTweet->sourcename.
                            '<i class="fa fa-clock-o fa-fw"></i>'.$anOriginalTweet->created_at.
                        '</small>
                    </div>
                </li>'
			); 
			$key+=1;     	                                           					                          
		}
		fclose($file);
		return $filenameTopRetweetedList;
	}

}