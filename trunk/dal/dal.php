<?php
require_once './conf/dbconn.php';

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
		$result = $this->dbc->query("SELECT guid_hash FROM p20_guids WHERE guid_hash='$guid' LIMIT 1");
		return $result->num_rows==1?true:false;
	}
	
	function recordSession($session_id, $hash)
	{
		$guid = $this->getGUIDFromHash($hash);
		return $this->dbc->query("INSERT INTO p20_visits VALUES (NULL, $guid, '', '$session_id', '', null)");
	}
	
	function getGUIDFromHash($hash)
	{
		$result = $this->dbc->query("SELECT guid_id FROM p20_guids WHERE guid_hash='$hash'");
		list($id) = $result->fetch_row();
		return $id;
	}
	
	function getVisitId($guid, $session_id)
	{
		$result = $this->dbc->query("SELECT visit_id FROM p20_visits WHERE fk_guid_id='$guid' AND session_id='$session_id'");
		list($id) = $result->fetch_row();
		return $id;
	}
	
	function recordZip($zip)
	{
		$guid = $this->getGUIDFromHash($_COOKIE['guid']);
		$visit_id = $this->getVisitId($guid, $_COOKIE['PHPSESSID']);
		$zip = $this->escape_data($zip);
		
		$this->dbc->query("INSERT INTO p20_zipsearch VALUES (NULL, $guid, $visit_id, $zip)");
	}
}