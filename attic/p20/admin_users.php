<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
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
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');
// Steef: replaced 'admin_template.tpl' with 'admin_template.tpl'
// -------------------------------------------------------------------------------------

	force_authentication();
	$smarty = $main_smarty;

	$amIgod = 0;
	$amIgod = $amIgod + checklevel('god');
	$smarty->assign('amIgod', $amIgod);

	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{

		if(isset($_GET["mode"])) {
			if ($_GET["mode"] == "view"){
				$usersql = mysql_query('SELECT * FROM ' . table_users . ' where user_login="'.$_GET["user"].'"');
				$userdata = array();
			  while ($rows = mysql_fetch_array ($usersql, MYSQL_ASSOC)) array_push ($userdata, $rows);
				$smarty->assign('userdata', $userdata);
				$linkcount=$db->get_var('SELECT count(*) FROM ' . table_links . ' where link_author="'.$userdata[0][user_id].'"');
				$smarty->assign('linkcount', $linkcount);
				$commentcount=$db->get_var('SELECT count(*) FROM ' . table_comments . ' where comment_user_id="'.$userdata[0][user_id].'"');
				$smarty->assign('commentcount', $commentcount);

				// breadcrumbs
					$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
					$navwhere['link1'] = getmyurl('admin', '');
					$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
					$navwhere['link2'] = my_pligg_base . "/admin_users.php";
					$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_View_User');
					$smarty->assign('navbar_where', $navwhere);
					$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
				// breadcrumbs
				
				define('pagename', 'admin_users'); 
     		    $main_smarty->assign('pagename', pagename);

				$user=new User();
				$user->username = $_GET["user"];
				if(!$user->read()) {
					echo "error 2";
					die;
				}

				check_actions('admin_users_view');

				$smarty->assign('tpl_center', $the_template . '/admin_templates/user_show_center');
				$smarty->display($the_template . '/pligg.tpl');
			}

			if ($_GET["mode"] == "edit"){
				$usersql = mysql_query('SELECT * FROM ' . table_users . ' where user_login="'.$_GET["user"].'"');
				$userdata = array();
			  while ($rows = mysql_fetch_array ($usersql, MYSQL_ASSOC)) array_push ($userdata, $rows);
				$smarty->assign('userdata', $userdata);
				$smarty->assign('levels', array('normal','god','admin'));

				// breadcrumbs
					$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
					$navwhere['link1'] = getmyurl('admin', '');
					$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
					$navwhere['link2'] = my_pligg_base . "/admin_users.php";
					$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Edit_User');
					$smarty->assign('navbar_where', $navwhere);
					$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
				// breadcrumbs
				
				define('pagename', 'admin_users'); 
     		    $main_smarty->assign('pagename', pagename);

				$user=new User();
				$user->username = $_GET["user"];
				if(!$user->read()) {
					echo "error 2";
					die;
				}

				check_actions('admin_users_edit');
		
				$smarty->assign('tpl_center', $the_template . '/admin_templates/user_edit_center');
				$smarty->display($the_template . '/pligg.tpl');
			}
			
			
			if ($_GET["mode"] == $main_smarty->get_config_vars('PLIGG_Visual_Profile_Save')){
				$user = $db->get_row('SELECT * FROM ' . table_users . ' where user_login="'.$_GET["user"].'"');
				if ($user) {
					$userdata=new User();
					$userdata->username = $user->user_login;
					if(!$userdata->read()) {
						echo "Error reading user data.";
						die;
					}
					check_actions('admin_users_save');
					$userdata->username=trim($_GET["login"]);
					$userdata->level=trim($_GET["level"]);
					$userdata->email=trim($_GET["email"]);
					$userdata->store();
	
					// breadcrumbs
						$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
						$navwhere['link1'] = getmyurl('admin', '');
						$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
						$navwhere['link2'] = my_pligg_base . "/admin_users.php";
						$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Edit_User_Data_Saved');
						$smarty->assign('navbar_where', $navwhere);
						$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					// breadcrumbs
					
					define('pagename', 'admin_users'); 
     		        $main_smarty->assign('pagename', pagename);
	
					$smarty->assign('tpl_center', $the_template . '/admin_templates/user_data_saved_center');
					$smarty->display($the_template . '/pligg.tpl');
				}
				else{showmyerror('userdoesntexist');}
			}



			if ($_GET["mode"] == "resetpass"){
				$user= $db->get_row('SELECT * FROM ' . table_users . ' where user_login="'.$_GET["user"].'"');
				if ($user) {
					$db->query('UPDATE `' . table_users . '` SET `user_pass` = "033700e5a7759d0663e33b18d6ca0dc2b572c20031b575750" WHERE `user_login` = "'.$_GET["user"].'"');

					// breadcrumbs
						$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
						$navwhere['link1'] = getmyurl('admin', '');
						$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
						$navwhere['link2'] = my_pligg_base . "/admin_users.php";
						$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Reset_Pass');
						$smarty->assign('navbar_where', $navwhere);
						$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					// breadcrumbs
					
					define('pagename', 'admin_users'); 
     		        $main_smarty->assign('pagename', pagename);

					$smarty->assign('tpl_center', $the_template . '/admin_templates/user_password_reset_center');
					$smarty->display($the_template . '/pligg.tpl');
				}
				else{showmyerror('userdoesntexist');}
			}


			if ($_GET["mode"] == "disable"){
				if($_GET["user"] == "god"){echo "You can't disable this user";} else {
				$user= $db->get_row('SELECT * FROM ' . table_users . ' where user_login="'.$_GET["user"].'"');
				if ($user) {
						
						// breadcrumbs
							$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
							$navwhere['link1'] = getmyurl('admin', '');
							$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
							$navwhere['link2'] = my_pligg_base . "/admin_users.php";
							$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Disable');
							$smarty->assign('navbar_where', $navwhere);
							$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
						// breadcrumbs
						
					define('pagename', 'admin_users'); 
					$main_smarty->assign('pagename', pagename);	
					$main_smarty->assign('user', $_GET["user"]);	
					
					$main_smarty->assign('tpl_center', $the_template . '/admin_templates/user_disable_step1_center');
					$main_smarty->display($the_template . '/pligg.tpl');
				}
				else{showmyerror('userdoesntexist');}
			}
			}

			if ($_GET["mode"] == "yesdisable"){
				$user= $db->get_row('SELECT * FROM ' . table_users . ' where user_login="'.$_GET["user"].'"');
				if ($user) {
					$db->query('UPDATE `' . table_users . '` SET `user_pass` = "63205e60098a9758101eeff9df0912ccaaca6fca3e50cdce3" WHERE `user_login` = "'.$_GET["user"].'"');
	
					// breadcrumbs
						$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
						$navwhere['link1'] = getmyurl('admin', '');
						$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
						$navwhere['link2'] = my_pligg_base . "/admin_users.php";
						$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Disable_2');
						$smarty->assign('navbar_where', $navwhere);
						$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					// breadcrumbs
					
					define('pagename', 'admin_users'); 
					$main_smarty->assign('pagename', pagename);
	
					$main_smarty->assign('tpl_center', $the_template . '/admin_templates/user_disable_final_center');
					$main_smarty->display($the_template . '/pligg.tpl');
				}
				else{showmyerror('userdoesntexist');}
			}

			if ($_GET["mode"] == "killspam"){
			    if($_GET["user"] == "god"){echo "You can't killspam this user";} else {
				$user= $db->get_row('SELECT * FROM ' . table_users . ' where user_login="'.$_GET["user"].'"');
				if ($user) {

					// breadcrumbs
						$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
						$navwhere['link1'] = getmyurl('admin', '');
						$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
						$navwhere['link2'] = my_pligg_base . "/admin_users.php";
						$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Killspam');
						$smarty->assign('navbar_where', $navwhere);
						$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					// breadcrumbs
					
					define('pagename', 'admin_users'); 
     		        $main_smarty->assign('pagename', pagename);
					$main_smarty->assign('user', $_GET["user"]);
					$main_smarty->assign('id', $_GET["id"]);
		
					$smarty->assign('tpl_center', $the_template . '/admin_templates/user_killspam_step1_center');
					$smarty->display($the_template . '/pligg.tpl');
				}
				else{showmyerror('userdoesntexist');}
			}
			}
			
			if ($_GET["mode"] == "yeskillspam"){
				$user= $db->get_row('SELECT * FROM ' . table_users .','. table_comments .','. table_links .' where user_login="'.$_GET["user"].'"');
				if ($user) {
					
					$db->query('DELETE FROM `' . table_links . '` WHERE `link_author` = "'.$_GET["id"].'"');
					$db->query('UPDATE `' . table_comments . '` SET `comment_content` = "This comment has been deleted by an administrator" WHERE `comment_user_id` = "'.$_GET["id"].'"');
					$db->query('UPDATE `' . table_users . '` SET `user_pass` = "63205e60098a9758101eeff9df0912ccaaca6fca3e50cdce3" WHERE `user_login` = "'.$_GET["user"].'"');
					
					// breadcrumbs
						$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
						$navwhere['link1'] = getmyurl('admin', '');
						$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
						$navwhere['link2'] = my_pligg_base . "/admin_users.php";
						$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Disable_2');
						//$navwhere['link3'] = my_pligg_base . "/admin_users.php";
						$smarty->assign('navbar_where', $navwhere);
						$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					// breadcrumbs
					
					define('pagename', 'admin_users'); 
					$main_smarty->assign('pagename', pagename);
	
					$smarty->assign('tpl_center', $the_template . '/admin_templates/user_killspam_final_center');
					$smarty->display($the_template . '/pligg.tpl');
				}
				else{showmyerror('userdoesntexist');}
			}


			if ($_GET["mode"] == "viewlinks"){
				$usersql = mysql_query('SELECT * FROM ' . table_users . ' where user_login="'.$_GET["user"].'"');
				$userdata = array();
			  while ($rows = mysql_fetch_array ($usersql, MYSQL_ASSOC)) array_push ($userdata, $rows);
				$smarty->assign('userdata', $userdata);

				$usersql = mysql_query('SELECT * FROM ' . table_links . ' where link_author="'.$userdata[0][user_id].'"');
				$links = array();
			  while ($rows = mysql_fetch_array ($usersql, MYSQL_ASSOC)) array_push ($links, $rows);
				$smarty->assign('links', $links);

				// breadcrumbs
					$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
					$navwhere['link1'] = getmyurl('admin', '');
					$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
					$navwhere['link2'] = my_pligg_base . "/admin_users.php";
					$smarty->assign('navbar_where', $navwhere);
					$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
				// breadcrumbs
        
				define('pagename', 'admin_users'); 
    			$main_smarty->assign('pagename', pagename);
		 
				$smarty->assign('tpl_center', $the_template . '/admin_templates/user_view_links_center');
				$smarty->display($the_template . '/pligg.tpl');
			}


			if ($_GET["mode"] == "viewcomments"){
				$usersql = mysql_query('SELECT * FROM ' . table_users . ' where user_login="'.$_GET["user"].'"');
				$userdata = array();
			  while ($rows = mysql_fetch_array ($usersql, MYSQL_ASSOC)) array_push ($userdata, $rows);
				$smarty->assign('userdata', $userdata);

				$usersql = mysql_query('SELECT * FROM ' . table_comments . ' where comment_user_id="'.$userdata[0][user_id].'"');
				$comments = array();
			  while ($rows = mysql_fetch_array ($usersql, MYSQL_ASSOC)) array_push ($comments, $rows);
				$smarty->assign('comments', $comments);

				// breadcrumbs
					$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
					$navwhere['link1'] = getmyurl('admin', '');
					$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
					$navwhere['link2'] = my_pligg_base . "/admin_users.php";
					$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_View_Comments');
					$smarty->assign('navbar_where', $navwhere);
					$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
				// breadcrumbs
				
				define('pagename', 'admin_users'); 
   		        $main_smarty->assign('pagename', pagename);

				$smarty->assign('tpl_center', $the_template . '/admin_templates/user_view_comments_center');
				$smarty->display($the_template . '/pligg.tpl');
			}



		}
		else{
			
			// No options are selected, so show the list of users.
			$users = mysql_query("SELECT * FROM " . table_users . "");
			$userlist = array();
		  while ($rows = mysql_fetch_array ($users, MYSQL_ASSOC)) array_push ($userlist, $rows);
			$smarty->assign('userlist', $userlist);

			// breadcrumbs
				$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
				$navwhere['link1'] = getmyurl('admin', '');
				$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
				$navwhere['link2'] = my_pligg_base . "/admin_users.php";
				$smarty->assign('navbar_where', $navwhere);
				$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
			// breadcrumbs
			
			define('pagename', 'admin_users'); 
	        $main_smarty->assign('pagename', pagename);

			$smarty->assign('tpl_center', $the_template . '/admin_templates/user_listall_center');
			$smarty->display($the_template . '/pligg.tpl');

		} 		
	}
	else
	{
		echo 'not for you! go away!';
	}		
		
	
	

function showmyerror()
{
	global $smarty;
	$smarty->assign('user', $_GET["user"]);

	// breadcrumbs
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_1');
		$navwhere['link2'] = my_pligg_base . "/admin_users.php";
		$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_User_Does_Not_Exist');
		$smarty->assign('navbar_where', $navwhere);
		$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
	// breadcrumbs
	
	define('pagename', 'admin_users'); 
    $main_smarty->assign('pagename', pagename);

	$smarty->assign('tpl_center', $the_template . '/admin_templates/user_doesnt_exist_center');
	$smarty->display($the_template . '/pligg.tpl');
}				
?>