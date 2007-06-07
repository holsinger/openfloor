<?php
/**
 * This class includes general database functions or functions that need to
 * be semi-global accessible
 */
class dbfunctions extends db_mysql 
{
	function __construct($debug = 0)
	{
		parent::__construct($debug);
	}
	
	// next two functions need to be modified to pull data from cookie
	// + record visit + record zip(x2) + make default zip
	public function getGUIDFromHash($guid_hash)
	{
		$guid_hash = $this->escape_data($guid_hash);
		
		$this->query("SELECT guid_id FROM p20_guids WHERE guid_hash='$guid_hash'");
		$row = $this->next();
		return $row['guid_id'];
	}
	
	public function getVisitId($guid, $session_id)
	{
		$guid = $this->escape_data($guid);
		$session_id = $this->escape_data($session_id);
		
		$this->query("SELECT visit_id FROM p20_visits WHERE fk_guid_id='$guid' AND session_id='$session_id'");
		$row = $this->next();
		return $row['visit_id'];
	}
}

/**
 * This class includes general functions which
 * do not rely on the database connection.
 */
class P20Functions
{
	public static function getIP() 
	{ 
		$ip;
		
		if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP"); 
		else if(getenv("HTTP_X_FORWARDED_FOR")) $ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if(getenv("REMOTE_ADDR")) $ip = getenv("REMOTE_ADDR"); 
		else $ip = "UNKNOWN"; 		
		
		return $ip;	
	}
	
	public static function getReferer()
	{
		// not sure if this function works properly
		$referer;
		
		if (getenv('HTTP_REFERER')) $referer = getenv('HTTP_REFERER');
		else $referer = 'UNKNOWN';
		
		return $referer;
	}	

	public static function getSessionID()
	{
		$session_id;
		if (isset($_COOKIE['PHPSESSID'])) return $_COOKIE['PHPSESSID'];
		else if (session_id()) return session_id();
		else $session_id = false;
		return $session_id;
	}
}



