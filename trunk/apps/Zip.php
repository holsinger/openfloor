<?php
class Zip extends dbfunctions 
{
	function __construct($debug = 0)
	{
		parent::__construct($debug);
	}
	
	function recordZip($zip)
	{
		//check for validity of guid and phpsessid from $_COOKIE
		$guid = $this->getGUIDFromHash($_COOKIE['guid']);
		$visit_id = $this->getVisitId($guid, $_COOKIE['PHPSESSID']);
		$zip = $this->escape_data($zip);
		
		$this->query("INSERT INTO p20_zipsearch VALUES (NULL, $guid, $visit_id, '$zip')");
	}

	//check for validity of guid
	function makeDefaultZip($zip)
	{
		$zip = $this->escape_data($zip);
		$guid = $this->getGUIDFromHash($_COOKIE['guid']);
		
		$this->query("SELECT fk_guid_id FROM p20_preferences WHERE fk_guid_id=$guid LIMIT 1");
		if ($this->num_records()==1)
			$this->query("UPDATE p20_preferences SET default_zip='$zip' WHERE fk_guid_id=$guid");
		else
			$this->query("INSERT INTO p20_preferences VALUES (NULL, $guid, '$zip')");
	}	
}