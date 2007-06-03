<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es> and the Pligg team <pligger at gmail dot com>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'ts.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'smartyvariables.php');

force_authentication();
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');
$canIhaveAccess = $canIhaveAccess + checklevel('admin');

if($canIhaveAccess == 1)
{
	if(isset($_REQUEST["action"])){
		
		$id = $_REQUEST["id"];
		$action = $_REQUEST["action"];
		
		if ($action == "main"){
			if(($link = $db->get_row("SELECT " . table_links . ".* FROM " . table_links . ", " . table_users . " WHERE link_id = $id"))) {
				$author = $db->get_row("Select * from " . table_users . " where user_id = $link->link_author");
				//the basic data
				$main_smarty->assign('link_id',$link->link_id);
				$main_smarty->assign('link_title',$link->link_title);
				$main_smarty->assign('link_url',$link->link_url);
				$main_smarty->assign('link_content',$link->link_content);
				$main_smarty->assign('link_status',$link->link_status);
				$main_smarty->assign('user_login',$author->user_login);
				//the friendly urls
				$main_smarty->assign('banned_domain_url',get_base_url($link->link_url));
				$main_smarty->assign('admin_discard_url',getmyurl('admin_discard', $link->link_id));
				$main_smarty->assign('admin_queued_url',getmyurl('admin_queued', $link->link_id));
				$main_smarty->assign('admin_published_url',getmyurl('admin_published', $link->link_id));
				$main_smarty->assign('story',getmyurl('story', $link->link_id));
				
				define('pagename', 'linkadmin'); 
    		    $main_smarty->assign('pagename', pagename);
				
				$main_smarty->assign('tpl_center', The_Template . '/admin_templates/linkadmin_main');
				$main_smarty->display(The_Template . '/pligg.tpl');
			}
			else
			{
				echo 'Error: link not found';
			}
		}
		
		//stage 2
		if ($action == "published" or $action == "queued" or $action == "discard"){
			if(($link = $db->get_row("SELECT " . table_links . ".* FROM " . table_links . ", " . table_users . " WHERE link_id = $id"))) {
				$author = $db->get_row("Select * from " . table_users . " where user_id = $link->link_author");
				//basic link data
				$main_smarty->assign('link_id',$link->link_id);
				$main_smarty->assign('link_title',$link->link_title);
				$main_smarty->assign('link_url',$link->link_url);
				$main_smarty->assign('link_content',$link->link_content);
				$main_smarty->assign('link_status',$link->link_status);
				$main_smarty->assign('user_login',$author->user_login);
				$main_smarty->assign('action',$action);
				
				$main_smarty->assign('banned_domain_url',get_base_url($link->link_url));
				$main_smarty->assign('admin_modify_url',getmyurl('admin_modify', $link->link_id));
				$main_smarty->assign('admin_modify_do_url',getmyurl('admin_modify_do', $link->link_id, $action));
				$main_smarty->assign('admin_modify_edo_url',getmyurl('admin_modify_edo', $link->link_id, $action));
				
				define('pagename', 'linkadmin'); 
			    $main_smarty->assign('pagename', pagename);
				
				$main_smarty->assign('tpl_center', The_Template . '/admin_templates/linkadmin_stage2');
				$main_smarty->display(The_Template . '/pligg.tpl');
	
			}
			else
			{
				echo 'Error: link not found';
			}
		}

		if ($action == "edodiscard" or $action == "edopublished" or $action == "edoqueued")
		{
			if(!isset($_REQUEST["reason"])) //edo
			{
				if(($link = $db->get_row("SELECT " . table_links . ".link_id FROM " . table_links . " WHERE link_id = $id")))
				$main_smarty->assign('link_id',$link->link_id);
				$main_smarty->assign('tpl_center', The_Template . '/admin_templates/linkadmin_edo');
				
				define('pagename', 'linkadmin'); 
			    $main_smarty->assign('pagename', pagename);
				
				$main_smarty->display(The_Template . '/pligg.tpl');
			}
			else //edofail
			{
				$link_author = $db->get_col("SELECT link_author FROM " . table_links . " WHERE link_id=".$id.";");
				$user = $db->get_row("SELECT * FROM " . table_users . " WHERE user_id=".$link_author[0].";");
	
				$to = $user->user_email;
				$subject = "story status change";
				$body = $user->user_login . ", \r\n\r\nan admin has changed the status of your story for the following reason: ";
				if($_POST["reason"] == "other")
				{$body = $body . $_POST["otherreason"];}
				else
				{$body = $body . $_POST["reason"];}
				$body = $body . "\r\n";
				$body = $body . "The story is: " . strtolower(strtok($_SERVER['SERVER_PROTOCOL'], '/')).'://'.$_SERVER['HTTP_HOST'] . getmyurl('story', $_POST['id']) . "\r\n\r\n";
				$headers = 'From: ' . PLIGG_PassEmail_From . "\r\n";
				if (!mail($to, $subject, $body, $headers))
				{   
					$main_smarty->assign('error_message',_(PLIGG_PassEmail_SendFail));
					$main_smarty->assign('tpl_center', The_Template . '/admin_templates/linkadmin_edofail');
					
					define('pagename', 'linkadmin'); 
				    $main_smarty->assign('pagename', pagename);
					
					$main_smarty->display(The_Template . '/pligg.tpl');
					die();
				}
				$action = substr($action, 1, 100);
			}
		}
	
		if ($action == "dodiscard" or $action == "dopublished" or $action == "doqueued"){
			if(($link = $db->get_row("SELECT " . table_links . ".* FROM " . table_links . ", " . table_users . " WHERE link_id = $id"))) {
			$xaction = substr($action, 2, 100);
			$link = new Link;
			$link->id=$id;
			$link->read();
			$link->published_date = time();
			$link->status = $xaction;
			$link->store_basic();
			$main_smarty->assign('action',$xaction);
			$main_smarty->assign('story_url',getmyurl('story', $id));
			$main_smarty->assign('admin_modify_url',getmyurl('admin_modify', $id));
			$db->query("UPDATE " . table_links . " set link_status='".$xaction."' WHERE link_id=$id");
			$main_smarty->assign('tpl_center', The_Template . '/admin_templates/linkadmin_update');
			
			define('pagename', 'linkadmin'); 
            $main_smarty->assign('pagename', pagename);
			
			$main_smarty->display(The_Template . '/pligg.tpl');
			}else{
				echo 'Error: link not found';
			}
		}			
	}else{
			//no request
	}
	//do_footer($main_smarty);
}
else
{
	echo "<br />We're sorry, but you do not have administrative privileges on this site.<br />If you wish to be promoted, please contact the site administrator.<br />";
}

?>