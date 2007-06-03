{php}
Global $db, $main_smarty, $current_user, $link, $commentownerid;

if(is_numeric($_REQUEST['id'])) {
	$link = new Link;
	$link->id=$_REQUEST['id'];
	$link->commentid=$_REQUEST['commentid'];
	$link->read();

	$comments = $db->get_row("SELECT comment_user_id FROM " . table_comments . " WHERE comment_id=$link->commentid");
	$commentownerid = $comments->comment_user_id;
	$commentowner = $db->get_var("SELECT user_login FROM " . table_users . " WHERE user_id = ". $commentownerid);

	if ($_POST['process']=='newcomment') {
		insert_comment();
	}
	// Set globals
	$globals['link_id']=$link->id;
	$globals['commentid'] = $link->commentid;
	$globals['category_id']=$link->category;
	$globals['category_name']=$link->category_name();

	echo '<div id="contents">';
	$link->print_summary();

	echo '<div id="comments">';
   	echo '<h2>'._('comments').'</h2>';
	if($current_user->user_level == "admin" or $current_user->user_level == "god"){
		$comments = $db->get_col("SELECT comment_id FROM " . table_comments . " WHERE comment_id=$link->commentid ORDER BY comment_date");
	}
	else
	{
		$comments = $db->get_col("SELECT comment_id FROM " . table_comments . " WHERE comment_id=$link->commentid and comment_user_id=$current_user->user_id ORDER BY comment_date");
	}	
	if ($comments) {
		$current_user->owncomment = "YES";
		echo '<ol id="comments-list">';
		require_once(mnminclude.'comment.php');
		$comment = new Comment;
		foreach($comments as $comment_id) {
			$comment->id=$comment_id;
			$comment->read();
			$comment->hideedit='yes';
			$comment->print_summary($link);
			$link->thecomment = $comment->quickread();
			$main_smarty->assign('TheComment', $comment->quickread());
		}
		echo "</ol>\n";
	}
	else
	{
		$current_user->owncomment = "NO";
		echo PLIGG_Visual_EditComment_NotYours . '<br/><br/>';
		echo PLIGG_Visual_EditComment_Click . '<a href = "'.getmyurl('story', $_REQUEST['id']).'">'.PLIGG_Visual_EditComment_Here.'</a> '.PLIGG_Visual_EditComment_ToReturn.'<br/><br/>';
	}


	if($current_user->authenticated) {
		if($current_user->owncomment=="YES"){
			print_comment_form();
		}
		if($current_user->user_level == "admin" or $current_user->user_level == "god"){
			echo '<a href="#" onclick=(document.getElementById("comment").value="'.PLIGG_Visual_EditComment_Removed.'")>'.PLIGG_Visual_EditComment_ReplaceWithRemoved.'</a>';
		}
	} 

	echo '</div>' . "\n";
		
	echo '</div>';
}
{/php}