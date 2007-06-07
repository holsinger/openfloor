<?php
class Visit extends dbfunctions
{
	function __construct($debug = 0)
	{
		parent::__construct($debug);
	}
	
	public function recordVisit($session_id, $guid_hash)
	{
		$session_id = $this->escape_data($session_id);
		$guid_hash = $this->escape_data($guid_hash);
		
		$ip = P20Functions::getIP();
		$referer = P20Functions::getReferer();
		$guid = $this->getGUIDFromHash($guid_hash);
		
		return $this->query("INSERT INTO p20_visits VALUES (NULL, $guid, '$ip', '$session_id', '$referer', null)");
	}	
}