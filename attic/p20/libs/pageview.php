<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

class Pageview {
	var $type='';
	var $page_id=0;
	var $datetime=0;
	var $user_id=0;
	var $user_ip='';
	
	function insert(){
		global $db;
		if(!$this->datetime) $this->datetime=time();
	
		$sql="INSERT INTO " . table_pageviews . " (pv_type, pv_page_id, pv_datetime, pv_user_id, pv_user_ip) VALUES ('$this->type', $this->page_id, FROM_UNIXTIME($this->datetime), $this->user_id, '$this->user_ip')";
		return $db->query($sql);
	}
	
	function last_visit(){
		global $db;
		$sql="SELECT `pv_datetime` FROM `" . table_pageviews . "` where `pv_type` = 'story' and `pv_page_id` = $this->page_id and `pv_user_id` = $this->user_id order by `pv_datetime` DESC Limit 1";
		//echo $sql;
		$lastvisit=$db->get_var($sql);
		$lastvisit=unixtimestamp($lastvisit);
		return $lastvisit;
	}
		
	function last_viewers($viewercount = 1){
		global $db, $current_user;
		$sql = "SELECT DISTINCT pv_user_id, pv_type, pv_page_id FROM " . table_pageviews . " GROUP BY pv_type, pv_page_id, pv_user_id, pv_datetime HAVING (((pv_type)='$this->type') AND ((pv_page_id)=$this->page_id) AND pv_user_id > 0) ORDER BY pv_datetime DESC LIMIT " . $viewercount;
		$last_viewers = $db->get_col($sql);
		return $last_viewers;
	}
}
?>