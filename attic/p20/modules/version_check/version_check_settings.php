<?php

// the path to the module. the probably shouldn't be changed unless you rename the version_check folder(s)
define('version_check_path', my_pligg_base . '/modules/version_check/');

// the path to the module. the probably shouldn't be changed unless you rename the version_check folder(s)
define('version_check_lang_conf', '/modules/version_check/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the version_check folder(s)
define('version_check_tpl_path', '../modules/version_check/templates/');


// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('version_check_path', version_check_path);
	$main_smarty->assign('version_check_lang_conf', version_check_lang_conf);
	$main_smarty->assign('version_check_tpl_path', version_check_tpl_path);
}

?>