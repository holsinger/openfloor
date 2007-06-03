<?php
include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'ts.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'admin_config.php');

// -------------------------------------------------------------------------------------

	force_authentication();
               // breadcrumbs
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_5') . $main_smarty->get_config_vars('PLIGG_Visual_Name');
		$navwhere['link2'] = my_pligg_base . "/admin_config.php";
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
	// breadcrumbs
	
	$main_smarty = do_sidebar($main_smarty);
	
	define('pagename', 'admin_config'); 
    $main_smarty->assign('pagename', pagename);
	
	$main_smarty->assign('tpl_center', $the_template . '/admin_templates/admin_config_center');
	if(isset($_REQUEST['action'])){
		$main_smarty->display($the_template . '/blank.tpl');
	} else {
		$main_smarty->display($the_template . '/pligg.tpl');
	}
	
	function dowork(){	
		$canIhaveAccess = 0;
		$canIhaveAccess = $canIhaveAccess + checklevel('god');
		
		if($canIhaveAccess == 1)
		{
			if(is_writable('settings.php') == 0){
				die("Error: settings.php is not writeable.");
			}
			
			if(isset($_REQUEST['action'])){
				$action = $_REQUEST['action'];
			} else {
				$action = "view";
			}
			
			if($action == "view"){
				$config = new pliggconfig;
				if(isset($_REQUEST['page'])){
					$config->var_page = $_REQUEST['page'];
					$config->showpage();
				}else{
					$config->listpages();
				}
			}
			
			if($action == "save"){
				$config = new pliggconfig;
				$config->var_id = substr($_REQUEST['var_id'], 6, 10);
				$config->var_value = $_REQUEST['var_value'];
				$config->store();
			}
		}
	}	
?>