<?php

class dal
{
	var $dbc;
	
	## database functions
	function __construct()
	{
		$this->dbc_connect();		
	}
	
	function __destruct()
	{
		$this->dbc->close();
	}
	
	function dbc_connect()
	{
		$this->dbc = new mysqli(HOSTNAME, USERNAME, PASSWORD, DBNAME);
		
		if (mysqli_connect_errno()) {
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}
	}
	
	function escape_data($data)
	{
		if (ini_get('magic_quotes_gpc'))
			$data = stripslashes($data);
			
		return mysqli_real_escape_string($this->dbc, $data);
	}
	
	## private functions
	private function getGUIDFromHash($hash)
	{
		$hash = $this->escape_data($hash);
		
		$result = $this->dbc->query("SELECT guid_id FROM p20_guids WHERE guid_hash='$hash'");
		list($id) = $result->fetch_row();
		return $this->escape_data($id);
	}
	
	private function getVisitId($guid, $session_id)
	{
		$guid = $this->escape_data($guid);
		$session_id = $this->escape_data($session_id);
		
		$result = $this->dbc->query("SELECT visit_id FROM p20_visits WHERE fk_guid_id='$guid' AND session_id='$session_id'");
		list($id) = $result->fetch_row();
		return $id;
	}
	
	private function getIP() 
	{ 
		$ip;
		
		if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP"); 
		else if(getenv("HTTP_X_FORWARDED_FOR")) $ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if(getenv("REMOTE_ADDR")) $ip = getenv("REMOTE_ADDR"); 
		else $ip = "UNKNOWN"; 		
		
		return $ip;	
	}
	
	private function getReferer()
	{
		// not sure if this function works properly
		$referer;
		
		if (getenv('HTTP_REFERER')) $referer = getenv('HTTP_REFERER');
		else $referer = 'UNKNOWN';
		
		return $referer;
	}
	
	## data access function
	function newGUID()
	{
		$result = $this->dbc->query('INSERT INTO p20_guids (date_created) VALUES (now())');
		$insert_id = $this->dbc->insert_id;
		$guid = md5($insert_id);
		
		if ($this->dbc->query("UPDATE p20_guids SET guid_hash='$guid' WHERE guid_id=$insert_id"))
			return $guid;
	}
	
	function isValidGUID($guid)
	{
		$guid = $this->escape_data($guid);
		
		$result = $this->dbc->query("SELECT guid_hash FROM p20_guids WHERE guid_hash='$guid' LIMIT 1");
		return $result->num_rows==1?true:false;
	}
	
	function recordSession($session_id, $hash)
	{
		$session_id = $this->escape_data($session_id);
		$hash = $this->escape_data($hash);
		
		$ip = $this->getIP();
		$referer = $this->getReferer();
		$guid = $this->getGUIDFromHash($hash);
		
		return $this->dbc->query("INSERT INTO p20_visits VALUES (NULL, $guid, '$ip', '$session_id', '$referer', null)");
	}
	
	function recordZip($zip)
	{
		$guid = $this->getGUIDFromHash($_COOKIE['guid']);
		$visit_id = $this->getVisitId($guid, $_COOKIE['PHPSESSID']);
		$zip = $this->escape_data($zip);
		//echo "INSERT INTO p20_zipsearch VALUES (NULL, $guid, $visit_id, '$zip'')";
		$this->dbc->query("INSERT INTO p20_zipsearch VALUES (NULL, $guid, $visit_id, '$zip')");
	}

	function makeDefaultZip($zip)
	{
		$zip = $this->escape_data($zip);
		$guid = $this->getGUIDFromHash($_COOKIE['guid']);
		
		$result = $this->dbc->query("SELECT fk_guid_id FROM p20_preferences WHERE fk_guid_id=$guid LIMIT 1");
		if ($result->num_rows==1)
			$this->dbc->query("UPDATE p20_preferences SET default_zip='$zip' WHERE fk_guid_id=$guid");
		else
			$this->dbc->query("INSERT INTO p20_preferences VALUES (NULL, $guid, '$zip')");
	}
}