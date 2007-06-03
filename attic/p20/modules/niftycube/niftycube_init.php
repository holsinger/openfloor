<?php
	include_once('niftycube_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	
	if( do_we_load_module() ) {		

		// add the custom css
		module_add_css(niftycube_path . 'css/niftyCorners.css');
		
		// add the custom js
		module_add_js(niftycube_path . 'js/niftycube.js');
		
		// add the tpl
		module_add_action_tpl('tpl_pligg_below_center', niftycube_tpl_path . 'niftycube_load.tpl', '');

	}	
?>