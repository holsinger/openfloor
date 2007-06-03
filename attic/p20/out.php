<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// The Pligg Team <pligger at pligg dot com>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'pageview.php');

$requestID = $_REQUEST['id'];
$requestTitle = $_REQUEST['title'];
$requestURL = $_REQUEST['url'];

if(isset($requestTitle)){
	$requestID = $db->get_var("SELECT link_id FROM " . table_links . " WHERE `link_title_url` = '$requestTitle';");
}

if(isset($requestURL)){
	$requestID = $db->get_var("SELECT link_id FROM " . table_links . " WHERE `link_url` = '$requestURL';");
}

if(is_numeric($requestID)) {
	$id = $requestID;
	$link = new Link;
	$link->id=$requestID;
	$link->read();

	$pageview = new Pageview;
	$pageview->type='out';
	$pageview->page_id=$link->id;
	$pageview->user_id=$current_user->user_id;
	require_once(mnminclude.'check_behind_proxy.php');
	$pageview->user_ip=check_ip_behind_proxy();
	$pageview->insert();

	header("HTTP/1.1 301 Moved Permanently");
	header('Location: '. $link->url);
	//echo $link->url;

}

?>