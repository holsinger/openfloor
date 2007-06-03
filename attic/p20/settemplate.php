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

// -------------------------------------------------------------------------------------

// setup the breadcrumbs
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Profile_ModifyProfile');
$navwhere['link1'] = getmyurl('profile', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Profile_ModifyProfile'));


    define('pagename', 'settemplate'); 
    $main_smarty->assign('pagename', pagename);
	
	$main_smarty->assign('tpl_center', $the_template . '/settemplate_center');
	$main_smarty->display($the_template . '/pligg.tpl');



?>