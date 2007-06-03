<?php
function ajaxchat_showpage(){
	global $main_smarty, $the_template;
	
	//$main_smarty->display(ajaxcontact_tpl_path . 'ajaxcontact.tpl');
	
	$main_smarty->assign('tpl_center', ajaxcontact_tpl_path . 'ajaxcontact');
	$main_smarty->display($the_template . '/pligg.tpl');
}	
?>