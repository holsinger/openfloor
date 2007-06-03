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

// -------------------------------------------------------------------------------------
$requestID = $_REQUEST['id'];
$requestTitle = $_REQUEST['title'];

if(isset($requestTitle)){
	$requestID = $db->get_var("SELECT link_id FROM " . table_links . " WHERE `link_title_url` = '$requestTitle';");
}else{
	if(!is_numeric($requestID)){
		$requestID = $db->get_var("SELECT link_id FROM " . table_links . " WHERE `link_title_url` = '$requestID';");
	}
}

if(!isset($_REQUEST['email_to_submit'])){ // we're not submitting the form
	if(!isset($_REQUEST['draw'])){ // this is not a request to draw the form?
		if(is_numeric($requestID)) {
			$id = $requestID;
			$link = new Link;
			$link->id=$requestID;
			$link->read();
		
			$main_smarty->assign('original_id', $requestID);
		
			$main_smarty->assign('link_title', $link->title);
			$main_smarty->assign('link_content', $link->content);
			$main_smarty->assign('link_url', my_base_url . getmyurl("story", $link->id)); // internal link to the comments page
			$main_smarty->assign('user_logged_in', $current_user->user_login);
		
			$main_smarty->assign('email_subject', Email_Subject . $link->title);
			$main_smarty->assign('Default_Message', Default_Message);
		
			$main_smarty->assign('Included_Text_Part1', Included_Text_Part1);
			$main_smarty->assign('Included_Text_Part2', Included_Text_Part2);
			
		define('pagename', 'recommend'); 
	    $main_smarty->assign('pagename', pagename);	
				
		$main_smarty->assign('tpl_center', $the_template . '/recommend');
		$main_smarty->display($the_template . '/pligg.tpl');
		}
	} else { // this is a request to draw the form 
		if($_REQUEST['draw'] == "small"){ // small form -- the form's html is in recommend_small.tpl
			$htmlid = $_REQUEST['htmlid'];
			$linkid = $_REQUEST['linkid'];

			$main_smarty->assign('Default_Message', Default_Message);
			$main_smarty->assign('link_shakebox_index', $htmlid);
			$main_smarty->assign('link_id', $linkid);
			$main_smarty->assign('instpath', my_base_url . my_pligg_base . "/");
			$main_smarty->display($the_template . '/recommend_small.tpl');
		
		}
	}
} else { // we're submitting the form and sending the emails
	$requestID = $_REQUEST['original_id'];
	if(is_numeric($requestID)) {
		$id = $requestID;
		$link = new Link;
		$link->id=$requestID;
		$link->read();

		$link_url = my_base_url . getmyurl("story", $link->id);
		$headers = 'From: ' . Send_From_Email . "\r\n";

		$to = "";
		
		$cansend = 0;
		$addresses = explode(", ", $_REQUEST['email_address']);
		for($i = 0; $i <= count(addresses); $i++){
			if($addresses[$i] != ""){
				if (!check_email_address($addresses[$i])) {
					$cansend = -100;
					echo '<br>Error: ' . $addresses[$i] . ' is not a valid email address.<br>';
				} else {
					$cansend = $cansend + 10;
					//$headers .= 'Bcc: ' . $addresses[$i] . "\r\n";
					$headers .= "Bcc: " . $addresses[$i] . "\n";
				}
			}
		}
		$headers .= "Content-Type: text/plain; charset=utf-8\n";

		if(isset($_REQUEST['email_subject'])){
			$subject = $_REQUEST['email_subject'];
		} else {
			$subject = Email_Subject . $link->title;
		}
		if(isset($_REQUEST['email_message'])){
			$message = $_REQUEST['email_message'];
		} else {
			$message = Default_Message;
		} 
		if ($current_user->user_login){
		$body = $message . "\r\n\r\n" . Included_Text_Part1 ." ". $current_user->user_login .",". Included_Text_Part2 ."\r\n\r\n".$link->title." - " .strip_tags($link->content)."\r\n\r\n" ."Here is a link to the story: ". $link_url;}
		else{
		$body = $message . "\r\n\r\n" . Included_Text_Part1 ." Anonymous,". Included_Text_Part2 ."\r\n\r\n".$link->title." - " .strip_tags($link->content)."\r\n\r\n" ."Here is a link to the story: ". $link_url;}

	
		if(isset($_REQUEST['backup'])){
			$backup = $_REQUEST['backup'];
		} else {
			$backup = 2;
		}
		
		if($cansend >= 10){
			if (mail($to, $subject, $body, $headers)){
				echo "<br>Sent! <br><br>";
				if($backup > 0){echo '<input type=button onclick="window.history.go(-'.$backup.')" value="return">';}
			}else{
				echo '<p class="l-top"><span class="error">'.$main_smarty->get_config_vars('PLIGG_PassEmail_SendFail').' Error 1</span></p>';
			}
		} else {
			echo '<p class="l-top"><span class="error">'.$main_smarty->get_config_vars('PLIGG_PassEmail_SendFail').' Error 3</span></p>';
		}
	} else {
		echo '<p class="l-top"><span class="error">'.$main_smarty->get_config_vars('PLIGG_PassEmail_SendFail').' Error 2</span></p>';
	}
}
?>
