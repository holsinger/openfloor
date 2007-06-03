<?php
include_once('./3rdparty/kmessaging/class.KMessaging.php');

function messaging_check_view(){
	global $view;
	messaging_showpage($view);
}	

function messaging_showpage($page_name = ""){
 	global $db, $current_user, $main_smarty, $navwhere, $login, $user;
 
	$main_smarty->assign('page_name', $page_name);
	
	if($page_name['location'] == "index_top"){$page_name = "index";}
	
 	switch($page_name){
 		case "index":
		 	// if we are logged in
			if ($current_user->user_id > 0) {
				$message = new KMessaging(true);
				$array = $message->GetAllMesseges(5, $current_user->user_id, '', 1);
				if(is_array($array)){
					$message_count = count($array);
					$main_smarty->assign('messages', $message_count);
		
					$i = 1;
					foreach($array as $key => $val){
						if($i == 1){$msg_first = $array[$key]['id'];}
						if($i > 1){$array[$key]['prev_message_id'] = 'my_message' . ($i - 1);}
						if($i < $message_count){$array[$key]['next_message_id'] = 'my_message' . ($i + 1);}
						$array[$key]['count'] = $i;
						$array[$key]['my_message_id'] = 'my_message' . $i;
						
						$user=new User();
						$user->id = $array[$key]['sender'];
						if(!$user->read()) {
							echo "error 2";
							die;
						}
						$array[$key]['sender_name'] = $user->username;
						$user = "";
						
						$i = $i + 1;
					}
					$main_smarty->assign('rel_viewmsg', 'view_message~!~view=small_msg_view~!~msgid=' . $msg_first);

					$main_smarty->assign('msg_new_count', $i - 1);
					$main_smarty->assign('msg_array', $array);
					$main_smarty->assign('load_leightbox', "1");
				}
			}
			break;
			
			
		case "inbox":
			// setup title, navbar and breadcrumbs
			$main_smarty->assign('page_header', $user->username . ' / ' . 'message inbox');
			$navwhere['text3'] = "message inbox";
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " / " . $login . " / " . "message inbox");
		
			$message = new KMessaging(true);
			$array = $message->GetAllMesseges(5, $current_user->user_id);
			if(is_array($array)){
				$message_count = count($array);
				$main_smarty->assign('messages', $message_count);
		
				foreach($array as $key => $val){
					$user=new User();
					$user->id = $array[$key]['sender'];
					if(!$user->read()) {
						echo "error 2";
						die;
					}
					$array[$key]['sender_name'] = $user->username;
					$user = "";
				}
				$main_smarty->assign('msg_array', $array);
			}
			$main_smarty->assign('rel_viewmsg', 'view_message~!~view=small_msg_view~!~msgid=');
			$main_smarty->assign('load_leightbox', "1");
		break;
		
		case "viewfriends";
			$main_smarty->assign('load_leightbox', "1");
			// this is just to add the lightbox so we can send a message via lightbox
		break;	

		case "viewfriends2";
			$main_smarty->assign('load_leightbox', "1");
			// this is just to add the lightbox so we can send a message via lightbox
		break;	
		
		case "small_msg_view":		
			$array = messaging_get_message_details();
			$main_smarty->assign('msg_array', $array);
			$main_smarty->assign('js_reply', "lightbox_do_on_activate('view_message~!~action=reply~!~replyID=" . $array['id'] . "~!~view=small_msg_compose~!~login=" . $array['sender_name'] . "');");
			$main_smarty->assign('js_delete', "lightbox_do_on_activate('view_message~!~view=small_msg_confirm_delete~!~msgid=" . $array['id'] . "');");
			if(messaging_fade_lightbox){
				$main_smarty->assign('js_close', "Effect.Fade('overlay');Effect.Fade('view_message', {afterFinish: function(){document.getElementById('view_message').innerHTML='loading...';}});");
			}else{
				$main_smarty->assign('js_close', "document.getElementById('overlay').style.display = 'none';document.getElementById('view_message').style.display = 'none';document.getElementById('view_message').innerHTML='loading...';");
			}
			$main_smarty->display(messaging_tpl_path . 'small_show_message.tpl');
		
			die();
		break;
		
		case "small_msg_compose":		
			$main_smarty->assign('replyID', sanitize($_REQUEST['replyID'], 2));
			
			$msgToName = sanitize($_REQUEST['login'], 2);
			$main_smarty->assign('msgToName', $msgToName);
			
			if(messaging_fade_lightbox){
				$main_smarty->assign('js_close', "Effect.Fade('overlay');Effect.Fade('view_message', {afterFinish: function(){document.getElementById('view_message').innerHTML='loading...';}});");
			}else{
				$main_smarty->assign('js_close', "document.getElementById('overlay').style.display = 'none';document.getElementById('view_message').style.display = 'none';document.getElementById('view_message').innerHTML='loading...';");
			}
			$main_smarty->display(messaging_tpl_path . 'small_compose_message.tpl');
			die();
		break;		

		case "small_msg_confirm_delete":		
			$array = messaging_get_message_details();
			$main_smarty->assign('msg_array', $array);
			$main_smarty->assign('msgid', sanitize($_REQUEST['msgid'], 2));
			$main_smarty->assign('js_yes', "lightbox_do_on_activate('view_message~!~view=small_msg_do_delete~!~msgid=" . $array['id'] . "');");
			if(messaging_fade_lightbox){
				$main_smarty->assign('js_close', "Effect.Fade('overlay');Effect.Fade('view_message', {afterFinish: function(){document.getElementById('view_message').innerHTML='loading...';}});");
			}else{
				$main_smarty->assign('js_close', "document.getElementById('overlay').style.display = 'none';document.getElementById('view_message').style.display = 'none';document.getElementById('view_message').innerHTML='loading...';");
			}
			$main_smarty->display(messaging_tpl_path . 'small_confirm_delete_message.tpl');
			die();
		break;		

		case "small_msg_do_delete":		
			$array = messaging_get_message_details();
			$message = new KMessaging(true);
			$result = $message->DeleteMessege(sanitize($_REQUEST['msgid'], 2));
			$main_smarty->assign('msgid', sanitize($_REQUEST['msgid'], 2));
			if(messaging_fade_lightbox){
				$main_smarty->assign('js_close', "Effect.Fade('overlay');Effect.Fade('view_message', {afterFinish: function(){document.getElementById('view_message').innerHTML='loading...';}});");
			}else{
				$main_smarty->assign('js_close', "document.getElementById('overlay').style.display = 'none';document.getElementById('view_message').style.display = 'none';document.getElementById('view_message').innerHTML='loading...';");
			}
			$main_smarty->assign('js_fade', "Effect.Fade('msg_row_" . $array['id'] . "');");
			$main_smarty->display(messaging_tpl_path . 'small_deleted_message.tpl');
			die();
		break;		
		
		case "sendmessage_send":
		
			$msg_subject = sanitize($_REQUEST['msg_subject'], 2);
			$msg_body = sanitize($_REQUEST['msg_body'], 2);
			$msg_to = sanitize($_REQUEST['msg_to'], 2);
			
			$user_to=new User();
			$user_to->username = $msg_to;
			if(!$user_to->read()) {
				$main_smarty->assign('message', 'The person you are trying to send a message to does not exist!');
				if(messaging_fade_lightbox){
					$main_smarty->assign('js_close', "Effect.Fade('overlay');Effect.Fade('view_message', {afterFinish: function(){document.getElementById('view_message').innerHTML='loading...';}});");
				}else{
					$main_smarty->assign('js_close', "document.getElementById('overlay').style.display = 'none';document.getElementById('view_message').style.display = 'none';document.getElementById('view_message').innerHTML='loading...';");
				}
				$main_smarty->display(messaging_tpl_path . 'error.tpl');
				die;
			}
			$msg_to_ID = $user_to->id;
			$msg_from_ID = $current_user->user_id;
			
			$message = new KMessaging(true);
			$msg_result = $message->SendMessege($msg_subject,$msg_body,$msg_from_ID,$msg_to_ID,0);
			if ($msg_result != 0){
				echo "there was an error. error number " . $msg_result;
			} else {
				if(messaging_fade_lightbox){
					$main_smarty->assign('js_close', "Effect.Fade('overlay');Effect.Fade('view_message', {afterFinish: function(){document.getElementById('view_message').innerHTML='loading...';}});");
				}else{
					$main_smarty->assign('js_close', "document.getElementById('overlay').style.display = 'none';document.getElementById('view_message').style.display = 'none';document.getElementById('view_message').innerHTML='loading...';");
				}
				$main_smarty->display(messaging_tpl_path . 'small_send_success.tpl');
			}
		
			die();
		break;
	}
}


function messaging_get_message_details($msgID = ''){	
	global $db, $current_user, $main_smarty;
	if($msgID == ""){$msgID = sanitize($_REQUEST['msgid'], 2);}
	//echo $msgID;
	$message = new KMessaging(true);
	$array = $message->GetMessege($msgID);
	
	// check to make sure this is our message
	if($array['receiver'] == $current_user->user_id){
		$message->MarkAsRead($msgID);
		$thisuser=new User();
		$thisuser->id = $array['sender'];
		if(!$thisuser->read()) {
			$main_smarty->assign('message', 'The person you are trying to send a message to does not exist!');
			if(messaging_fade_lightbox){
				$main_smarty->assign('js_close', "Effect.Fade('overlay');Effect.Fade('view_message', {afterFinish: function(){document.getElementById('view_message').innerHTML='loading...';}});");
			}else{
				$main_smarty->assign('js_close', "document.getElementById('overlay').style.display = 'none';document.getElementById('view_message').style.display = 'none';document.getElementById('view_message').innerHTML='loading...';");
			}
			$main_smarty->display(messaging_tpl_path . 'error.tpl');
			die;
		}
		$array['sender_name'] = $thisuser->username;
		$thisuser = "";
		return $array;
	} else {
		$main_smarty->assign('message', 'This is not your message!');
		if(messaging_fade_lightbox){
			$main_smarty->assign('js_close', "Effect.Fade('overlay');Effect.Fade('view_message', {afterFinish: function(){document.getElementById('view_message').innerHTML='loading...';}});");
		}else{
			$main_smarty->assign('js_close', "document.getElementById('overlay').style.display = 'none';document.getElementById('view_message').style.display = 'none';document.getElementById('view_message').innerHTML='loading...';");
		}
		$main_smarty->display(messaging_tpl_path . 'error.tpl');
		die();
	}	
}




?>