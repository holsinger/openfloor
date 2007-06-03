<?php

function welcome_privmsg_send()
{
	global $username, $main_smarty, $current_user;

	include_once(mnminclude.'user.php');
	include_once('./3rdparty/kmessaging/class.KMessaging.php');

	$siteName = $main_smarty->get_config_vars('PLIGG_Visual_Name'); 
	
	// User ID of Admin
	define('welcome_privmsg_admin_id', '1');
	
	// Message Subject
	define('welcome_privmsg_subject', 'Welcome to '.$siteName);
	
	// Message Body
	define('welcome_privmsg_body', 'Thanks for registering on our site.  If you have any questions, be sure to visit our FAQ section. Sincerely, Webmaster');
			
	// Check User ID != 0
	if ($current_user->user_id > 0)
	{		
		$msg_subject = sanitize(welcome_privmsg_subject, 2);
		$msg_body = welcome_privmsg_body;
		$msg_to_ID = $current_user->user_id;
		$msg_from_ID = welcome_privmsg_admin_id;
		
		$message = new KMessaging(true);
		$msg_result = $message->SendMessege($msg_subject, $msg_body, $msg_from_ID, $msg_to_ID, 0);
		
		if ($msg_result != 0) {
			echo "Module Error #".$msg_result;
		}
		
	} else {
	
		// Unable to find User ID
		echo "Module Error #1";
		die;
	}
}
	
?>