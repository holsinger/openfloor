<?php

class Flag_model extends Model 
{
	public $type;
	
	function __construct()
    {
        parent::Model();
    }
    
	public function getFlagTypes()
	{
		if(!in_array($this->type, array('question', 'user'))) show_error('Flag_model::type: invalid type');		
		return $this->db->get("cn_flag_types_{$this->type}")->result();
	}
	
	public function alreadyFlagged($fk_id, $reporter_id)
	{
		if(!in_array($this->type, array('question', 'user'))) show_error('Flag_model::type: invalid type');
		
		$this->db->where(array("fk_{$this->type}_id" => $fk_id, 'fk_reporter_id' => $reporter_id));
		$result = $this->db->get('cn_flags')->result();
			
		return !empty($result);
	}
	
	public function flag($fk_id, $type_id, $reporter_id)
	{
		#TODO insert IP
		$this->db->set(array("fk_{$this->type}_id" => $fk_id, 'fk_type_id' => $type_id, 'fk_reporter_id' => $reporter_id));
		$this->db->insert('cn_flags');
	}
	
	public function last_10()
	{
		$return = array();
		$flags = $this->db->orderby('flag_id', 'desc')->limit(10)->get('cn_flags')->result();
		foreach($flags as $flag) $return[] = $this->_flagInformation($flag);
		return $return;
	}
	
	private function _flagInformation($flag)
	{
		if(isset($flag->fk_user_id)) {
		 	$return = array();
			$type = $this->db->select('type')->where('type_id', $flag->fk_type_id)->get('cn_flag_types_user')->row()->type;
			$object = $this->db->select('user_name')->where('user_id', $flag->fk_user_id)->get('cn_users')->row()->user_name;
			$reporter = $this->db->select('user_name')->where('user_id', $flag->fk_reporter_id)->get('cn_users')->row()->user_name;
			$return['type'] = 'user';
		} else {
			$return = array();
			$type = $this->db->select('type')->where('type_id', $flag->fk_type_id)->get('cn_flag_types_question')->row()->type;
			$object = $this->db->select('question_name')->where('question_id', $flag->fk_question_id)->get('cn_questions')->row()->question_name;
			$reporter = $this->db->select('user_name')->where('user_id', $flag->fk_reporter_id)->get('cn_users')->row()->user_name;
			$return['type'] = 'question';
		}
		$return['flag'] = $type;
		$return['object'] = $object;
		$return['reporter'] = $reporter;
		return $return;		
	}
}

?>