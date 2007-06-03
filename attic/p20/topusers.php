<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'ts.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

// -------------------------------------------------------------------------------------

$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_TopUsers');
$navwhere['link1'] = getmyurl('topusers', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_TopUsers'));

$range_names  = array( _(PLIGG_Visual_TopUsers_Range_All), _(PLIGG_Visual_TopUsers_Range_24Hours), _(PLIGG_Visual_TopUsers_Range_ThisWeek), _(PLIGG_Visual_TopUsers_Range_ThisMonth), _(PLIGG_Visual_TopUsers_Range_ThisYear));
$range_values = array(0, 86400, 604800, 2592000, 31536000);

$offset=(get_current_page()-1)*$top_users_size;

$items = array($main_smarty->get_config_vars('PLIGG_Visual_TopUsers_TH_User'), $main_smarty->get_config_vars('PLIGG_Visual_TopUsers_TH_News'), $main_smarty->get_config_vars('PLIGG_Visual_TopUsers_TH_PublishedNews'), $main_smarty->get_config_vars('PLIGG_Visual_TopUsers_TH_Comments'), $main_smarty->get_config_vars('PLIGG_Visual_TopUsers_TH_TotalVotes'), $main_smarty->get_config_vars('PLIGG_Visual_TopUsers_TH_PublishedVotes'));

if(isset($_GET['sortby'])){
	$sortby = $_GET['sortby'];}
else{
	$sortby = "0";}
	
if(intval($sortby) < 0 || intval($sortby) > 5) 
	$sortby = 4;
else $sortby = intval($sortby); // Be safe, always!!!!

switch ($sortby) {
	case 0:
		$select = "SELECT user_id, count(*) as count ";
		$from_where = " FROM " . table_links . ", " . table_users . " WHERE  link_status != 'discard' AND link_author=user_id GROUP BY link_author";
		$order_by = " ORDER BY count DESC ";
		break;
	case 1:
		$select = "SELECT user_id, count(*) as count ";
		$from_where = " FROM " . table_links . ", " . table_users . " WHERE  link_status != 'discard' AND link_author=user_id GROUP BY link_author";
		$order_by = " ORDER BY count DESC ";
		break;
	case 2:
		$select = "SELECT user_id, count(*) as count ";
		$from_where = " FROM " . table_links . ", " . table_users . " WHERE  link_status = 'published' AND link_author=user_id GROUP BY link_author";
		$order_by = " ORDER BY count DESC ";
		break;
	case 3:
		$select = "SELECT user_id, count(*) as count ";
		$from_where = " FROM " . table_comments . ", " . table_users . " WHERE comment_user_id=user_id GROUP BY comment_user_id";
		$order_by = " ORDER BY count DESC ";
		break;
	case 4:
		$select = "SELECT user_id, count(*) as count ";
		$from_where = " FROM " . table_votes . ", " . table_users . " WHERE vote_user_id=user_id GROUP BY vote_user_id";
		$order_by = " ORDER BY count DESC ";
		break;
	case 5:
		$select = "SELECT user_id, count(*) as count ";
		$from_where = " FROM " . table_votes . ", " . table_users . ", " . table_links . " WHERE vote_user_id=user_id AND link_id=vote_link_id AND link_status='published' AND vote_date < link_published_date GROUP BY user_id";
		$order_by = " ORDER BY count DESC ";
		break;
}
// Sort by votes

define('pagename', 'topusers'); 
$main_smarty->assign('pagename', pagename);

$main_smarty = do_sidebar($main_smarty);

$main_smarty->assign('tpl_center', $the_template . '/topusers_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>