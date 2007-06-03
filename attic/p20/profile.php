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

// -------------------------------------------------------------------------------------

$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Profile_ModifyProfile');
$navwhere['link1'] = getmyurl('profile', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Profile_ModifyProfile'));


if ($current_user->user_id > 0 && $current_user->authenticated) {
		$login=$current_user->user_login;
} else {
		header('Location: ./');
		die;
}

$user=new User();
$user->username = $login;
if(!$user->read()) {
	echo "error 2";
	die;
}



if($_POST["avatar"] == "uploaded" && Enable_User_Upload_Avatar == true){  


	$user_image_path = "avatars/user_uploaded" . "/";
	$user_image_apath = "/" . $user_image_path;
	$allowedFileTypes = array("image/jpeg","image/gif","image/png",'image/x-png','image/pjpeg');
	unset($imagename);

	if(!isset($_FILES) || isset($HTTP_POST_FILES)) {
		// for php < 4.1.0		
		//$_FILES = $HTTP_POST_FILES;
	}
	
	$myfile = $_FILES['image_file']['name'];
	$imagename = basename($myfile);

	$mytmpfile = $_FILES['image_file']['tmp_name'];

	if(!in_array($_FILES['image_file']['type'],$allowedFileTypes)){
		$error['Type'] = 'Only these file types are allowed : jpeg, gif, png';
	}
 
	if(empty($error))	{
		$imagesize = getimagesize($mytmpfile);
		$width = $imagesize[0];
		$height = $imagesize[1];	
		
		$imagename = $current_user->user_login . "_original.jpg";
		
		$newimage = $user_image_path . $imagename ;

		$result = @move_uploaded_file($_FILES['image_file']['tmp_name'], $newimage);
		if(empty($result))
			$error["result"] = "There was an error moving the uploaded file.";
		}			
		
		// thanks to "Ciprian Voicu" for "Pictoru's Thumb"
		include mnminclude . "class.pThumb.php";
		$img=new pThumb();
		$img->pSetSize(Avatar_Large, Avatar_Large);
		$img->pSetQuality(100);
		$img->pCreate($newimage);
		$img->pSave($user_image_path . $current_user->user_login . "_".Avatar_Large.".jpg");
		$img = "";
		
		// thanks to "Ciprian Voicu" for "Pictoru's Thumb"
		$img=new pThumb();
		$img->pSetSize(Avatar_Small, Avatar_Small);
		$img->pSetQuality(100);
		$img->pCreate($newimage);
		$img->pSave($user_image_path . $current_user->user_login . "_".Avatar_Small.".jpg");
		$img = "";
			
	}




if(is_array($error))
{
while(list($key, $val) = each($error))
{
echo $val;
echo "<br>";
}
}


show_profile();



function show_profile() {
	global $user, $main_smarty, $the_template;


	$savemsg = save_profile();
	$main_smarty->assign('savemsg', $savemsg);

$main_smarty->assign('UseAvatars', do_we_use_avatars());
$main_smarty->assign('Avatar_ImgLarge', get_avatar('large', $user->avatar, $user->username, $user->email));
$main_smarty->assign('Avatar_ImgSmall', get_avatar('small', $user->avatar, $user->username, $user->email));

check_actions('profile_show');

$main_smarty->assign('user_id', $user->id);
$main_smarty->assign('user_email', $user->email);
$main_smarty->assign('user_login', $user->username);
$main_smarty->assign('user_names', $user->names);
$main_smarty->assign('user_username', $user->username);
$main_smarty->assign('user_url', $user->url);
$main_smarty->assign('user_publicemail', $user->public_email);
$main_smarty->assign('user_location', $user->location);
$main_smarty->assign('user_occupation', $user->occupation);
$main_smarty->assign('user_aim', $user->aim);
$main_smarty->assign('user_msn', $user->msn);
$main_smarty->assign('user_yahoo', $user->yahoo);
$main_smarty->assign('user_gtalk', $user->gtalk);
$main_smarty->assign('user_skype', $user->skype);
$main_smarty->assign('user_irc', $user->irc);
$main_smarty->assign('user_karma', $user->karma);
$main_smarty->assign('user_joined', get_date($user->date));
$main_smarty->assign('user_avatar_source', $user->avatar_source);
$user->all_stats();
$main_smarty->assign('user_total_links', $user->total_links);
$main_smarty->assign('user_published_links', $user->published_links);
$main_smarty->assign('user_total_comments', $user->total_comments);
$main_smarty->assign('user_total_votes', $user->total_votes);
$main_smarty->assign('user_published_votes', $user->published_votes);
	
	
define('pagename', 'profile'); 
$main_smarty->assign('pagename', pagename);

$main_smarty->assign('tpl_center', $the_template . '/profile_center');
$main_smarty->display($the_template . '/pligg.tpl');

	
}

function cleanit($value){
	$value = strip_tags($value);
	$value = trim($value);
	return $value;
}


function save_profile() {
	global $user, $current_user, $db;
	
	if(!isset($_POST['save_profile']) || !isset($_POST['process']) || $_POST['user_id'] != $current_user->user_id ) return;
	if(!check_email(cleanit($_POST['email']))) {
		echo '<p class="form-error">'._(PLIGG_Visual_Profile_BadEmail).'</p>';
	} else {
		$user->email=cleanit($_POST['email']);
	}
	$user->url=cleanit($_POST['url']);
	$user->public_email=cleanit($_POST['public_email']);
	$user->location=cleanit($_POST['location']);
	$user->occupation=cleanit($_POST['occupation']);
	$user->aim=cleanit($_POST['aim']);
	$user->msn=cleanit($_POST['msn']);
	$user->yahoo=cleanit($_POST['yahoo']);
	$user->gtalk=cleanit($_POST['gtalk']);
	$user->skype=cleanit($_POST['skype']);
	$user->irc=cleanit($_POST['irc']);
	$user->names=cleanit($_POST['names']);
	
	check_actions('profile_save');
	
	$avatar_source = cleanit($_POST['avatarsource']);
	if($avatar_source != "" && $avatar_source != "useruploaded"){
		loghack('Updating profile, avatar source is not one of the list options.', 'username: ' . $_POST["username"].'|email: '.$_POST["email"]);
		$avatar_source == "";
	}
	$user->avatar_source=$avatar_source;
	
	if(!empty($_POST['password']) || !empty($_POST['password2'])) {
		$oldpass = $_POST['oldpassword'];
		$userX=$db->get_row("SELECT user_id, user_pass, user_login FROM " . table_users . " WHERE user_login = '".$user->username."'");
		$saltedpass=generateHash($oldpass, substr($userX->user_pass, 0, SALT_LENGTH));

		if($userX->user_pass == $saltedpass){
		if($_POST['password'] !== $_POST['password2']) {
				$msg = '<p align=center><span class=error>'._(PLIGG_Visual_Profile_BadPass).'</span></p>';
				return $msg;
		} else {
			$user->pass=trim($_POST['password']);
				$msg = '<p align=center><span class=error>'._(PLIGG_Visual_Profile_PassUpdated).'</span></p>';
			}
		} else {
			$msg = '<p align=center><span class=error>'.PLIGG_Visual_Profile_BadOldPass.'</span></p>';
			return $msg;
		}
	}
	$user->store();
	$user->read();
	$current_user->Authenticate($user->username, $user->pass);
	if(!$msg){$msg = '<p align=center><span class=error>'._(PLIGG_Visual_Profile_DataUpdated).'</span></p>';}
	return $msg;
}

?>