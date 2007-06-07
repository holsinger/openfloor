<?php
/**
 * GUID Class
 */
class Guid extends dbfunctions 
{
	function __construct($debug = 0)
	{
		parent::__construct($debug);
	}
	
	public function getGUID()
	{
		if (isset($_COOKIE['guid']))
			return $this->isValidGUID($_COOKIE['guid'])?$_COOKIE['guid']:false;
		else
			return false;
	}
	
	public function newGUID()
	{
		$this->query('INSERT INTO p20_guids (date_created) VALUES (now())');
		$insert_id = $this->last_id();
		$guid_hash = md5($insert_id);
		
		if ($this->query("UPDATE p20_guids SET guid_hash='$guid_hash' WHERE guid_id=$insert_id"))
			return $guid_hash;
	}
	
	public function isValidGUID($guid_hash)
	{
		$guid_hash = $this->escape_data($guid_hash);
		
		$this->query("SELECT guid_hash FROM p20_guids WHERE guid_hash='$guid_hash' LIMIT 1");
		return $this->num_records()==1?true:false;
	}
	
	function dropGUIDCookie()
	{
		/* one year cookie */
		$guid = $this->newGUID();
		setcookie('guid',$guid,time() + 86400*365);
		return $guid;
	}
}