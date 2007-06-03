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
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');

$main_smarty = do_sidebar($main_smarty);

$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_About');
$navwhere['link1'] = getmyurl('about', $dblang);
$main_smarty->assign('navbar_where', $navwhere);

define('pagename', 'faq-en'); 
$main_smarty->assign('pagename', pagename);

$main_smarty->assign('tpl_center', $the_template . '/faq-en_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>