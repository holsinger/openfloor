<?php

$main_smarty->compile_dir = "templates_c/";
$main_smarty->template_dir = "templates/";
$main_smarty->cache_dir = "cache/";
$main_smarty->config_dir = "";
$main_smarty->force_compile = false; // has to be off to use cache

$main_smarty->assign('dblang', $dblang);
$main_smarty->assign('server_name', get_server_name());
$main_smarty->assign('user_logged_in', $current_user->user_login);
$main_smarty->assign('user_authenticated', $current_user->authenticated);
$main_smarty->assign('server_request_uri', $_SERVER['REQUEST_URI']);
if(isset($_REQUEST['id'])){$main_smarty->assign('request_id', $_REQUEST['id']);}
if(isset($_REQUEST['category'])){$main_smarty->assign('request_category', $_REQUEST['category']);}
if(isset($_REQUEST['search'])){$main_smarty->assign('request_search', $_REQUEST['search']);}
if(isset($_POST['username'])){$main_smarty->assign('login_username', trim($_POST['username']));}
$main_smarty->assign('Enable_Tags', Enable_Tags);
$main_smarty->assign('Enable_Live', Enable_Live);
$main_smarty->assign('Voting_Method', Voting_Method);
$main_smarty->assign('Enable_AddTo', Enable_AddTo);
$main_smarty->assign('my_base_url', my_base_url);
$main_smarty->assign('my_pligg_base', my_pligg_base);
$main_smarty->assign('Spell_Checker', Spell_Checker);
$main_smarty->assign('Allow_User_Change_Templates', Allow_User_Change_Templates);
$main_smarty->assign('urlmethod', urlmethod); //Steef: shakks tagcloud
$main_smarty->assign('enable_categorycolors', enable_categorycolors); //Steef: read enable or disable category colors in config.php
$main_smarty->assign('enable_gzip_files',enable_gzip_files);
include mnminclude.'extra_fields_smarty.php';

$main_smarty->assign('UseAvatars', do_we_use_avatars());
if($current_user->user_login){$main_smarty->assign('Current_User_Avatar_ImgSrc', get_avatar('large', "", $current_user->user_login));}

//remove this after we eliminate the need for do_header
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	if($canIhaveAccess == 1){$main_smarty->assign('isgod', 1);}
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	if($canIhaveAccess == 1){$main_smarty->assign('isadmin', 1);}

$main_smarty = SetSmartyURLs($main_smarty);

$main_smarty->display('blank.tpl');

$the_template = The_Template;
$main_smarty->assign('the_template', The_Template);
$main_smarty->assign('the_template_sidebar_modules', The_Template . "/sidebar_modules");
$main_smarty->assign('the_template_link_summary_modules', The_Template . "/link_summary_modules");
$main_smarty->assign('tpl_head', $the_template . '/head');
$main_smarty->assign('tpl_body', $the_template . '/body');
$main_smarty->assign('tpl_right_sidebar', $the_template . '/sidebar');
$main_smarty->assign('tpl_header', $the_template . '/header');
$main_smarty->assign('tpl_footer', $the_template . '/footer');

$main_smarty->assign('Allow_Friends', Allow_Friends);

check_actions('all_pages_top');

// setup the sorting links on the index page in smarty
if(isset($_GET['category'])){
	$main_smarty->assign('index_url_recent', getmyurl('index_sort', 'recent', '&amp;category='.$_GET['category']));
	$main_smarty->assign('index_url_today', getmyurl('index_sort', 'today', '&amp;category='.$_GET['category']));
	$main_smarty->assign('index_url_yesterday', getmyurl('index_sort', 'yesterday', '&amp;category='.$_GET['category']));
	$main_smarty->assign('index_url_week', getmyurl('index_sort', 'week', '&amp;category='.$_GET['category']));
	$main_smarty->assign('index_url_month', getmyurl('index_sort', 'month', '&amp;category='.$_GET['category']));
	$main_smarty->assign('cat_url', getmyurl("maincategory"));
	}
else {
	$main_smarty->assign('index_url_recent', getmyurl('index_sort', 'recent'));
	$main_smarty->assign('index_url_today', getmyurl('index_sort', 'today'));
	$main_smarty->assign('index_url_yesterday', getmyurl('index_sort', 'yesterday'));
	$main_smarty->assign('index_url_week', getmyurl('index_sort', 'week'));
	$main_smarty->assign('index_url_month', getmyurl('index_sort', 'month'));
	}

?>