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

	$main_smarty->assign('form_cols', 60);
	$main_smarty->assign('tpl_center', $the_template . '/edit_comment_center');
   //spellchecker
	$main_smarty->assign('Spell_Checker',Spell_Checker);
	
	define('pagename', 'edit'); 
    $main_smarty->assign('pagename', pagename);
	
	$main_smarty->display($the_template . '/pligg.tpl');

function print_comment_form() {
	global $link, $current_user, $main_smarty, $the_template;

	$main_smarty->assign('randkey', rand(1000000,100000000));
	$main_smarty->assign('link_id', $link->id);
	$main_smarty->assign('user_id', $current_user->user_id);

	$main_smarty->display($the_template . '/comment_form.tpl');
}

function insert_comment () {
	global $commentownerid, $link, $db, $current_user;
	// Check if is a POST of a comment
	if($_POST['link_id'] == $link->id && $current_user->authenticated && $_POST['user_id'] == $current_user->user_id &&
		$_POST['randkey'] > 0 && strlen($_POST['comment_content']) > 0 ) {
		require_once(mnminclude.'comment.php');
		$comment = new Comment;
		$comment->id=$link->commentid;
		$comment->read();
		$comment->link=$link->id;
		$comment->randkey=$_POST['randkey'];
		$comment->author=$commentownerid; //$_POST['user_id'];
		$comment->content=$_POST['comment_content'];
		$comment->store();
		header('Location: ' . getmyurl('story', $_GET['id']));
		die;
	}
}

?>