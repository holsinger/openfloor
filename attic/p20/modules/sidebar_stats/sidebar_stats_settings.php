<?php

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('sidebar_stats_path', my_pligg_base . '/modules/sidebar_stats/');

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('sidebar_stats_lang_conf', '/modules/sidebar_stats/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('sidebar_stats_tpl_path', '../modules/sidebar_stats/templates/');



// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('sidebar_stats_path', sidebar_stats_path);
	$main_smarty->assign('sidebar_stats_lang_conf', sidebar_stats_lang_conf);
	$main_smarty->assign('sidebar_stats_tpl_path', sidebar_stats_tpl_path);
}

?>