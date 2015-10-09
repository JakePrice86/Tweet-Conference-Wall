<?php

/*
 * OPENSAUSE IS THE BESTEST
 *
 * Twitter API     	http://github.com/j7mbo/twitter-api-php
 * Flat File DB  	https://github.com/wylst/fllat
 * Pusher API  		https://github.com/pusher/pusher-http-php
 * Emoji's  		https://github.com/iamcal/php-emoji
 *
 * @created: 01/10/2015
 * @author: @jakelprice
 *
*/

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
date_default_timezone_set('Europe/London');

ini_set("display_errors", "1");
error_reporting(E_ALL);

require("twitter.php");
require("fllat.php");
require("pusher.php");

//-- Setup systems

//-- DB is in a writeable folder called db/ make sure it is created
//-- before you start :)
$pie = new Fllat("search");

//-- Twitter Settings
$settings = array(
	'oauth_access_token' 		=> "",
	'oauth_access_token_secret' => "",
	'consumer_key' 				=> "",
	'consumer_secret' 			=> ""
	);

//-- Pusher Settings
$pushers = array(
	'app_id' 					=> "",
	'app_key' 					=> "",
	'app_secret' 				=> "",
	);

//-- Hashtag to search
$search = "#hackference";

//-- Out main details
$main = array();

//-- Get Tweets
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=' . $search;
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest();

//-- Pusher time
$pusher = new Pusher( $pushers['app_key'], $pushers['app_secret'], $pushers['app_id'] );
$data 	= json_decode($response, true);

//-- Work out tweets
$tweets = array();
foreach($pie->select(array("id")) AS $n => $id) { $ids[] = $id['id']; }
foreach($data['statuses'] AS $n => $tweet) {

	if (!isset($tweet['retweeted_status'])) {

		//-- Check for duplicate
		if ((!in_array($tweet['id'], $ids, true)) || (isset($_GET['first']))) {

			$output = array();
			$output['text'] 	= $tweet['text'];
			$output['user'] 	= $tweet['user']['screen_name'];
			$output['avatar'] 	= $tweet['user']['profile_image_url'];
			$output['date'] 	= strtotime($tweet['created_at']);
			$tweets[] 			= $output;

			//-- Store ID, so we don't double show
			$datas = array("id" => $tweet['id']);
			$pie->add($datas);
		}
	}	

}

//-- Need to reverse the order of the tweets - fanks TWITTOR
if (count($tweets) > 0) { 
	usort($tweets, function($a, $b) { return $a['date'] - $b['date']; });
}

//-- Add to main array
$main['tweets'] = $tweets;

/*
	Speaker Array

	Organised into tracks (as arrays) so that the system can grab them based on the timestart and timeend.

*/

$track1 = array(
			array(
				'timestart' => '5:30 am',
				'timeend' => '10:00 am',
				'name' => "Rob Spectre", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/rob_spectre.png", 
				'talk' => "With Great Power", 
				'info' => "Track 1: 9:30am - 10:10am"
			),
			array(
				'timestart' => '9:59 am',
				'timeend' => '11:00 am',
				'name' => "Callum Hopkins", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/callum_hopkins.png", 
				'talk' => "The Importance of Side Projects", 
				'info' => "Track 1: 10:30am - 11:10am"
			),
			array(
				'timestart' => '10:59 am',
				'timeend' => '12:00 pm',
				'name' => "Tim Messerschmidt", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/tim_messerschmidt.png", 
				'talk' => "Death to Passwords", 
				'info' => "Track 1: 11:30am - 12:10am"
			),
			array(
				'timestart' => '11:59 am',
				'timeend' => '1:00 pm',
				'name' => "Phil Leggetter", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/phil_leggetter.png", 
				'talk' => "Why You Should be Using Web Components Right Now. And How.", 
				'info' => "Track 1: 12:30am - 1:10pm"
			),
			array(
				'timestart' => '12:59 pm',
				'timeend' => '2:30 pm',
				'name' => "Nicolas Grenié", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/nicolas_grenie.png", 
				'talk' => "Connecting and managing Micro-services", 
				'info' => "Track 1: 2:00pm - 2:40pm"
			),
			array(
				'timestart' => '2:29 pm',
				'timeend' => '3:30 pm',
				'name' => "Etiene Dalcol", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/etiene_dalcol.jpg", 
				'talk' => "What I learned teaching programming to 150 young women", 
				'info' => "Track 1: 3:00pm - 3:40pm"
			),
			array(
				'timestart' => '3:29 pm',
				'timeend' => '4:30 pm',
				'name' => "Ruth John", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/ruth_john.png", 
				'talk' => "A Journey Through Browser API Space & Time", 
				'info' => "Track 1: 4:00pm - 4:40pm"
			),
			array(
				'timestart' => '4:29 pm',
				'timeend' => '5:30 pm',
				'name' => "Robin Johnson", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/robin_johnson.jpg", 
				'talk' => "The Value of Open Source", 
				'info' => "Track 1: 5:00pm - 5:40pm"
			)
		);


$track2 = array(
			array(
				'timestart' => '5:30 am',
				'timeend' => '11:00 am',
				'name' => "Dan Jenkins", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/dan_jenkins.png", 
				'talk' => "WebRTC Reborn", 
				'info' => "Track 2: 10:30am - 11:10am"
			),
			array(
				'timestart' => '10:59 am',
				'timeend' => '12:00 pm',
				'name' => "Simon Tabor", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/simon_tabor.png", 
				'talk' => "Super-Scalable Redis for Fun and Profit!", 
				'info' => "Track 2: 11:30am - 12:10am"
			),
			array(
				'timestart' => '11:59 am',
				'timeend' => '1:00 pm',
				'name' => "Melinda Seckington", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/melinda_seckington.png", 
				'talk' => "How and Why We Run Internal Hackdays", 
				'info' => "Track 2: 12:30am - 1:10pm"
			),
			array(
				'timestart' => '12:59 pm',
				'timeend' => '2:30 pm',
				'name' => "Jonathan Kingsley", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/jonathan_kingsley.jpg", 
				'talk' => "Fireworks As A Service: Building IoT devices with a Boom", 
				'info' => "Track 2: 2:00pm - 2:40pm"
			),
			array(
				'timestart' => '2:29 pm',
				'timeend' => '3:30 pm',
				'name' => "Sam Phippen", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/sam_phippen.png", 
				'talk' => "Single Page Web Apps don't work, reprise", 
				'info' => "Track 2: 3:00pm - 3:40pm"
			),
			array(
				'timestart' => '3:29 pm',
				'timeend' => '4:30 pm',
				'name' => "Tim Perry", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/tim_perry.png", 
				'talk' => "Your Web Stack Would Betray You In An Instant", 
				'info' => "Track 2: 4:00pm - 4:40pm"
			),
			array(
				'timestart' => '4:29 pm',
				'timeend' => '5:30 pm',
				'name' => "Hugh Rawlinson", 
				'avatar' => "http://2015.hackference.co.uk/assets/speaker/hugh_rawlinson.png", 
				'talk' => "Javascript and Music: A tale of many scary noises", 
				'info' => "Track 2: 5:00pm - 5:40pm"
			)
		);

$workshops = array(
				array(
					'timestart' => '5:30 am',
					'timeend' =>  '1:00 pm',
					'name' => "Martin Beeby & Martin Kearn", 
					'avatar' => "http://2015.hackference.co.uk/assets/speaker/martin_beeby.jpg", 
					'talk' => "Web Performance & Compatibility Lab", 
					'info' => "Workshop: 11:30am - 1:10pm"
				),
				array(
					'timestart' => '12:59 pm',
					'timeend' => '3:30 pm',
					'name' => "John Stevenson", 
					'avatar' => "http://2015.hackference.co.uk/assets/speaker/john_stevenson.png", 
					'talk' => "Getting started with Clojure", 
					'info' => "Track 2: 2:00pm - 3:40pm"
				),
				array(
					'timestart' => '3:29 pm',
					'timeend' => '5:30 pm',
					'name' => "Lightning Talks", 
					'avatar' => "http://s.hswstatic.com/gif/lightning-gallery-18.jpg", 
					'talk' => "Lightning Talks", 
					'info' => "Track 2: 4:00pm - 5:00pm"
				),
			);

if (isset($_GET['time'])) {
	$t = $_GET['time'];
} else {
	$t = date("H:i");
}

//-- Lets grab the current tracks
foreach($track1 AS $track) {
	$me = checkUnixTime( $track['timeend'],  $track['timestart'], $t);
	if ($me) {
		$main['track1'] = $track;
		break;
	}
}

foreach($track2 AS $track) {
	$me = checkUnixTime( $track['timeend'],  $track['timestart'], $t);
	if ($me) {
		$main['track2'] = $track;
		break;
	}
}

foreach($workshops AS $track) {
	$me = checkUnixTime( $track['timeend'],  $track['timestart'], $t);
	if ($me) {
		$main['workshop'] = $track;
		break;
	}
}

function checkUnixTime($to, $from, $input) {

    if (strtotime($input) > strtotime($from) && strtotime($input) < strtotime($to)) {
        return true;
    }
}

//-- Output $main
echo json_encode($main);