<?php

// require './twitterAPIResource/tmhOAuth.php';
// require './twitterAPIResource/tmhUtilities.php';

class TwitterAPIHelper
{		
	public static function getUserInfo($screenName){
		$tmhOAuth = new tmhOAuth(array(
			'consumer_key'    => '0LRwCUJKeY7PRmwLsrPYRh6Cm',
			'consumer_secret' => 'AMrh3UX7C5voB1rXHbsAIm1VtbUi5CDDvgS4jTUCvlDwS4cMEi',
			'user_token'      => '2578760185-31Fqd6x9DeXfR63n6HsrAAR2Bkrho86ROSZp76V',
			'user_secret'     => '9n2upQxbaZ5gRhKkOoJFghBdqJVW2KHfIKyZdqIviRLQZ',
		));
		$method = 'https://api.twitter.com/1.1/users/show.json';
		$params = array(
			'screen_name'     => $screenName,
	
		);
		$code = $tmhOAuth->request('GET', $method, $params);
		$result = [];
		if($code == 200){
			//$result = $tmhOAuth;
			$result = json_decode($tmhOAuth->response["response"], true);
		}
		return $result;
	}

	public static function getFollowerList($screenName){
		$tmhOAuth = new tmhOAuth(array( //SentimentalAnalysisPLJ
			'consumer_key'    => 'i9pHzDah2pnbilcbrDCwGe4yJ',
			'consumer_secret' => '3gMfAaoiuU6fCZ1S6Do1fEiJyh2aXg9BegXTcueHqjIetMte4A',
			'user_token'      => '2580204614-hnXjdGIAHyKxk0zDVWg3g3YYBcJt2HddfgL954P',
			'user_secret'     => 'jay5YL9ufdECpRRyEB1Gyhx16R6ZPwzJISWVJIEDGpyv2',
		));
		// $tmhOAuth = new tmhOAuth(array(//chompoo
		// 	'consumer_key'    => '0LRwCUJKeY7PRmwLsrPYRh6Cm',
		// 	'consumer_secret' => 'AMrh3UX7C5voB1rXHbsAIm1VtbUi5CDDvgS4jTUCvlDwS4cMEi',
		// 	'user_token'      => '2578760185-31Fqd6x9DeXfR63n6HsrAAR2Bkrho86ROSZp76V',
		// 	'user_secret'     => '9n2upQxbaZ5gRhKkOoJFghBdqJVW2KHfIKyZdqIviRLQZ',
		// ));
		$method = 'https://api.twitter.com/1.1/followers/list.json';
		$params = array(
			'screen_name'     => $screenName,
			'count'			  => 50	
		);
		$code = $tmhOAuth->request('GET', $method, $params);
		$result = [];
		if($code == 200){
			//$result = $tmhOAuth;
			$result = json_decode($tmhOAuth->response["response"], true)['users'];
		}
		return $result;
	}

	public static function find_followee($userkey,$screenname,$cursor){
		$tmhOAuth = new tmhOAuth(array( //SentimentalAnalysisPLJ
			'consumer_key'    => '0LRwCUJKeY7PRmwLsrPYRh6Cm',
			'consumer_secret' => 'AMrh3UX7C5voB1rXHbsAIm1VtbUi5CDDvgS4jTUCvlDwS4cMEi',
			'user_token'      => '2578760185-31Fqd6x9DeXfR63n6HsrAAR2Bkrho86ROSZp76V',
			'user_secret'     => '9n2upQxbaZ5gRhKkOoJFghBdqJVW2KHfIKyZdqIviRLQZ',
		));
		$method = 'https://api.twitter.com/1.1/friends/ids.json';
		$params = array(
			'screen_name'     => $screenname,
			'cursor'		  => intval($cursor),
			'stringify_ids'	  => true
	
		);
		$code = $tmhOAuth->request('GET', $method, $params);
		$result = [];
		if($code == 200){
			//$result = $tmhOAuth;
			$result = json_decode($tmhOAuth->response["response"], true);
		}
		return $result;
	}
}