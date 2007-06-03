<?php
include_once('scriptaculous_settings.php');

// tell pligg what pages this modules should be included in
// pages are <script name> minus .php
// index.php becomes 'index' and upcoming.php becomes 'upcoming'
$include_in_pages = array('all');
$do_not_include_in_pages = array();

if( do_we_load_module() ) {
	$loadable_js_files = array();
	if(enable_gzip_files == true)
	{
		$loadable_js_files = array('js/prototype.js.gz','js/EditInPlace.js.gz','js/scriptaculous.js.gz','js/dragdrop.js.gz','js/effects.js.gz');
	}else{
		$loadable_js_files = array('js/prototype.js','js/EditInPlace.js','js/scriptaculous.js','js/dragdrop.js','js/effects.js');
	}
	foreach($loadable_js_files as $loadable_js_file)
	{
		module_add_js(scriptaculous_path . $loadable_js_file);
	}
}
?>