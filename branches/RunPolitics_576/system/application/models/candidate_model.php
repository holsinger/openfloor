<?php

class Candidate_model extends Model 
{
	private $action;
	
	function __construct()
    {
        parent::Model();
    }

	public function user_name($can_id)
	{
		return $this->db->select('user_name')->from('cn_users')->where('fk_can_id', $can_id)->get()->row()->user_name;
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
	
	public function getIdByName($can_display_name)
	{
		$result = array();
		$query_result = $this->db->get('cn_candidates')->result_array();
		foreach($query_result as $k => $v)
			if(url_title($v['can_display_name']) == $can_display_name)
				$result[] = $v;
		if(empty($result)) return false;
		return $result[0]['can_id'];
	}
	
	public function nameByUser($fk_can_id)
	{
		return $this->db->select('can_display_name')->from('cn_candidates')->where('can_id', $fk_can_id)->get()->row()->can_display_name;
	}
	
	public function authenticate($can_id, $can_password)
	{
		$result = $this->db->getwhere('cn_candidates', array('can_id' => $can_id, 'can_password' => md5($can_password)))->row_array();
		return !empty($result);
	}
	
	public function getCandidates()
	{
		$this->db->select('can_id, can_display_name');
		$result = $this->db->get('cn_candidates')->result_array();
		$array = array();
		foreach($result as $v)
			$array[$v['can_id']] = $v['can_display_name'];
		return $array;	
	}
	
	public function cansInEvent($event_id)
	{
		return $this->db->select('fk_can_id')->from('cn_idx_candidates_events')->where('fk_event_id', $event_id)->get()->result_array();
	}
	
	private function adminCandidate()
	{
		if(isset($_POST))
		{
			unset($_POST['submitted']);
			if(isset($_POST['can_password_confirm'])) unset($_POST['can_password_confirm']);
			
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

	public function canAvatar($can_id)
	{
		$return = $this->db->select('user_avatar')->from('cn_users')->where('fk_can_id', $can_id)->get()->row()->user_avatar;
		$return = unserialize($return);
		return $return['file_name'];
	}
	
	public function linkToProfile($can_id)
	{
		$display_name = $this->nameByUser($can_id);
		$user_name = $this->user_name($can_id);
		return anchor("/user/profile/$user_name", $display_name);
	}
}
?>