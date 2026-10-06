<?php

isset($_GET['usegrouptoken']) ? $usegrouptoken = $_GET['usegrouptoken'] : $usegrouptoken = false;

include('connect.php');

//Use either object ID or post ID
( $_GET['use_id'] == 'object' ) ? $use_object_id = true : $use_object_id = false;
( isset($_GET['o_id']) ) ? $object_id = $_GET['o_id'] : $object_id = '';
( isset($_GET['post_id']) ) ? $post_id = $_GET['post_id'] : $post_id = '';

//Check whether it's a timeline album/video as they require different rules
( isset($_GET['timelinealbum']) ) ? $timelinealbum = $_GET['timelinealbum'] : $timelinealbum = false;
( isset($_GET['isvideo']) ) ? $isvideo = $_GET['isvideo'] : $isvideo = false;

//If it's a group then just use the post ID
if( $usegrouptoken || $isvideo ) $use_object_id = false;

( $use_object_id ) ? $id = $object_id : $id = $post_id;

//How many comments does this post have?
( isset($_GET['comments_num']) ) ? $comments_num = intval($_GET['comments_num']) : $comments_num = 0;
( isset($_GET['likes_num']) ) ? $likes_num = intval($_GET['likes_num']) : $likes_num = 0;

//Which meta type should we query?
( isset($_GET['type']) ) ? $metaType = $_GET['type'] : $metaType = '';

//Make the API request to get the data from Facebook
function api_call($id, $likes, $reactions, $images, $access_token){
	$json_object = cff_fetchUrl("https://graph.facebook.com/v2.8/" . $id . "/?fields=".$likes."comments.summary(true){id,from,message,message_tags,created_time,like_count,comment_count,attachment{media}}".$reactions.$images."&access_token=" . $access_token);
	
	return $json_object;
}


if( $metaType == 'meta' ){

	//If there's an object ID then request the full size images
	( $use_object_id ) ? $images = ",images" : $images = '';

	$reactions = ",reactions.type(LOVE).summary(total_count).limit(0).as(love),reactions.type(WOW).summary(total_count).limit(0).as(wow),reactions.type(HAHA).summary(total_count).limit(0).as(haha),reactions.type(SAD).summary(total_count).limit(0).as(sad),reactions.type(ANGRY).summary(total_count).limit(0).as(angry)";

	$likes = "likes.summary(true).limit(3){id,name},";

	//If it's a timeline event then don't request reactions or images
	isset($_GET['timeline_event']) ? $timeline_events = true : $timeline_events = false;
	if( $timeline_events ){
		$reactions = "";
		$likes = "";
		$images = "";
	}

	$json_object = api_call($id, $likes, $reactions, $images, $access_token);

	//If no comments were returned for the object ID but there should be some then make another request using the Post ID instead to get the comments
	$first_response_json = json_decode($json_object);


	//If there's no comments/likes data available in the object ID request then make a second request using the Post ID to get the comments/likes
	//The likes check only applies to timeline album posts as they're the only ones that don't return the likes in the first request. Other post types do.
	if( ( $use_object_id && $comments_num > 0 && ( !isset($first_response_json->comments) || empty($first_response_json->comments->data) ) ) || ( $timelinealbum && ( $use_object_id && $likes_num > 0 && ( !isset($first_response_json->likes) || empty($first_response_json->likes->data) ) ) ) ){
		$second_response = api_call($post_id, $likes, $reactions, '', $access_token);

		//Add the images from the original response to the full comments/likes/reactions data in the second response and return
		$second_response_json = json_decode($second_response);

		//If it's a timeline album post then the "images" field doesn't exist in the second response so create it
		if( $timelinealbum ) $second_response_json->images = $first_response_json->images;

		if( isset($second_response_json->images) ) $second_response_json->images = $first_response_json->images;
		$json_object = json_encode($second_response_json);
	}

	echo $json_object;
	
}

?>