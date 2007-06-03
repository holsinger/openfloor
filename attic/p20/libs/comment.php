<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class Comment {
	var $id = 0;
	var $randkey = 0;
	var $author = 0;
	var $link = 0;
	var $date = false;
	var $karma = 0;
	var $content = '';
	var $read = false;
	var $parent = 0;
	var $hideedit;
	var $votes = 0;

	function store() {
		// save the comment to the database
		global $db, $current_user, $the_template;

		if(!$this->date) $this->date=time();
		$comment_id = $this->id;
		$comment_author = $this->author;
		$comment_link = $this->link;
		$comment_karma = $this->karma;
		$comment_date = $this->date;
		$comment_randkey = $this->randkey;
		$comment_content = $db->escape($this->content);
		$comment_votes = $this->votes;
		$comment_parent = $this->parent;

		if($this->id===0) {
			// if this is a new comment
			$sql = "INSERT INTO " . table_comments . " (comment_parent, comment_user_id, comment_link_id, comment_karma, comment_date, comment_randkey, comment_content) VALUES ($comment_parent, $comment_author, $comment_link, $comment_karma, FROM_UNIXTIME($comment_date), $comment_randkey, '$comment_content')";
			$db->query($sql);
			$this->id = $db->insert_id;
		} else {
			// if we're editing an existing comment
			$sql = "UPDATE " . table_comments . " set comment_votes=$comment_votes, comment_user_id=$comment_author, comment_link_id=$comment_link, comment_karma=$comment_karma, comment_date=FROM_UNIXTIME($comment_date), comment_randkey=$comment_randkey, comment_content='$comment_content' WHERE comment_id=$comment_id";
			$db->query($sql);
		}
	}
	
	function read() {
		// read the comment from the database
		global $db, $current_user;
		$this->username = false;
		$id = $this->id;
		if(($link = $db->get_row("SELECT * FROM " . table_comments . " WHERE comment_id = $id"))) {
			$this->author=$link->comment_user_id;
			$this->randkey=$link->comment_randkey;
			$this->link=$link->comment_link_id;
			$this->karma=$link->comment_karma;
			$this->parent=$link->comment_parent;
			$this->content=$link->comment_content;
			$this->randkey=$link->comment_randkey;
			$this->votes=$link->comment_votes;
			$date=$link->comment_date;
			$this->date=unixtimestamp($date);
			$this->read = true;
			return true;
		}
		$this->read = false;
		return false;
	}

	function quickread() {
		global $db, $current_user;
		$this->username = false;
		$id = $this->id;
		if(($link = $db->get_row("SELECT * FROM " . table_comments . " WHERE comment_id = $id"))) {
			$this->content=$link->comment_content;
			return $link->comment_content;
		}
		$this->quickread = false;
		return false;
	}

	function print_summary($link) {
		global $current_user, $the_template;
		static $comment_counter = 0;
		static $link_index=0;

		// setup smarty
			include_once('Smarty.class.php');
			$smarty = new Smarty;
			$smarty->compile_dir = "templates_c/";
			$smarty->template_dir = "templates/";
			$smarty->config_dir = "";

		// if we can't read the comment, return
			if(!$this->read) return;
		
		// counter	
			$comment_counter++;
		
		$smarty = $this->fill_smarty($smarty);

		$smarty->display($the_template . '/comment_show.tpl');
	
	}
	
	function fill_smarty($smarty){
		global $current_user, $the_template, $comment_counter, $link;

		$smarty->assign('comment_counter', $comment_counter);
		$smarty->assign('comment_content', save_text_to_html($this->content));
		$smarty->assign('current_userid', $current_user->user_id);
		$smarty->assign('user_logged_in', $current_user->user_login);
		$smarty->assign('user_username', $this->username());
		$smarty->assign('comment_id', $this->id);
		$smarty->assign('comment_author', $this->author);
		$smarty->assign('comment_link', $this->link);
		$smarty->assign('user_view_url', getmyurl('user', $this->username()));
		$smarty->assign('comment_age', txt_time_diff($this->date));
		$smarty->assign('comment_randkey', $this->randkey);
		$smarty->assign('comment_votes', $this->votes);
		$smarty->assign('comment_parent', $this->parent);
		$smarty->assign('hide_comment_edit', $this->hideedit);
		
		$this->user_vote_count = $this->votes($current_user->user_id);
		$smarty->assign('comment_user_vote_count', $this->user_vote_count);
		
		// if the person logged in is the person viewing the comment, show 'you' instead of the name
			if ($current_user->user_login == $this->username()){$smarty->assign('user_username', 'you');}

		// the url for the edit comment link
			$smarty->assign('edit_comment_url', getmyurl('editcomment', $this->id, $link->id));

		// avatars
			$smarty->assign('UseAvatars', do_we_use_avatars());
			$smarty->assign('Avatar_ImgSrc', get_avatar('small', "", $this->username(), ""));

		//spellchecker
	    $smarty->assign('Spell_Checker',Spell_Checker); 

		// does the person logged in have admin or god access?
			$canIhaveAccess = 0;
			$canIhaveAccess = $canIhaveAccess + checklevel('god');
			$canIhaveAccess = $canIhaveAccess + checklevel('admin');
			if($canIhaveAccess == 1){$smarty->assign('isadmin', 1);}
		
		// the link to upvote the comment
			$jslinky = "cvote($current_user->user_id, $this->id, $this->id, " . "'" . md5($current_user->user_id.$this->randkey) . "', 10, '" . my_base_url . my_pligg_base . "/')";
			$smarty->assign('link_shakebox_javascript_votey', $jslinky);

		// the link to downvote the comment
			$jslinkn = "cvote($current_user->user_id, $this->id, $this->id, " . "'" . md5($current_user->user_id.$this->randkey) . "', -10,  '" . my_base_url . my_pligg_base . "/')";
			$smarty->assign('link_shakebox_javascript_voten', $jslinkn);

		// misc
			$smarty->assign('Enable_Comment_Voting', Enable_Comment_Voting);
			$smarty->assign('my_base_url', my_base_url);
			$smarty->assign('my_pligg_base', my_pligg_base);
			$smarty->assign('Default_Gravatar_Small', Default_Gravatar_Small);
			
		return $smarty;
	}

	function username() {
		global $db;
		$this->username = $db->get_var("SELECT user_login FROM " . table_users . " WHERE user_id = $this->author");
		$this->author_email = $db->get_var("SELECT user_email FROM " . table_users . " WHERE user_id = $this->author");
		return $this->username;
	}
	
	function votes($user) {
		require_once(mnminclude.'votes.php');

		$vote = new Vote;
		$vote->type='comments';
		$vote->user=$user;
		$vote->link=$this->id;
		return $vote->anycount();
	}
	
	
	function insert_vote($user=0, $value=10) {
		global $anon_karma;
		require_once(mnminclude.'votes.php');

		$vote = new Vote;
		$vote->type='comments';
		$vote->user=$user;
		$vote->link=$this->id;
		$vote->value=$value;

		if($vote->insert()) {
			$vote = new Vote;
			$vote->type='comments';
			$vote->link=$this->id;
			$this->votes=$vote->count();
			return $vote->sum();
		}
		return false;
	}
}
