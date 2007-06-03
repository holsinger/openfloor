<?php
	include_once('users_extra_fields_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		

		module_add_action('story_top', 'users_extra_fields_story_top', '');
		
		module_add_action('admin_users_save', 'users_extra_fields_admin_users_save', '');
		module_add_action('admin_users_view', 'users_extra_fields_admin_users_view', '');
		module_add_action('admin_users_edit', 'users_extra_fields_admin_users_edit', '');

		module_add_action('profile_save', 'users_extra_fields_profile_save', '');
		module_add_action('profile_show', 'users_extra_fields_profile_show', '');

		module_add_action_tpl('tpl_profile_center_fields', users_extra_fields_tpl_path . 'profile_center_fields.tpl');
		module_add_action_tpl('tpl_admin_user_edit_center_fields', users_extra_fields_tpl_path . 'admin_user_edit_center_fields.tpl');
		module_add_action_tpl('tpl_admin_user_show_center_fields', users_extra_fields_tpl_path . 'admin_user_show_center_fields.tpl');
		
		include_once(mnmmodules . 'users_extra_fields/users_extra_fields_main.php');
	}
	
	
?>