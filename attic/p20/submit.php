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
include(mnminclude.'smartyvariables.php');

$main_smarty->assign('Story_Content_Tags_To_Allow', htmlspecialchars(Story_Content_Tags_To_Allow));

$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Submit');
$navwhere['link1'] = getmyurl('submit', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Submit'));
$main_smarty = do_sidebar($main_smarty);

force_authentication();

//this is for direct links from weblogs
if(empty($_POST['phase']) && !empty($_GET['url'])) {
	$_POST['phase'] = 1;
	$_POST['url'] = $_GET['url'];
	$_POST['randkey'] = rand(10000,10000000);
	if(!empty($_GET['trackback'])) 
		$_POST['trackback'] = $_GET['trackback'];

// Steef: this is ugly. So removed.
//		echo "----" . $_GET['url'] . "--------\n";
}


if(isset($_POST["phase"])) {
	$phase = $_POST["phase"]; 
} else {
	$phase = 0;
}

if($phase == 0 && Submit_Show_URL_Input == false) {
	$phase = 1;
}
switch ($phase) {
	case 0:
		do_submit0();
		break;
	case 1:
		do_submit1();
		break;
	case 2:
		do_submit2();
		break;
	case 3:
		do_submit3();
		break;
}

exit;

function do_submit0() {
	global $main_smarty, $the_template;
	$main_smarty->assign('submit_rand', rand(10000,10000000));
	$main_smarty->assign('Submit_Show_URL_Input', Submit_Show_URL_Input);
	$main_smarty->assign('Submit_Require_A_URL', Submit_Require_A_URL);
	
	define('pagename', 'submit'); 
    $main_smarty->assign('pagename', pagename);

	$main_smarty->assign('tpl_center', $the_template . '/submit_step_1');
	$main_smarty->display($the_template . '/pligg.tpl');
}

function do_submit1() {
	global $main_smarty, $db, $dblang, $current_user, $the_template;

	$url = htmlspecialchars(strip_tags(trim($_POST['url'])));
	$url = html_entity_decode($url); // thanks czytom
	
	$linkres=new Link;
	$linkres->randkey = strip_tags($_POST['randkey']);

	if(Submit_Show_URL_Input == false) {
		$url = "http://";	
		$linkres->randkey = rand(10000,10000000);
	}
	$Submit_Show_URL_Input = Submit_Show_URL_Input;
	if($url == "http://" || $url == ""){
		$Submit_Show_URL_Input = false;
	}
	
	$main_smarty->assign('randkey', $linkres->randkey);
	
	$main_smarty->assign('submit_url', $url);
	$main_smarty->assign('Submit_Show_URL_Input', $Submit_Show_URL_Input);
	$main_smarty->assign('Submit_Require_A_URL', Submit_Require_A_URL);

	$edit = false;
	$linkres->get($url);
	
	$trackback=$linkres->trackback;

	if($url == "http://" || $url == ""){
		if(Submit_Require_A_URL == false){$linkres->valid = true;}else{$linkres->valid = false;}
	}
	
	if(!$linkres->valid) {
		$main_smarty->assign('submit_error', 'invalidurl');
		$main_smarty->assign('tpl_center', $the_template . '/submit_errors');
		
		define('pagename', 'submit'); 
	    $main_smarty->assign('pagename', pagename);
		
		$main_smarty->display($the_template . '/pligg.tpl');
		return;
	}
	
	if(Submit_Require_A_URL == true || ($url != "http://" && $url != "")){
		if($linkres->duplicates($url) > 0) {
			$main_smarty->assign('submit_search', getmyurl("search", htmlentities($url)));
			$main_smarty->assign('submit_error', 'dupeurl');
			$main_smarty->assign('tpl_center', $the_template . '/submit_errors');
			
			define('pagename', 'submit'); 
     	    $main_smarty->assign('pagename', pagename);
			
			$main_smarty->display($the_template . '/pligg.tpl');
			return;
		}
	}

	check_actions('submit_validating_url', array("url" => $url));
	
	$linkres->status='discard';
	$linkres->author=$current_user->user_id;
	$linkres->store();

	$main_smarty->assign('StorySummary_ContentTruncate', StorySummary_ContentTruncate);
	$main_smarty->assign('SubmitSummary_Allow_Edit', SubmitSummary_Allow_Edit);
	$main_smarty->assign('enable_tags', Enable_Tags);
	$main_smarty->assign('submit_url_title', $linkres->url_title);
	$main_smarty->assign('submit_id', $linkres->id);
	$main_smarty->assign('submit_type', $linkres->type());
	if(isset($link_title)){$main_smarty->assign('submit_title', $link_title);}
	if(isset($link_content)){$main_smarty->assign('submit_content', $link_content);}
	$main_smarty->assign('submit_trackback', $trackback);

	$main_smarty->assign('submit_link_field1', $linkres->link_field1);
	$main_smarty->assign('submit_link_field2', $linkres->link_field2);
	$main_smarty->assign('submit_link_field3', $linkres->link_field3);
	$main_smarty->assign('submit_link_field4', $linkres->link_field4);
	$main_smarty->assign('submit_link_field5', $linkres->link_field5);
	$main_smarty->assign('submit_link_field6', $linkres->link_field6);
	$main_smarty->assign('submit_link_field7', $linkres->link_field7);
	$main_smarty->assign('submit_link_field8', $linkres->link_field8);
	$main_smarty->assign('submit_link_field9', $linkres->link_field9);
	$main_smarty->assign('submit_link_field10', $linkres->link_field10);
	$main_smarty->assign('submit_link_field11', $linkres->link_field11);
	$main_smarty->assign('submit_link_field12', $linkres->link_field12);
	$main_smarty->assign('submit_link_field13', $linkres->link_field13);
	$main_smarty->assign('submit_link_field14', $linkres->link_field14);
	$main_smarty->assign('submit_link_field15', $linkres->link_field15);

	$catsql = mysql_query("SELECT category_id, category_name FROM " . table_categories . " WHERE category_lang='$dblang' ORDER BY category_name ASC");
	$categories = array();
	while ($rows = mysql_fetch_array ($catsql, MYSQL_ASSOC)) array_push ($categories, $rows);
	$main_smarty->assign('categories', $categories);

	include_once(mnminclude.'dbtree.php');
	$array = tree_to_array(0, table_categories, FALSE);
	$main_smarty->assign('lastspacer', 0);
	$main_smarty->assign('cat_array', $array);


	//spellchecker
	$main_smarty->assign('Spell_Checker', Spell_Checker);

	$main_smarty->assign('tpl_extra_fields', $the_template . '/submit_extra_fields');
	$main_smarty->assign('tpl_center', $the_template . '/submit_step_2');
	
	define('pagename', 'submit'); 
    $main_smarty->assign('pagename', pagename);
	
	$main_smarty->display($the_template . '/pligg.tpl');
}

function do_submit2() {
	global $db, $main_smarty, $dblang, $the_template;

	$main_smarty->assign('auto_vote', auto_vote);
	$main_smarty->assign('Submit_Show_URL_Input', Submit_Show_URL_Input);
	$main_smarty->assign('Submit_Require_A_URL', Submit_Require_A_URL);
	
	$main_smarty->assign('tpl_extra_fields', $the_template . '/submit_extra_fields');
	$main_smarty->assign('tpl_center', $the_template . '/submit_step_3');
	
	define('pagename', 'submit'); 
    $main_smarty->assign('pagename', pagename);
	
	$main_smarty->display($the_template . '/pligg.tpl');
	
}

function do_submit3() {
	global $db;

	$linkres=new Link;

	$linkres->id=$link_id = strip_tags($_POST['id']);
	$linkres->read();
	//if (link_errors($linkres)) {
	//	echo '<form id="thisform">';
	//	echo '<input type=button onclick="window.history.go(-2)" value="'._(PLIGG_Visual_Submit_Step3_Modify).'">';
	//	return;
	//}
	$linkres->status='queued';
	$linkres->store_basic();

	$linkres->check_should_publish();
	
	if(!empty($_POST['trackback'])) {
		require_once(mnminclude.'trackback.php');
		$trackres = new Trackback;
		$trackres->url=trim($_POST['trackback']);
		$trackres->link=$linkres->id;
		$trackres->title=$linkres->title;
		$trackres->author=$linkres->author;
		$trackres->content=$linkres->content;
		$res = $trackres->send();
	}

	header("Location: " . getmyurl('upcoming'));
	die;

}

function link_errors($linkres)
{
	global $main_smarty, $the_template;
	$error = false;
	// Errors
	if($_POST['randkey'] !== $linkres->randkey) {
		$main_smarty->assign('submit_error', 'badkey');
		$main_smarty->display($the_template . '/submit_errors.tpl');
		$error = true;
	}
	if($linkres->status != 'discard') {
		$main_smarty->assign('submit_error', 'hashistory');
		$main_smarty->assign('submit_error_history', $linkres->status);
		$main_smarty->display($the_template . '/submit_errors.tpl');
		$error = true;
	}
	if(strlen($linkres->title) < PLIGG_Var_Submit_MinTitleLen  || strlen($linkres->content) < PLIGG_Var_Submit_MinContentLen ) {
		$main_smarty->assign('submit_error', 'incomplete');
		$main_smarty->display($the_template . '/submit_errors.tpl');
		$error = true;
	}
	if(preg_match('/.*http:\//', $linkres->title)) {
		$main_smarty->assign('submit_error', 'urlintitle');
		$main_smarty->display($the_template . '/submit_errors.tpl');
		$error = true;
	}
	if(!$linkres->category > 0) {
		$main_smarty->assign('submit_error', 'nocategory');
		$main_smarty->display($the_template . '/submit_errors.tpl');
		$error = true;
	}
	return $error;
}
?>