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
include(mnminclude.'smartyvariables.php');

// -------------------------------------------------------------------------------------


$main_smarty->assign('Story_Content_Tags_To_Allow', htmlspecialchars(Story_Content_Tags_To_Allow));

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');
$main_smarty->assign('isAdmin', $canIhaveAccess);

if(isset($_GET['id'])){
	$theid = strip_tags($_GET['id']);
}
if(isset($_POST['id'])){
	$theid = strip_tags($_POST['id']);
}

$link = $db->get_row("SELECT link_id, link_author FROM " . table_links . " WHERE link_id=".$theid.";");
if ($link) {
	if ($link->link_author==$current_user->user_id || $current_user->user_level == "admin" || $current_user->user_level == "god")
	{
		if(isset($_POST["id"])) {
			$linkres=new Link;
			$linkres->id=$link_id = strip_tags($_POST['id']);
			$linkres->read();

			if(isset($_POST["notify"]))
			{
				if($_POST["notify"] == "yes")
				{
					$link_author = $db->get_col("SELECT link_author FROM " . table_links . " WHERE link_id=".$theid.";");
					$user = $db->get_row("SELECT * FROM " . table_users . " WHERE user_id=".$link_author[0].";");

					$to = $user->user_email;
					$subject = $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_Subject');
					$body = $user->user_login . ", \r\n\r\n" . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_AdminMadeChange') . "\r\n";
					$body = $body . strtolower(strtok($_SERVER['SERVER_PROTOCOL'], '/')).'://'.$_SERVER['HTTP_HOST'] . getmyurl('story', $_POST['id']) . "\r\n\r\n";
					if ($linkres->category != $_POST["category"]){$body = $body . $main_smarty->get_config_vars('PLIGG_Visual_Submit2_Category') . " change\r\n" . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_PreviousText') . ": " . $linkres->category . "\r\n" . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_NewText') . ": " . $_POST["category"] . "\r\n\r\n";}
					if ($linkres->title != $_POST["title"]){$body = $body . $main_smarty->get_config_vars('PLIGG_Visual_Submit2_Title') . " change\r\n" . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_PreviousText') . ": " . $linkres->title . "\r\n" . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_NewText') . ": " . $_POST["title"] . "\r\n\r\n";}
					if ($linkres->content != $_POST["bodytext"]){$body = $body . $main_smarty->get_config_vars('PLIGG_Visual_Submit2_Description') . " change\r\n" . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_PreviousText') . ": " . $linkres->content . "\r\n" . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_NewText') . ": " . $_POST["bodytext"] . "\r\n\r\n";}
					if ($linkres->tags != tags_normalize_string(strip_tags(trim($_POST['tags'])))){$body = $body . $main_smarty->get_config_vars('PLIGG_Visual_Submit2_Tags') . " change\r\n" . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_PreviousText') . ": " . $linkres->tags . "\r\n" . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_NewText') . ": " . tags_normalize_string(strip_tags(trim($_POST['tags']))) . "\r\n\r\n";}
					$body = $body . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Email_ReasonText') . ": ";
					if ($_POST["reason"] == "other")
						{$body = $body . $_POST["otherreason"];}
					else
						{
							$body = $body . $main_smarty->get_config_vars('PLIGG_Visual_EditStory_Reason_' . $_POST["reason"]);
						}
					$headers = 'From: ' . PLIGG_PassEmail_From . "\r\n";
					if (!mail($to, $subject, $body, $headers))
					{
						echo '<br /><p class="l-top"><span class="error">'._(PLIGG_PassEmail_SendFail).'</span></p>';
						die;
					}
				}
			}

			if($canIhaveAccess == 1)
			{
				$url = htmlspecialchars(strip_tags(trim($_POST['url'])));
				$linkres->url=$url;
			}

			$linkres->category=$_POST['category'];
			if($linkres->title != strip_tags(trim($_POST['title']))){
				$linkres->title = strip_tags(trim($_POST['title']));
				$linkres->title_url = makeUrlFriendly($linkres->title);
			}
			$linkres->content = strip_tags(trim($_POST['bodytext']), Story_Content_Tags_To_Allow);
			$linkres->tags = tags_normalize_string(strip_tags(trim($_POST['tags'])));
			if($_POST['summarytext'] == ""){
				$linkres->link_summary = utf8_substr(strip_tags(trim($_POST['bodytext']), Story_Content_Tags_To_Allow), 0, StorySummary_ContentTruncate - 1);
				$linkres->link_summary = str_replace("\n", "<br />", $linkres->link_summary);				
			} else {
				$linkres->link_summary = $db->escape($_POST['summarytext']);
				$linkres->link_summary = strip_tags(trim($linkres->link_summary), Story_Content_Tags_To_Allow);
        $linkres->link_summary = str_replace("\n", "<br />", $linkres->link_summary);
				if(strlen($linkres->link_summary) > StorySummary_ContentTruncate){
					loghack('SubmitAStory-SummaryGreaterThanLimit', 'username: ' . $_POST["username"].'|email: '.$_POST["email"], true);
					$linkres->link_summary = utf8_substr($linkres->link_summary, 0, StorySummary_ContentTruncate - 1);
					$linkres->link_summary = str_replace("\n", "<br />", $linkres->link_summary);
				}
			}

			$linkres->link_field1 = trim($_POST['link_field1']);
			$linkres->link_field2 = trim($_POST['link_field2']);
			$linkres->link_field3 = trim($_POST['link_field3']);
			$linkres->link_field4 = trim($_POST['link_field4']);
			$linkres->link_field5 = trim($_POST['link_field5']);
			$linkres->link_field6 = trim($_POST['link_field6']);
			$linkres->link_field7 = trim($_POST['link_field7']);
			$linkres->link_field8 = trim($_POST['link_field8']);
			$linkres->link_field9 = trim($_POST['link_field9']);
			$linkres->link_field10 = trim($_POST['link_field10']);
			$linkres->link_field11 = trim($_POST['link_field11']);
			$linkres->link_field12 = trim($_POST['link_field12']);
			$linkres->link_field13 = trim($_POST['link_field13']);
			$linkres->link_field14 = trim($_POST['link_field14']);
			$linkres->link_field15 = trim($_POST['link_field15']);

      // Steef: replace newlines for linebreaks
      $linkres->content = str_replace("\n", "<br />", $linkres->content);

			if (link_errors($linkres)) {
				return;
			}

			tags_insert_string($linkres->id, $dblang, $linkres->tags);
			$linkres->store();
			header('Location: ' . getmyurl('story', $_POST['id']));
		}
		else
		{
			$linkres=new Link;

			$edit = false;

			$link_id = $_GET['id'];
			$linkres->id=$link_id;
			$linkres->read();
			$link_title = $linkres->title;
			$link_content = str_replace("<br />", "\n", $linkres->content);
			$link_category=$linkres->category;
			$link_summary = $linkres->link_summary;
			$link_summary = str_replace("<br />", "\n", $link_summary);
			
			$main_smarty->assign('enable_tags', Enable_Tags);
			$main_smarty->assign('submit_url', $linkres->url);
			$main_smarty->assign('submit_url_title', $linkres->url_title);
			$main_smarty->assign('submit_id', $linkres->id);
			$main_smarty->assign('submit_type', $linkres->type());
			$main_smarty->assign('submit_title', $link_title);
			$main_smarty->assign('submit_content', $link_content);
			$main_smarty->assign('submit_category', $link_category);
			if(isset($trackback)){$main_smarty->assign('submit_trackback', $trackback);}
			$main_smarty->assign('SubmitSummary_Allow_Edit', SubmitSummary_Allow_Edit);
			$main_smarty->assign('StorySummary_ContentTruncate', StorySummary_ContentTruncate);
			$main_smarty->assign('submit_summary', $link_summary);
			
			$main_smarty->assign('submit_link_field1', $linkres->link_field1);
			$main_smarty->assign('submit_link_field2', $linkres->link_field2);
			$main_smarty->assign('submit_link_field3', $linkres->link_field3);
			$main_smarty->assign('submit_link_field4', $linkres->link_field4);
			$main_smarty->assign('submit_link_field5', $linkres->link_field5);
			$main_smarty->assign('submit_link_field6', $linkres->link_field6);
			$main_smarty->assign('submit_link_field7', $linkres->link_field7);
			$main_smarty->assign('submit_link_field8', $linkres->link_field8);
			$main_smarty->assign('submit_link_field9', $linkres->link_field9);
			$main_smarty->assign('submit_link_field10', $linkres->link_field10);
			$main_smarty->assign('submit_link_field11', $linkres->link_field11);
			$main_smarty->assign('submit_link_field12', $linkres->link_field12);
			$main_smarty->assign('submit_link_field13', $linkres->link_field13);
			$main_smarty->assign('submit_link_field14', $linkres->link_field14);
			$main_smarty->assign('submit_link_field15', $linkres->link_field15);
			$main_smarty->assign('Spell_Checker',Spell_Checker);

			$catsql = mysql_query("SELECT category_id, category_name FROM " . table_categories . " WHERE category_lang='$dblang' ORDER BY category_name ASC");
			$categories = array();
			while ($rows = mysql_fetch_array ($catsql, MYSQL_ASSOC)) array_push ($categories, $rows);
			$main_smarty->assign('categories', $categories);

			include_once(mnminclude.'dbtree.php');
			$array = tree_to_array(0, table_categories, FALSE);
			$main_smarty->assign('lastspacer', 0);
			$main_smarty->assign('cat_array', $array);

			$canIhaveAccess = 0;
			$canIhaveAccess = $canIhaveAccess + checklevel('god');
			$canIhaveAccess = $canIhaveAccess + checklevel('admin');
			$main_smarty->assign('canIhaveAccess', $canIhaveAccess);

			if(Enable_Tags){
				$main_smarty->assign('tags', $linkres->tags);
				if (!empty($linkres->tags)) {
					$tags_words = str_replace(",", ", ", $linkres->tags);
					$tags_url = urlencode($linkres->tags);
					$main_smarty->assign('tags_words', $tags_words);
					$main_smarty->assign('tags_url', $tags_url);
				}
			}
			
			define('pagename', 'editlink'); 
            $main_smarty->assign('pagename', pagename);
			
			$main_smarty->assign('tpl_extra_fields', $the_template . '/submit_extra_fields');
			$main_smarty->assign('tpl_center', $the_template . '/editlink_edit_center');
			$main_smarty->display($the_template . '/pligg.tpl');

		}
	}
	else
	{
		echo "<br /><br />" . PLIGG_Visual_EditLink_NotYours . "<br/ ><br /><a href=".my_base_url.my_pligg_base.">".PLIGG_Visual_Name." home</a>";
	}
}
else
{
	echo "<br /><br />" . PLIGG_Visual_EditLink_NotYours . "<br/ ><br /><a href=".my_base_url.my_pligg_base.">".PLIGG_Visual_Name." home</a>";
}




//copied directly from submit.php
function link_errors($linkres)
{
	global $main_smarty, $the_template;
	$error = false;
	if(strlen($linkres->title) < PLIGG_Var_Submit_MinTitleLen  || strlen($linkres->content) < PLIGG_Var_Submit_MinContentLen ) {
		$main_smarty->assign('submit_error', 'incomplete');
		$main_smarty->assign('tpl_center', $the_template . '/submit_errors');
		
		define('pagename', 'editlink'); 
        $main_smarty->assign('pagename', pagename);
		
		$main_smarty->display($the_template . '/pligg.tpl');
		$error = true;
	}
	if(preg_match('/.*http:\//', $linkres->title)) {
		$main_smarty->assign('submit_error', 'urlintitle');
		$main_smarty->assign('tpl_center', $the_template . '/submit_errors');
		
		define('pagename', 'editlink'); 
        $main_smarty->assign('pagename', pagename);
		
		$main_smarty->display($the_template . '/pligg.tpl');
		$error = true;
	}
	if(!$linkres->category > 0) {
		$main_smarty->assign('submit_error', 'nocategory');
		$main_smarty->assign('tpl_center', $the_template . '/submit_errors');
		
		define('pagename', 'editlink'); 
        $main_smarty->assign('pagename', pagename);
		
		$main_smarty->display($the_template . '/pligg.tpl');
		$error = true;
	}
	return $error;
}

?>