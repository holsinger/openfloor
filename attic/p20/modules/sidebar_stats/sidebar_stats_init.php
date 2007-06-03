<?php
	include_once('sidebar_stats_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	if( do_we_load_module() ) {		

		module_add_action('all_pages_top', 'sidebar_stats_getdata', '');

		module_add_action_tpl('tpl_sidebar_top', sidebar_stats_tpl_path . 'sidebar_stats.tpl');
	
		include_once(mnmmodules . 'sidebar_stats/sidebar_stats_main.php');
	}
?>