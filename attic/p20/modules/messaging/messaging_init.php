<?php
	include_once('messaging_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('index', 'user', 'upcoming', 'topstories', 'story', 'search', 'live', 'cloud', 'topusers');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		
		// run at the top of the index page to generate the array for the "quickview" box	
		module_add_action('index_top', 'messaging_showpage', '');
		
		// run in the user page to see if we need to do some messaging stuff
		module_add_action('user_post_views', 'messaging_check_view', '');
	
		// show the "quickview" box on the index page
		module_add_action_tpl('tpl_pligg_above_center', messaging_tpl_path . 'messaging_index.tpl');
		
		// show the inbox on the users page
		module_add_action_tpl('tpl_user_center_just_below_header', messaging_tpl_path . 'messaging_inbox.tpl');
	
		// show the inbox link in the menus on the top
		module_add_action_tpl('tpl_header_just_after_profile', messaging_tpl_path . 'inbox_link_as_LI.tpl');
		
		// show the inbox link in the sidebar
		module_add_action_tpl('tpl_sidebar_logged_in_just_below_profile', messaging_tpl_path . 'inbox_link_as_LI.tpl');
		
		// show the send message link in profile page
		module_add_action_tpl('tpl_user_center', messaging_tpl_path . 'messaging_user_center.tpl');
		
		// show the "send a message" when you click on a story submitters name
		module_add_action_tpl('tpl_link_summary_submitter_links', messaging_tpl_path . 'link_summary_sendto_submitter.tpl');
	
		// add the custom css
		module_add_css(my_pligg_base . '/modules/messaging/messaging.css');
	
		include_once(mnmmodules . 'messaging/messaging_main.php');
	}
?>