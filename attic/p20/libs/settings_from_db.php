<?php

// this file pulls settings directly from the DB

include_once mnminclude.'db.php';

	$usersql = $db->get_results('SELECT var_name, var_value, var_method, var_enclosein FROM ' . table_prefix . 'config');

	if(!$usersql){die('Error. The ' . table_prefix . 'config table is empty or does not exist');}
	
	foreach($usersql as $row) {
		$value = $row->var_value;
		if ($row->var_method == "normal"){
			$pligg_vars[$row->var_name] = $value;
		}
		if ($row->var_method == "define"){
			$thenewval = $value;
			if($row->var_enclosein == ""){
				if(strtolower($value) == "true"){$thenewval = true;}
				if(strtolower($value) == "false"){$thenewval = false;}
			} else {
				$thenewval = $value;
			}
			if(!defined($row->var_name)){
				define($row->var_name, $thenewval);
			}
		}
	}

// if you have a better way of doing this, please let us know
// other than converting these to a "define" which we will eventually do

$URLMethod = $pligg_vars['$URLMethod'] ;
$trackbackURL = $pligg_vars['$trackbackURL'];
$tags_min_pts = $pligg_vars['$tags_min_pts'];
$tags_max_pts = $pligg_vars['$tags_max_pts'];
$tags_words_limit = $pligg_vars['$tags_words_limit'];
$MAIN_SPAM_RULESET = $pligg_vars['$MAIN_SPAM_RULESET'];
$USER_SPAM_RULESET = $pligg_vars['$USER_SPAM_RULESET'];
$SPAM_LOG_BOOK = $pligg_vars['$SPAM_LOG_BOOK'];
$CommentOrder = $pligg_vars['$CommentOrder'];
$anon_karma = $pligg_vars['$anon_karma'];
$page_size = $pligg_vars['$page_size'];
$top_users_size = $pligg_vars['$top_users_size'];
$thetemp = $pligg_vars['$thetemp'];

?>