<?php

class Candidate_model extends Model 
{
	function __construct()
    {
        parent::Model();
    }

	public function addCandidate()
	{
		if(isset($_POST))
		{
			unset($_POST['submitted'], $_POST['can_password_confirm']);
			$this->db->insert('cn_candidates', $_POST);
			return $this->db->insert_id();
		}
		return false;
	}
}
?>