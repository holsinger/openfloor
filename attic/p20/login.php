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
$errorMsg=""; //initialize variable 

$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Login');
$navwhere['link1'] = getmyurl('loginNoVar', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Login'));
$main_smarty->assign('page_header', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Login'));
$main_smarty = do_sidebar($main_smarty);

if(isset($_GET["op"])){
	if($_GET["op"] === 'logout') {
		$current_user->Logout($_REQUEST['return']);
	}
}

if(isset($_POST["processlogin"]) || isset($_GET["processlogin"])){
	if($_POST["processlogin"] == 1) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$persistent = $_POST['persistent'];
		if($current_user->Authenticate($username, $password, $persistent) == false) {
			$errorMsg=$main_smarty->get_config_vars('PLIGG_Visual_Login_Error');} else {

			if(strlen($_REQUEST['return']) > 1) {
				$return = $_REQUEST['return'];
			} else {
				$return =  my_pligg_base.'/';
			}
			
			define('logindetails', $username . ";" . $password . ";" . $return);
			
			check_actions('login_success_pre_redirect');

			header('Location: '.$return);
			die;
		}
	}

	if($_POST["processlogin"] == 3) {
		$username = trim($_POST['username']);
		if(strlen($username) == 0){
			echo '<br /><p class="l-top"><span class="error">'._(PLIGG_Visual_Login_Forgot_Error).'</span></p>';
		}
		else {
			$user = $db->get_row("SELECT * FROM `" . table_users . "` where `user_login` = '".$username."'");
			if($user){
				$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
				$saltedlogin = generateHash($user->user_login);

				$to = $user->user_email;
				$subject = PLIGG_PassEmail_Subject;
				$body = PLIGG_PassEmail_Body . $my_base_url . $my_pligg_base . '/login.php?processlogin=4&username=' . $username . '&confirmationcode=' . $saltedlogin;
				$headers = 'From: ' . PLIGG_PassEmail_From . "\r\n";


				if(time() - strtotime($user->last_reset_request) > PLIGG_PassEmail_LimitPerSecond){
					if (mail($to, $subject, $body, $headers))
					{
						$main_smarty->assign('user_login', $user->user_login);
						$main_smarty->assign('profile_url', getmyurl('profile'));
						$main_smarty->assign('login_url', getmyurl('loginNoVar'));

						echo("<br /><p>".PLIGG_PassEmail_SendSuccess."</p>");

						$db->query('UPDATE `' . table_users . '` SET `last_reset_request` = FROM_UNIXTIME('.time().') WHERE `user_login` = "'.$username.'"');

						//$main_smarty->display($the_template . '/ForgottenPassword_Step2.tpl');
						
						define('pagename', 'login'); 
					    $main_smarty->assign('pagename', pagename);

						/*$main_smarty->assign('tpl_center', $the_template . '/ForgottenPassword_Step2');
						$main_smarty->display($the_template . '/pligg.tpl');

						die;*/
					}
					else
					{
						echo '<br /><p class="l-top"><span class="error">'.$main_smarty->get_config_vars('PLIGG_Visual_Login_Delivery_Failed').'</span></p>';
					}
				}
				else{
					echo '<br /><p class="l-top"><span class="error">'._(PLIGG_PassEmail_LimitPerSecond_Message).'</span></p>';
				}
			}
			else{
				echo '<br /><p class="l-top"><span class="error">'.$main_smarty->get_config_vars('PLIGG_Visual_Login_Does_Not_Exist').'</span></p>';
			}
		}
	}

	if($_GET["processlogin"] == 4) {
		$username = trim($_GET['username']);
		if(strlen($username) == 0){
			echo '<br /><p class="l-top"><span class="error">'._(PLIGG_Visual_Login_Forgot_Error).'</span></p>';
		}
		else {
			$confirmationcode = $_GET["confirmationcode"];
			if(generateHash($username, substr($confirmationcode, 0, SALT_LENGTH)) == $confirmationcode){
				$db->query('UPDATE `' . table_users . '` SET `user_pass` = "033700e5a7759d0663e33b18d6ca0dc2b572c20031b575750" WHERE `user_login` = "'.$username.'"');
				echo '<br />' . PLIGG_Visual_Login_Forgot_PassReset;
			}
			else{
				echo '<br /><p class="l-top"><span class="error">'._(PLIGG_Visual_Login_Forgot_ErrorBadCode).'</span></p>';
			}
		}
	}
}   
    define('pagename', 'login'); 
    $main_smarty->assign('pagename', pagename);
     
	$main_smarty->assign('errorMsg',$errorMsg);  
	$main_smarty->assign('register_url', getmyurl('register'));
	$main_smarty->assign('tpl_center', $the_template . '/login_center');
	$main_smarty->display($the_template . '/pligg.tpl');

?>