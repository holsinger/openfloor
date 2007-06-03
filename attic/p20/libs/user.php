<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class User {
	var $read = false;
	var $id = 0;
	var $username = '';
	var $level = 'normal';
	var $modification = false;
	var $date = false;
	var $pass = '';
	var $email = '';
	var $names = '';
	var $lang = 1;
	var $karma = 10;
	var $public_email = '';
	var $location = '';
	var $occupation = '';
	var $url = '';
	var $aim = '';
	var $msn = '';
	var $yahoo = '';
	var $gtalk = '';
	var $skype = '';
	var $irc = '';
	var $avatar_source = '';
	// For stats
	var $total_votes = 0;
	var $published_votes = 0;
	var $total_links = 0;
	var $published_links = 0;
	

	function User($id=0) {
		if ($id>0) {
			$this->id = $id;
			$this->read();
		}
	}

	function store() {
		global $db, $current_user;

		if(!$this->date) $this->date=time();
		$user_login = $db->escape($this->username);
		$user_level = $this->level;
		$user_karma = $this->karma;
		$user_date = $this->date;
		$user_pass = $db->escape($this->pass);
		$user_lang = $this->lang;
		$user_email = $db->escape($this->email);
		$user_names = $db->escape($this->names);
		$user_url = $db->escape(htmlentities($this->url));
		$user_public_email = $db->escape($this->public_email);
		$user_location = $db->escape($this->location);
		$user_occupation = $db->escape($this->occupation);
		$user_aim = $db->escape($this->aim);
		$user_msn = $db->escape($this->msn);
		$user_yahoo = $db->escape($this->yahoo);
		$user_gtalk = $db->escape($this->gtalk);
		$user_skype = $db->escape($this->skype);
		$user_irc = $db->escape(htmlentities($this->irc));
		$user_avatar_source = $db->escape($this->avatar_source);
		if (strlen($user_pass) < 49){
			$saltedpass=generateHash($user_pass);}
		else{
			$saltedpass=$user_pass;}
			
		if($this->id===0) {
			$this->id = $db->insert_id;
		} else {
			// Username is never updated
			$sql = "UPDATE " . table_users . " set user_avatar_source='$user_avatar_source' ";
			$extra_vars = $this->extra;
			if(is_array($extra_vars)){
				foreach($extra_vars as $varname => $varvalue){
					$sql .= ", " . $varname . " = '" . $varvalue . "' ";
				}
			}
			$sql .= " , user_login='$user_login', user_occupation='$user_occupation', user_location='$user_location', public_email='$user_public_email', user_level='$user_level', user_karma=$user_karma, user_date=FROM_UNIXTIME($user_date), user_pass='$saltedpass', user_lang=$user_lang, user_email='$user_email', user_names='$user_names', user_url='$user_url', user_aim='$user_aim', user_msn='$user_msn', user_yahoo='$user_yahoo', user_gtalk='$user_gtalk', user_skype='$user_skype', user_irc='$user_irc' WHERE user_id=$this->id";
			//die($sql);
			$db->query($sql);
		}
	}
	
	function read() {
		global $db, $current_user;
		$id = $this->id;
		if($this->id>0) $where = "user_id = $id";
		else if(!empty($this->username)) $where = "user_login='".$db->escape($this->username)."'";
		if(!empty($where) && ($user = $db->get_row("SELECT * FROM " . table_users . " WHERE $where"))) {
			$this->id =$user->user_id;
			$this->username = $user->user_login;
			$this->level = $user->user_level;
			$date=$user->user_date;
			$this->date=unixtimestamp($date);
			$date=$user->user_modification;
			$this->modification=unixtimestamp($date);
			$this->pass = $user->user_pass;
			$this->email = $user->user_email;
			$this->names = $user->user_names;
			$this->lang = $user->user_lang;
			$this->karma = $user->user_karma;
			$this->public_email = $user->public_email;
			$this->location = $user->user_location;
			$this->occupation = $user->user_occupation;
			$this->url = $user->user_url;
			$this->aim = $user->user_aim;
			$this->msn = $user->user_msn;
			$this->yahoo = $user->user_yahoo;
			$this->gtalk = $user->user_gtalk;
			$this->skype = $user->user_skype;
			$this->irc = $user->user_irc;
			$this->avatar_source = $user->user_avatar_source;
			$this->read = true;

			//$this->extra_field = (array)$user; (does this work in php4 ?!?)
			$this->extra_field = object_2_array($user);

			return true;
		}
		$this->read = false;
		return false;
	}

	function all_stats($from = false) {
		global $db;

		if ($from !== false) {
			$link_date = "AND link_date > FROM_UNIXTIME($from)";
			$vote_date = "AND vote_date > FROM_UNIXTIME($from)";
			$comment_date = "AND comment_date > FROM_UNIXTIME($from)";
		} else {
			$link_date = "";
			$vote_date = "";
			$comment_date = "";
		}
		if(!$this->read) $this->read();

		$this->total_votes = $db->get_var("SELECT count(*) FROM " . table_votes . "," . table_links . " WHERE link_status != 'discard' AND vote_user_id = $this->id $vote_date AND link_id = vote_link_id");
		$this->published_votes = $db->get_var("SELECT count(*) FROM " . table_votes . "," . table_links . " WHERE vote_user_id = $this->id AND link_id = vote_link_id AND link_status = 'published' AND vote_date < link_published_date $vote_date");
		$this->total_links = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_author = $this->id and link_status != 'discard' $link_date");
		$this->published_links = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_author = $this->id AND link_status = 'published' $link_date");
		$this->total_comments = $db->get_var("SELECT count(*) FROM " . table_comments . " WHERE comment_user_id = $this->id $comment_date");

	}
	
	function fill_smarty($main_smarty, $stats = 1){
		$main_smarty->assign('user_publicemail', $this->public_email);
		$main_smarty->assign('user_location', $this->location);
		$main_smarty->assign('user_occupation', $this->occupation);
		$main_smarty->assign('user_aim', $this->aim);
		$main_smarty->assign('user_msn', $this->msn);
		$main_smarty->assign('user_yahoo', $this->yahoo);
		$main_smarty->assign('user_gtalk', $this->gtalk);
		$main_smarty->assign('user_skype', $this->skype);
		$main_smarty->assign('user_irc', $this->irc);
		$main_smarty->assign('user_karma', $this->karma);
		$main_smarty->assign('user_joined', get_date($this->date));
		$main_smarty->assign('user_login', $this->username);
		$main_smarty->assign('user_names', $this->names);
		$main_smarty->assign('user_username', $this->username);
		
		if($stats == 1){		
			$this->all_stats();
			$main_smarty->assign('user_total_links', $this->total_links);
			$main_smarty->assign('user_published_links', $this->published_links);
			$main_smarty->assign('user_total_comments', $this->total_comments);
			$main_smarty->assign('user_total_votes', $this->total_votes);
			$main_smarty->assign('user_published_votes', $this->published_votes);
		}
					
		return $main_smarty;
	}
}
