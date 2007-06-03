<?php

// the path to the module. the probably shouldn't be changed unless you rename the ajaxcontact folder(s)
define('ajaxcontact_path', my_pligg_base . '/modules/ajaxcontact/');

// the path to the module. the probably shouldn't be changed unless you rename the ajaxcontact folder(s)
define('ajaxcontact_lang_conf', '/modules/ajaxcontact/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the ajaxcontact folder(s)
define('ajaxcontact_tpl_path', '../modules/ajaxcontact/templates/');

define('ajaxcontact_youremail', 'user@example.com');
define('ajaxcontact_yourname', 'John Doe');
define('ajaxcontact_subject', 'Contact Form: ');


// don't touch anything past this line.

if(is_object($main_smarty)){
	//$main_smarty->assign('ajaxcontact_path', ajaxcontact_path);
	//$main_smarty->assign('ajaxcontact_lang_conf', ajaxcontact_lang_conf);
	//$main_smarty->assign('ajaxcontact_tpl_path', ajaxcontact_tpl_path);
}

?>