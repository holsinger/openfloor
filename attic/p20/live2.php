<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('config.php');
include(mnminclude.'link.php');

$max_items = items_to_show;

if(!($time=check_integer('time'))) {
	$time = 0;
} 

header('Content-Type: text/plain; charset=UTF-8');

$last_timestamp = 0;

get_votes($time);
get_new_stories($time);
get_new_published($time);
get_comments($time);

if($last_timestamp == 0) $last_timestamp = time();

echo "timestamp=$last_timestamp;\n";
if(count($events) < 1) exit;
ksort($events);
$keys = array_reverse(array_keys($events));
$lines = min(count($keys), $max_items);

$counter=0;
echo "new_items=$lines;\n";
echo "new_data = ([";
foreach ($keys as $key) {
	echo "{" . $events[$key] . "}, ";
	$counter++;
	if($counter>=$max_items) {
		echo "]);";
		exit();
	}
}
echo "]);";


// Check last votes
function get_votes($time) {
	global $db, $events, $last_timestamp;
	$res = $db->get_results("select vote_id, unix_timestamp(vote_date) as timestamp, vote_value, vote_ip, vote_user_id, link_id, link_title, link_url, link_status, link_date, link_published_date, link_votes, link_author from " . table_votes . ", " . table_links . " where vote_date > from_unixtime($time) and link_id = vote_link_id and vote_user_id != link_author and link_status!='discard' and vote_type = 'links' order by vote_date desc limit 20");
	if (!$res) return;
	foreach ($res as $event) {
		if(substr($event->vote_ip, 0, 3) != '0.0'){
			$id=$event->vote_id;
			$uid = $event->vote_user_id;
			if($uid > 0) {
				$user = $db->get_var("select user_login from " . table_users . " where user_id = $uid");
			} else {
				$user= preg_replace('/\.[0-9]+$/', '', $event->vote_ip);
			}
			if ($event->vote_value >= 0) {
				$type = 'vote';
				$who = $user;
			} else { 
				$type = 'problem';
				$who = get_negative_vote($event->vote_value);
			}
			$status =  get_status($event->link_status);
			$key = $event->timestamp . ':votes:'.$id;
			$events[$key] = 'ts:"'.$event->timestamp.'", type:"'.$type.'", votes:"'.$event->link_votes.'", link:"'.$event->link_id.'", title:"'.addslashes($event->link_title).'", who:"'.addslashes($who).'", status:"'.$status.'", uid:"'.$uid.'"';
			//echo "($key)". $events[$key];
			if($event->timestamp > $last_timestamp) $last_timestamp = $event->timestamp;
		}
	}
}


function get_new_stories($time) {
	global $db, $events, $last_timestamp;
	$res = $db->get_results("select unix_timestamp(link_date) as timestamp, user_login, link_author, link_id, link_title, link_url, link_status, link_date, link_votes from " . table_links . ", " . table_users . " where link_status='queued' and  link_date > from_unixtime($time) and user_id=link_author order by link_date desc limit 20");
	if (!$res) return;
	foreach ($res as $event) {
		$id=$event->link_id;
		$uid = $event->link_author;
		$type = 'new';
		$who = $event->user_login;
		$status =  get_status($event->link_status);
		$key = $event->timestamp . ':new:'.$id;
		$events[$key] = 'ts:"'.$event->timestamp.'", type:"'.$type.'", votes:"'.$event->link_votes.'", link:"'.$event->link_id.'", title:"'.addslashes($event->link_title).'", who:"'.addslashes($who).'", status:"'.$status.'", uid:"'.$uid.'"';
		//echo "($key)". $events[$key];
		if($event->timestamp > $last_timestamp) $last_timestamp = $event->timestamp;
	}
}


function get_new_published($time) {
	global $db, $events, $last_timestamp;
	$res = $db->get_results("select unix_timestamp(link_published_date) as timestamp, user_login, link_author, link_id, link_title, link_url, link_status, link_date, link_votes from " . table_links . ", " . table_users . " where link_status='published' and link_published_date > from_unixtime($time) and user_id=link_author order by link_published_date desc limit 20");
	if (!$res) return;
	foreach ($res as $event) {
		$id=$event->link_id;
		$uid = $event->link_author;
		$type = 'published';
		$who = $event->user_login;
		$status =  get_status($event->link_status);
		$key = $event->timestamp . ':published:'.$id;
		$events[$key] = 'ts:"'.$event->timestamp.'", type:"'.$type.'", votes:"'.$event->link_votes.'", link:"'.$event->link_id.'", title:"'.addslashes($event->link_title).'", who:"'.addslashes($who).'", status:"'.$status.'", uid:"'.$uid.'"';
		//echo "($key)". $events[$key];
		if($event->timestamp > $last_timestamp) $last_timestamp = $event->timestamp;
	}
}

function get_comments($time) {
	global $db, $events, $last_timestamp;
	$res = $db->get_results("select comment_id, unix_timestamp(comment_date) as timestamp, user_login, comment_user_id, link_author, link_id, link_title, link_url, link_status, link_date, link_published_date, link_votes from " . table_comments . ", " . table_links . ", " . table_users . " where comment_date > from_unixtime($time) and link_id = comment_link_id and link_status!='discard' and user_id=comment_user_id order by comment_date desc limit 20");
	if (!$res) return;
	foreach ($res as $event) {
		$id=$event->comment_id;
		$uid=$event->comment_user_id;
		$type = 'comment';
		$who = $event->user_login;
		$status =  get_status($event->link_status);
		$key = $event->timestamp . ':comment:'.$id;
		$events[$key] = 'ts:"'.$event->timestamp.'", type:"'.$type.'", votes:"'.$event->link_votes.'", link:"'.$event->link_id.'", title:"'.addslashes($event->link_title).'", who:"'.addslashes($who).'", status:"'.$status.'", uid:"'.$uid.'"';
		//echo "($key)". $events[$key];
		if($event->timestamp > $last_timestamp) $last_timestamp = $event->timestamp;
	}
}

function get_negative_vote($value) {
	switch ($value) {
		case -2: 
			$who = _('dupe');
			break;
		case -3: 
			$who = _('bad link');
			break;
		case -4: 
			$who = _('spam');
			break;
		case -5: 
			$who = _('old news');
			break;
		case -6: 
			$who = _('lame');
			break;
		default:
			$who = "error";
	}
	return $who;
}

function get_status($status) {
	switch ($status) {
		case 'published':
			$status = _('published');
			break;
		case 'queued':
			$status = _('queued');
			break;
		case 'discard':
			$status = _('discard');
			break;
	}
	return $status;
}


function error($mess) {
	header('Content-Type: text/plain; charset=UTF-8');
	echo "ERROR: $mess";
	die;
}
?>