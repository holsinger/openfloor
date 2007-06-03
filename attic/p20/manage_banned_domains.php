<?php
include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

	$main_smarty->assign('dblang', $dblang);
	$main_smarty->assign('server_name', get_server_name());
	$main_smarty->assign('user_logged_in', $current_user->user_login);
	$main_smarty->assign('user_authenticated', $current_user->authenticated);
	$main_smarty->assign('server_request_uri', $_SERVER['REQUEST_URI']);
	if(isset($_REQUEST['id'])){$main_smarty->assign('request_id', $_REQUEST['id']);}
	if(isset($_REQUEST['category'])){$main_smarty->assign('request_category', $_REQUEST['category']);}
	if(isset($_REQUEST['search'])){$main_smarty->assign('request_search', $_REQUEST['search']);}

	$main_smarty = SetSmartyURLs($main_smarty);

	force_authentication();

	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');

	if(CHECK_SPAM == false){
		$main_smarty->assign('errorText', "<b>Error:</b> You have <b>Enable spam checking</b> set to false. Please set it to true in the <a href=$my_base_url$my_pligg_base/admin_config.php?page=AntiSpam>admin panel</a>.");
		$main_smarty->assign('tpl_center', 'error');
		$main_smarty->display(The_Template . '/pligg.tpl');
	}

	if(isset($_REQUEST["id"])){$id = $_REQUEST["id"];}

	if($canIhaveAccess == 1)
	{
		if(isset($_REQUEST['add']))
		{
			$main_smarty->assign('story_id', $_REQUEST['id']);
			$main_smarty->assign('domain_to_ban', $_REQUEST['add']);
			$main_smarty->assign('tpl_center', The_Template . '/admin_templates/admin_banned_domain_add');
			$main_smarty->display(The_Template . '/pligg.tpl');

		}
		if(isset($_REQUEST['doban']))
		{
			$filename = 'local-antispam.txt';
			$somecontent = $_REQUEST['doban'] . "\n";
			if (is_writable($filename)) {
			   if (!$handle = fopen($filename, 'a')) {
					$main_smarty->assign('errorText', "Cannot open file ($filename)");
					$main_smarty->assign('tpl_center', 'error');
					$main_smarty->display(The_Template . '/pligg.tpl');
					exit;
			   }

			   if (fwrite($handle, $somecontent) === FALSE) {
					$main_smarty->assign('errorText', "Cannot write to file ($filename)");
					$main_smarty->assign('tpl_center', 'error');
					$main_smarty->display(The_Template . '/pligg.tpl');
					exit;
			   }

				$main_smarty->assign('somecontent', $somecontent);
				$main_smarty->assign('filename', $filename);
				$main_smarty->assign('storyurl', getmyurl("story", $id));
				$main_smarty->assign('tpl_center', The_Template . '/admin_templates/admin_banned_domain_added');
				$main_smarty->display(The_Template . '/pligg.tpl');


			   fclose($handle);

			} else {
				$main_smarty->assign('errorText', "The file $filename is not writable");
				$main_smarty->assign('tpl_center', 'error');
				$main_smarty->display(The_Template . '/pligg.tpl');
			}
		}

		if(isset($_REQUEST['list']))
		{
			$lines = file('local-antispam.txt');
			$main_smarty->assign('lines', $lines);
			$main_smarty->assign('tpl_center', The_Template . '/admin_templates/admin_banned_domain_list');
			$main_smarty->display(The_Template . '/pligg.tpl');
		}
	}
	else
	{
		$main_smarty->assign('errorText', "<br />We're sorry, but you do not have administrative privileges on this site.<br />If you wish to be promoted, please contact the site administrator.<br />");
		$main_smarty->assign('tpl_center', 'error');
		$main_smarty->display(The_Template . '/pligg.tpl');
	}
?>