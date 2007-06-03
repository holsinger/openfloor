<?php

// the path to the module. the probably shouldn't be changed unless you rename the niftycube folder(s)
define('niftycube_path', my_pligg_base . '/modules/niftycube/');

// the path to the module. the probably shouldn't be changed unless you rename the niftycube folder(s)
define('niftycube_lang_conf', '/modules/niftycube/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the niftycube folder(s)
define('niftycube_tpl_path', '../modules/niftycube/templates/');


define('niftycube_do_votebox', TRUE);

if(is_object($main_smarty)){
	$main_smarty->assign('niftycube_do_votebox', niftycube_do_votebox);
}

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('niftycube_path', niftycube_path);
	$main_smarty->assign('niftycube_lang_conf', niftycube_lang_conf);
	$main_smarty->assign('niftycube_tpl_path', niftycube_tpl_path);
}

?>