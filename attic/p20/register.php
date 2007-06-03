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
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'ts.php');


if(isset($_POST["process"])) {
	switch ($_POST["process"]) {
		case 1:
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_RegisterStep2');
			$navwhere['link1'] = getmyurl('register', '');
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_RegisterStep2'));
			$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_RegisterStep2'));
			break;
	}
} else {
	$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Register');
	$navwhere['link1'] = getmyurl('register', '');
	$main_smarty->assign('navbar_where', $navwhere);
	$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Register'));
	$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Register'));
}

define('pagename', 'register'); 
$main_smarty->assign('pagename', pagename);
$main_smarty = do_sidebar($main_smarty);

$main_smarty->assign('tpl_center', $the_template . '/register_center');
$main_smarty->display($the_template . '/pligg.tpl');


function do_register0() {
	global $main_smarty, $the_template;
	$main_smarty->display($the_template . '/register_step_1.tpl');
}

function verify_reg($username, $email, $password, $password2) {
	global $main_smarty, $the_template;
	
	if(!isset($username) || strlen($username) < 3) {
		$main_smarty->assign('register_error_text', "usertooshort");
		$main_smarty->display($the_template . '/register_error.tpl');
		$error = true;
	}
	
	if(!preg_match('/^[a-zA-Z0-9_\-\.@]+$/', $username)) {
		$main_smarty->assign('register_error_text', "usernameinvalid");
		$main_smarty->display($the_template . '/register_error.tpl');
		$error = true;
	}

	if(user_exists(trim($username)) ) {
		$main_smarty->assign('register_error_text', "usernameexists");
		$main_smarty->display($the_template . '/register_error.tpl');
		$error = true;
	}
	if(!check_email(trim($email))) {
		$main_smarty->assign('register_error_text', "bademail");
		$main_smarty->display($the_template . '/register_error.tpl');
		$error = true;
	}
	if(email_exists(trim($email)) ) {
		$main_smarty->assign('register_error_text', "emailexists");
		$main_smarty->display($the_template . '/register_error.tpl');
		$error = true;
	}
	if(strlen($password) < 5 ) {
		$main_smarty->assign('register_error_text', "fivecharpass");
		$main_smarty->display($the_template . '/register_error.tpl');
		$error = true;
	}
	if($password !== $password2) {
		$main_smarty->assign('register_error_text', "nopassmatch");
		$main_smarty->display($the_template . '/register_error.tpl');
		$error = true;
	}
	
	
	return $error;
	
}

function do_register1() {
	global $main_smarty, $the_template;

	$error = false;
	$error = verify_reg($_POST["username"], $_POST["email"], $_POST["password"], $_POST["password2"]);
	
	if ($error) return;

	if(enable_captcha == 'true') {
	$main_smarty->assign('reghash', generateHash($_POST["username"].$_POST["email"].$_POST["password"]));
	$main_smarty->assign('ts_random', rand(10000000, 99999999));
	$main_smarty->display($the_template . '/register_step_2.tpl');
	}
	else {
	do_register2();
	}
}

function do_register2() {
	global $db, $current_user, $main_smarty, $the_template;
	
	if(enable_captcha == 'true') {
	if (!ts_is_human()) {
		$main_smarty->assign('register_error_text', "badcode");
		$main_smarty->display($the_template . '/register_error.tpl');
		return;
	}

	$reghash = $_POST["reghash"];
	$mycombo = $_POST["username"].$_POST["email"].$_POST["password"];
	if(generateHash($mycombo, substr($reghash, 0, SALT_LENGTH)) != $reghash){
		loghack('Register Step 2', 'username: ' . $_POST["username"].'|email: '.$_POST["email"]);
	}
	}

	$error = false;
	$error = verify_reg($_POST["username"], $_POST["email"], $_POST["password"], $_POST["password"]); 
	//																																					(use password here not password2)
	if ($error) return;

	$username=$db->escape(trim($_POST['username']));
	$password=$db->escape(trim($_POST['password']));
	$userip=$_SERVER['REMOTE_ADDR'];
	$saltedpass=generateHash($password);
	$email=$db->escape(trim($_POST['email']));
	if (!user_exists($username)) {
		if ($db->query("INSERT INTO " . table_users . " (user_login, user_email, user_pass, user_date, user_ip) VALUES ('$username', '$email', '$saltedpass', now(), '$userip')")) {
			if($current_user->Authenticate($username, $password, false) == false) {
				$main_smarty->assign('register_error_text', "errorinserting");
				$main_smarty->display($the_template . '/register_error.tpl');
			} else {
				
				define('registerdetails', $username . ';' . $password . ';' . $email . ';' . $return);
				check_actions('register_success_pre_redirect');
				
				header('Location: ' . getmyurl('user', $username));
			}
		} else {
			$main_smarty->assign('register_error_text', "errorinserting");
			$main_smarty->display($the_template . '/register_error.tpl');
		}
	} else {
		$main_smarty->assign('register_error_text', "usernameexists");
		$main_smarty->display($the_template . '/register_error.tpl');
	}
}
?>