<?php

// the path to the module. the probably shouldn't be changed unless you rename the scriptaculous folder(s)
define('scriptaculous_path', my_pligg_base . '/modules/scriptaculous/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('scriptaculous_path', scriptaculous_path);
}

?>