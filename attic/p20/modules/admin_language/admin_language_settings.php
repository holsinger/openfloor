<?php

// the path to the module. the probably shouldn't be changed unless you rename the admin_language folder(s)
define('admin_language_path', my_pligg_base . '/modules/admin_language/');

// the path to the module. the probably shouldn't be changed unless you rename the admin_language folder(s)
define('admin_language_lang_conf', '/modules/admin_language/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the admin_language folder(s)
define('admin_language_tpl_path', '../modules/admin_language/templates/');


// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('admin_language_path', admin_language_path);
	$main_smarty->assign('admin_language_lang_conf', admin_language_lang_conf);
	$main_smarty->assign('admin_language_tpl_path', admin_language_tpl_path);
}

?>