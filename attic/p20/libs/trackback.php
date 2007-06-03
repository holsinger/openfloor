<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".


class Trackback {
	var $id = 0;
	var $author = 0;
	var $link = 0;
	var $type = 'out';
	var $status = 'pendent';
	var $date = false;
	var $modified = false;
	var $url  = '';
	var $title = '';
	var $content = '';
	var $read = false;

	function store() {
		global $db, $current_user;

		if(!$this->date) $this->date=time();
		$trackback_date=$this->date;
		$trackback_author = $this->author;
		$trackback_link = $this->link;
		$trackback_type = $this->type;
		$trackback_status = $this->status;
		$trackback_url = $db->escape(trim($this->url));
		$trackback_title = $db->escape(trim($this->title));
		$trackback_content = $db->escape(trim($this->content));
		if($this->id===0) {
			$db->query("INSERT INTO " . table_trackbacks . " (trackback_user_id, trackback_link_id, trackback_type, trackback_date, trackback_status, trackback_url, trackback_title, trackback_content) VALUES ($trackback_author, $trackback_link, '$trackback_type', FROM_UNIXTIME($trackback_date), '$trackback_status', '$trackback_url', '$trackback_title', '$trackback_content')");
			$this->id = $db->insert_id;
		} else {
			$db->query("UPDATE " . table_trackbacks . " set trackback_user_id=$trackback_author, trackback_link_id=$trackback_link, trackback_type='$trackback_type', trackback_date=FROM_UNIXTIME($trackback_date), trackback_status='$trackback_status', trackback_url='$trackback_url', trackback_title='$trackback_title', trackback_content='$trackback_content' WHERE trackback_id=$this->id");
		}
	}
	
	function read() {
		global $db, $current_user;

		if($this->id == 0 && !empty($this->url) && $this->link > 0) 
			$cond = "trackback_type = '$this->type' AND trackback_link_id = $this->link AND trackback_url = '$this->url'";

		else $cond = "trackback_id = $this->id";
	
		if(($link = $db->get_row("SELECT * FROM trackbacks WHERE $cond"))) {
			$this->id=$link->trackback_id;
			$this->author=$link->trackback_user_id;
			$this->link=$link->trackback_link_id;
			$this->type=$link->trackback_type;
			$this->status=$link->trackback_status;
			$this->url=$link->trackback_url;
			$this->title=$link->trackback_title;
			$this->content=$link->trackback_content;
			$date=$link->trackback_date;
			$this->date=$db->get_var("SELECT UNIX_TIMESTAMP('$date')");
			$date=$link->trackback_modified;
			$this->modified=$db->get_var("SELECT UNIX_TIMESTAMP('$date')");
			$this->read = true;
			return true;
		}
		$this->read = false;
		return false;
	}

// Send a Trackback
	function send() {
		global $trackbackURL;
        if (empty($this->url))
                return;

        $title = urlencode($this->title);
        $excerpt = urlencode($this->content);
        $blog_name = urlencode($trackbackURL);
        $tb_url = $this->url;
        $url = urlencode(get_permalink($this->link));
        $query_string = "charset=UTF-8&title=$title&url=$url&blog_name=$blog_name&excerpt=$excerpt";
        $trackback_url = parse_url($this->url);
        $http_request  = 'POST ' . $trackback_url['path'] . ($trackback_url['query'] ? '?'.$trackback_url['query'] : '') . " HTTP/1.0\r\n";
        $http_request .= 'Host: '.$trackback_url['host']."\r\n";
        $http_request .= 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'."\r\n";
        $http_request .= 'Content-Length: '.strlen($query_string)."\r\n";
        $http_request .= "User-Agent: MNM (http://meneame.com) ";
        $http_request .= "\r\n\r\n";
        $http_request .= $query_string;
        if ( '' == $trackback_url['port'] )
                $trackback_url['port'] = 80;
        $fs = @fsockopen($trackback_url['host'], $trackback_url['port'], $errno, $errstr, 5);
		if($fs && ($res=@fputs($fs, $http_request)) ) {
		/*********** DEBUG **********
        $debug_file = '/tmp/trackback.log';
        $fp = fopen($debug_file, 'a');
        fwrite($fp, "\n*****\nRequest:\n\n$http_request\n\nResponse:\n\n");
        while(!@feof($fs)) {
                fwrite($fp, @fgets($fs, 4096));
        }
        fwrite($fp, "\n\n");
        fclose($fp);
		/*********** DEBUG ************/
        	@fclose($fs);
			$this->status='ok';
			$this->store();
			return true;	
		}
		$this->status='error';	
		$this->store();
        return $false;
	}
}
