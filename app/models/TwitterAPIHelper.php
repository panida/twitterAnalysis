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
}