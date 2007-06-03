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

$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Live');
$navwhere['link1'] = getmyurl('live', '');
$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Comments');
$navwhere['link2'] = getmyurl('comments', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Comments'));

$offset = (get_current_page() - 1) * $top_users_size;

$select = "SELECT comment_id";
$from_where = " FROM " . table_comments . " ";
$order_by = " ORDER BY comment_id DESC";

define('pagename', 'comments');
$main_smarty->assign('pagename', pagename);

$main_smarty = do_sidebar($main_smarty);

$main_smarty->assign('tpl_center', $the_template . '/comments_center');
$main_smarty->display($the_template . '/pligg.tpl');
