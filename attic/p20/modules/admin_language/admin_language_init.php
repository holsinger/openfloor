<?php
	include_once('admin_language_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_links', admin_language_tpl_path . 'admin_language_admin_link.tpl');
		module_add_action_tpl('tpl_header_admin_main_links', admin_language_tpl_path . 'admin_language_admin_main_link.tpl');
	}
	

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'admin_language'){

			module_add_action('module_page', 'admin_language_showpage', '');
			module_add_js(admin_language_path . 'js/EditInPlaceAL.js');
		
			include_once(mnmmodules . 'admin_language/admin_language_main.php');
		}
	}
	
?>