<?php

class Candidate_model extends Model 
{
	private $action;
	
	function __construct()
    {
        parent::Model();
    }

	public function addCandidate()
	{
		$this->action = 'create';
		return $this->adminCandidate();
	}
	
	public function editCandidate()
	{
		$this->action = 'edit';
		return $this->adminCandidate();
	}
	
	public function getCandidate($can_id)
	{
		$result = $this->db->getwhere('cn_candidates', array('can_id' => $can_id))->row_array();
		if(empty($result)) return false;
		return $result;
	}
	
	public function getIdByName($can_name)
	{
		$result = $this->db->getwhere('cn_candidates', array('can_name' => $can_name))->row_array();
		if(empty($result)) return false;
		return $result['can_id'];
	}
	
	private function adminCandidate()
	{
		if(isset($_POST))
		{
			unset($_POST['submitted'], $_POST['can_password_confirm']);
			
			foreach($_POST as $k => $v)
				if(empty($v)) unset($_POST[$k]);
			
			if($this->action == 'create') {
				$this->db->insert('cn_candidates', $_POST);
				return $this->db->insert_id();
			} elseif($this->action == 'edit') {
				$this->db->where('can_id', $_POST['can_id']);
				unset($_POST['can_id']);
				$this->db->update('cn_candidates', $_POST);
				return true;
			} else return false;
		}
		return false;
	}
}
?>