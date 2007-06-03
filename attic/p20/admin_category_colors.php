<?php

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'smartyvariables.php');

include_once(mnminclude.'dbtree.php');

force_authentication();

 // breadcrumbs
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_2');
		$navwhere['link2'] = my_pligg_base . "/admin_categories.php";
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Category_Colors');
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
	// breadcrumbs

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');

if($canIhaveAccess == 1)
{


	$array = tree_to_array(0, table_categories, true);
	$main_smarty->assign('tree_array', $array);
	//$main_smarty->display($the_template . '/category_colors.tpl');
	
	$main_smarty->assign('tpl_center', The_Template . '/admin_templates/category_colors');
	$main_smarty->display(The_Template . '/pligg.tpl');
}else	{
	echo 'not for you! go away!';
}

?>