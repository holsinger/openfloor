<?php

function module_add_action($location, $the_function, $variables)
{
	global $script_name, $module_actions, $include_in_pages, $do_not_include_in_pages;
	if(is_array($include_in_pages)){
		if (in_array($script_name, $include_in_pages) || in_array('all', $include_in_pages)) {
			if(is_array($do_not_include_in_pages)){
				if (!in_array($script_name, $do_not_include_in_pages)) {
					$module_actions[$location][$the_function] = $variables;
				}
			}
		}
	}
}

function module_add_action_tpl($location, $the_tpl)
{
	global $script_name, $module_actions_tpl, $include_in_pages, $do_not_include_in_pages;
	if(is_array($include_in_pages)){
		if (in_array($script_name, $include_in_pages) || in_array('all', $include_in_pages)) {
			if(is_array($do_not_include_in_pages)){
				if (!in_array($script_name, $do_not_include_in_pages)) {
					$module_actions_tpl[$location][] = $the_tpl;
				}
			}
		}
	}
}

function module_add_css($the_css)
{
	global $script_name, $module_css, $include_in_pages, $do_not_include_in_pages;
	if(is_array($include_in_pages)){
		if (in_array($script_name, $include_in_pages) || in_array('all', $include_in_pages)) {
			if(is_array($do_not_include_in_pages)){
				if (!in_array($script_name, $do_not_include_in_pages)) {
					$module_css[] = $the_css;
				}
			}
		}
	}
}

function module_add_js($the_js)
{
	global $script_name, $module_js, $include_in_pages, $do_not_include_in_pages;
	if(is_array($include_in_pages)){
		if (in_array($script_name, $include_in_pages) || in_array('all', $include_in_pages)) {
			if(is_array($do_not_include_in_pages)){
				if (!in_array($script_name, $do_not_include_in_pages)) {
					$module_js[] = $the_js;
				}
			} else {
				$module_js[] = $the_js;
			}
		}
	}
}

function check_for_js()
{
	global $module_js, $include_in_pages;
	if( $module_js ){
		foreach ( $module_js as $k){
			echo '<script src="' . $k . '" type="text/javascript"></script>';
		}
	}
}

function check_for_css()
{
	global $module_css, $include_in_pages;
	if( $module_css ){
		foreach ( $module_css as $k){
			echo '<link rel="stylesheet" type="text/css" href="' . $k . '" media="screen" />';
		}
	}
}

function check_actions($location, $vars="")
{
	global $module_actions;
	$vars['location'] = $location;
	if($module_actions){
		foreach ( $module_actions as $k => $v ) {
			if($k == $location){
				foreach ( $v as $kk => $vv ) {
					call_user_func($kk, $vars);
				}
			}
		}
	}
}

function check_actions_tpl($location,&$smarty)
{
    global $module_actions_tpl, $main_smarty;
    
    if($module_actions_tpl){
        foreach ( $module_actions_tpl as $k => $v ) {
        	foreach ($v as $y){
            if($k == $location){
                $smarty->display($y);
            }
          }
        }
    }
} 

function check_for_enabled_module($name, $version)
{
	global $db;
	
	if($name == 'PHP'){
		if(phpnum() == $version) {
			return $version;
		}
	}else{
		$sql = 'SELECT `id` FROM ' . table_modules . ' where `folder` = "' . $name . '" and `version` >= ' . $version . ' and `enabled` = 1;';
		//echo $sql;
		$theId = $db->get_var($sql);
		return $theId;
	}
}

function check_module_requirements($requires)
{
	if(is_array($requires)){
		foreach($requires as $requirement){
			if(!check_for_enabled_module($requirement[0], $requirement[1])){
				die('This module requires ' . $requirement[0] . ' version ' . $requirement[1] . ' or greater');
			}
		}
	}
}

function include_module_settings($module)
{
	if(file_exists('./' . $module . '/' . $module . '_install.php'))
	{
		include_once('./' . $module . '/' . $module . '_install.php');		
		return $module_info;
	} else {
		return false;
	}
}

function process_db_requirements($module_info){
	$db_add_field = $module_info['db_add_field'];
	if(is_array($db_add_field))	{
		foreach($db_add_field as $field_to_add){
			//print_r($field_to_add);
			module_db_add_field($field_to_add[0], $field_to_add[1], $field_to_add[2], $field_to_add[3], $field_to_add[4], $field_to_add[5], $field_to_add[6]);
		}
	}
}


// for module installation

function module_db_add_field($field_table, $field_name, $field_type,  $field_length, $field_attributes, $field_null, $field_default){
	//field_table = the table the field will go into, without the prefix, users, comments, votes etc
	//field_name = the name of the field
	//field_type = varchar, text, int etc...
	//field_length = length of the field
	//field_attributes = unsigned etc...
	//field_null = 0=not null, 1=null
	//field_default = default value

	global $db;
	
	if($field_table == 'users'){$field_table = table_users;}

	$fieldexists = checkforfield($field_name, $field_table);
	if (!$fieldexists) {
		$sql = 'ALTER TABLE `' . $field_table . '` ADD `' . $field_name . '` ' . $field_type;
		if($field_length != '') {$sql .= '(' . $field_length . ')';}

		if($field_attributes != '') {$sql .= ' ' . $field_attributes;}
		if($field_null == 0) {$sql .= ' not null';}else{$sql .= ' null';}

		if($field_default != '') {$sql .= " default '" . $field_default . "'";}


		//echo $sql . '<br>';
		$db->query($sql);
	}

}

?>