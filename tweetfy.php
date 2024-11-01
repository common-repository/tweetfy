<?php 
/*
Plugin Name: Tweetfy
Plugin URI: http://filipekiss.com.br/wordpress/tweetfy/
Description: Automatically convert twitter usernames and hashtags to Twitter links
Version: 1.1.0
Author: Filipe Kiss
Author URI: http://filipekiss.com.br/
*/

function tweetfy ( $text ){
	
	$ret = ' ' . $text;
    $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a target=\"_blank\" rel=\"nofollow\" href=\"\\2\" >\\2</a>'", $ret);
    $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a target=\"_blank\" rel=\"nofollow\" href=\"http://\\2\" >\\2</a>'", $ret);
		
    #Find Twitter Usernames
    $twitter = "/([^&A-Za-z0-9\.\-\"])@([A-Za-z0-9_]+)/is";
    $ret = preg_replace ($twitter, "$1"."<a href=\"http://www.twitter.com/"."$2"."\">@"."$2"."</a>", $ret);

    #Find Hashtags
    $hashtag = "/([^&A-Za-z0-9\.\-\"])#((?!more-[0-9]+)[A-Aa-z0-9_-]+)/is";
    $ret = preg_replace ($hashtag, "$1"."<a href=\"https://twitter.com/#!/search/"."$2"."\">#"."$2"."</a>", $ret);
	
    return $ret;
	
} 

add_filter( 'the_content', 'tweetfy', 99, 1 );
add_filter( 'the_excerpt', 'tweetfy', 99, 1 );