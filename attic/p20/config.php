<?php
ini_set('include_path', '.');

// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

//error_reporting(E_ALL);


// experimental caching
// 0 = off
// 1 = on
define('caching', 1);











// DO NOT EDIT THIS FILE. USE THE ADMIN PANEL (logged in as "god") TO MAKE CHANGES


// IF YOU MUST MAKE CHANGES MANUALLY, EDIT SETTINGS.PHP










if (strpos($_SERVER['SCRIPT_NAME'], "install.php") == 0){
	$file = dirname(__FILE__) . '/settings.php';
	if (!file_exists($file)) { $errors[]="'$file' was not found! Try renaming 'settings.php.default' to 'settings.php'"; }
	elseif (filesize($file) <= 0) { $errors[]="'$file' is 0 bytes!"; }
	
	$file = dirname(__FILE__) . '/libs/dbconnect.php';
	if (!file_exists($file)) { $errors[]="'$file' was not found! Try renaming 'dbconnect.php.default' to 'dbconnect.php'"; }
	
	$file= dirname(__FILE__) . '/templates_c';
	if (!file_exists($file)) { $errors[]="'$file' was not found! Create a directory called templates_c in your root directory."; }
	elseif (!is_writable($file)) { $errors[]="'$file' is not writable! Please chmod this directory to 777"; }
	
	$file= dirname(__FILE__) . '/cache';
	if (!file_exists($file)) { $errors[]="'$file' was not found! Create a directory called templates_c in your root directory."; }
	elseif (!is_writable($file)) { $errors[]="'$file' is not writable! Please chmod this directory to 777"; }
	
	if (isset($errors)) {
		foreach ($errors as $error) {
			$output.="<p><b>Error:</b> $error</p>\n";
			$output.='<p>Please fix the above error(s), install halted!</p>';
		}
		die($output);
	}
}








define("mnmpath", dirname(__FILE__));
define("mnminclude", dirname(__FILE__).'/libs/');
define("mnmmodules", dirname(__FILE__).'/modules/');

$server_name	= $_SERVER['SERVER_NAME'];

include_once 'settings.php';
if ($my_base_url == '' || strpos($_SERVER['SCRIPT_NAME'], "admin_config.php") > 0){
	define('my_base_url', "http://" . $_SERVER["HTTP_HOST"]);
	if(isset($_REQUEST['action'])){$action = $_REQUEST['action'];}else{$action="";}
	
	$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
	$path = substr($_SERVER["SCRIPT_NAME"], 0, $pos);
	if ($path == "/"){$path = "";}

	define('my_pligg_base', $path);
	$my_pligg_base = $path;
} else {
	define('my_base_url', $my_base_url);
	define('my_pligg_base', $my_pligg_base);
}

define('urlmethod', $URLMethod);

if(isset($_COOKIE['template'])){
	$thetemp = $_COOKIE['template'];
} 

// template check
		$file = dirname(__FILE__) . '/templates/' . $thetemp . "/pligg.tpl";
		//echo $file;
		if (!file_exists($file)) { $errors[]='You may have typed the template name wrong or it does not exist. Click <a href = "admin_config.php?page=Template">here</a> to fix it.'; }
		if (isset($errors)) {
			foreach ($errors as $error) {
				$output.="<p><b>Error:</b> $error</p>\n";
			}
			$thetemp = "digitalnature";
			if (strpos($_SERVER['SCRIPT_NAME'], "admin_config.php") == 0){
				echo $output;
			}
		}
// template check

define('The_Template', $thetemp);

if(Enable_Extra_Fields){include mnminclude.'extra_fields.php';}

// Charset
	define('mb_charset', 'test');
// ---


// Don't touch behind this
$local_configuration = $_SERVER['SERVER_NAME'].'-local.php';
@include($local_configuration);

if(!defined('table_prefix')){
	define('table_prefix','');
}
if(!defined('table_blogs')){ define('table_blogs', table_prefix . "blogs" ); }
if(!defined('table_categories')){ define('table_categories', table_prefix . "categories" ); }
if(!defined('table_comments')){ define('table_comments', table_prefix . "comments" ); }
if(!defined('table_friends')){ define('table_friends', table_prefix . "friends" ); }
if(!defined('table_languages')){ define('table_languages', table_prefix . "languages" ); }
if(!defined('table_links')){ define('table_links', table_prefix . "links" ); }
if(!defined('table_trackbacks')){ define('table_trackbacks', table_prefix . "trackbacks" ); }
if(!defined('table_users')){ define('table_users', table_prefix . "users" ); }
if(!defined('table_tags')){ define('table_tags', table_prefix . "tags" ); }
if(!defined('table_votes')){ define('table_votes', table_prefix . "votes" ); }
if(!defined('table_pageviews')){ define('table_pageviews', table_prefix . "pageviews" ); }
if(!defined('table_config')){ define('table_config', table_prefix . "config" ); } 
if(!defined('table_modules')){ define('table_modules', table_prefix . "modules" ); }
if(!defined('table_messages')){ define('table_messages', table_prefix . "messages" ); }

ob_start();
include_once mnminclude.'db.php';
include mnminclude.'utils.php';
include_once mnminclude.'login.php';
include mnminclude.'options.php';
include_once(mnmmodules . 'modules_init.php');
include mnminclude.'utf8/utf8.php';
include_once(mnminclude.'dbtree.php');
?>