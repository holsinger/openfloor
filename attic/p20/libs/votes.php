<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class Vote {
	var $type='';
	var $user=-1;
	var $value=1;
	var $link;
	var $ip='';
	
	function Vote() {
		return;
	}
	
	function sum(){
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		$sum=$db->get_var("SELECT sum(vote_value) FROM " . table_votes . " WHERE $where");
		$sum = $this->adjust($sum);
		return $sum;
	}
	
	function adjust($vote_sum){
		// if not factoring karma, and just using a straight + / - voting system, we'll divide by 10.
		return $vote_sum / 10;
	}

	function reports($value="< 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		if($this->user !== -1) {
			$where .= " AND vote_user_id=$this->user";
		}
		if($this->user == 0 || !empty($this->ip)) {
			if ($this->ip == '') {
				require_once(mnminclude.'check_behind_proxy.php');
				$this->ip=check_ip_behind_proxy();
			}
			$where .= " AND vote_ip='$this->ip'";
		}
		$count=$db->get_var("SELECT count(*) FROM " . table_votes . " WHERE $where");
		return $count;
	}

	function listall() {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link";
		$sql=$db->get_results("SELECT * FROM " . table_votes . " WHERE $where");
		return $sql;
	}
	
	function count($value="> 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		if($this->user !== -1) {
			$where .= " AND vote_user_id=$this->user";
		}
		if($this->user == 0 || !empty($this->ip)) {
			if ($this->ip == '') {
				require_once(mnminclude.'check_behind_proxy.php');
				$this->ip=check_ip_behind_proxy();
			}
			$where .= " AND vote_ip='$this->ip'";
		}
		$sql = "SELECT count(*) FROM " . table_votes . " WHERE $where";
		$count=$db->get_var($sql);
		return $count;
	}

	function count_all($value="> 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		$sql = "SELECT count(*) FROM " . table_votes . " WHERE $where";
		$count=$db->get_var($sql);
		return $count;
	}

	function total_count($value="> 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		if($this->user !== -1) {
			$where .= " AND vote_user_id=$this->user";
		}
		if($this->user == 0 || !empty($this->ip)) {
			if ($this->ip == '') {
				require_once(mnminclude.'check_behind_proxy.php');
				$this->ip=check_ip_behind_proxy();
			}
			$where .= " AND vote_ip='$this->ip'";
		}
		$count=$db->get_var("SELECT vote_value FROM " . table_votes . " WHERE $where");
		return $count;
	}

	function rating($value="> 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		//if($this->user !== -1) {
		//	$where .= " AND vote_user_id=$this->user";
		//}
		//if($this->user == 0 || !empty($this->ip)) {
		//	if ($this->ip == '') {
		//		require_once(mnminclude.'check_behind_proxy.php');
		//		$this->ip=check_ip_behind_proxy();
		//	}
		//	$where .= " AND vote_ip='$this->ip'";
		//}
		$sql = "SELECT avg(vote_value) FROM " . table_votes . " WHERE $where";
		//echo $sql;
		$rating=$db->get_var($sql);
		return $rating;
	}


	function anycount($value="<> 0") {
		global $db;
		$where = "vote_type='$this->type' AND vote_link_id=$this->link AND vote_value $value";
		if($this->user !== -1) {
			$where .= " AND vote_user_id=$this->user";
		}
		if($this->user == 0 || !empty($this->ip)) {
			if ($this->ip == '') {
				require_once(mnminclude.'check_behind_proxy.php');
				$this->ip=check_ip_behind_proxy();
			}
			$where .= " AND vote_ip='$this->ip'";
		}
		$count=$db->get_var("SELECT count(*) FROM " . table_votes . " WHERE $where");
		return $count;
	}

	function insert() {
		global $db, $the_template;
		if(empty($this->ip)) {
			require_once(mnminclude.'check_behind_proxy.php');
			$this->ip=check_ip_behind_proxy();
		}
		$this->value=intval($this->value);
		$sql="INSERT INTO " . table_votes . " (vote_type, vote_user_id, vote_link_id, vote_value, vote_ip) VALUES ('$this->type', $this->user, $this->link, $this->value, '$this->ip')";
		if($this->count_all() != 0){
			// clear the cache for that story that was voted on
			/*include_once('Smarty.class.php');
			$votesmarty = new Smarty;
			$votesmarty->compile_dir = "templates_c/";
			$votesmarty->template_dir = "templates/";
			$votesmarty->config_dir = "";
			$votesmarty->cache_dir = "templates_c/";
			$votesmarty->cache = true;
			$votesmarty->clear_cache($the_template . '/link_summary.tpl', 'story' . $this->link);
			$votesmarty = "";
			*/
		}
		
		return $db->query($sql);
	}
}