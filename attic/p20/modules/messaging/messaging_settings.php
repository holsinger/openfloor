<?php

// the path to the module. the probably shouldn't be changed unless you rename the messaging folder(s)
define('messaging_path', my_pligg_base . '/modules/messaging/');

// the path to the module. the probably shouldn't be changed unless you rename the messaging folder(s)
define('messaging_lang_conf', '/modules/messaging/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the messaging folder(s)
define('messaging_tpl_path', '../modules/messaging/templates/');

// Use fade effect to close lightbox
define('messaging_fade_lightbox', TRUE);
// will not work until we resolve scriptaculous dependencies


if(is_object($main_smarty)){
	$main_smarty->assign('load_leightbox', "1");
}

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('messaging_path', messaging_path);
	$main_smarty->assign('messaging_lang_conf', messaging_lang_conf);
	$main_smarty->assign('messaging_tpl_path', messaging_tpl_path);
}

?>