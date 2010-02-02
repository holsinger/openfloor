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
	
	public function flagged($fk_id)
	{
		if(!in_array($this->type, array('question', 'user'))) show_error('Flag_model::type: invalid type');
		$this->db->where(array("fk_{$this->type}_id" => $fk_id, 'fk_type_id' => 0));
		$result = $this->db->get('cn_flags')->result();
		
		return !empty($result);
	}
	
	public function flag($fk_id, $type_id, $reporter_id, $result_question_id = NULL)
	{
		#TODO insert IP
		$this->db->set(array("fk_{$this->type}_id" => $fk_id, 'fk_type_id' => $type_id, 'fk_reporter_id' => $reporter_id, 'ip' => $this->session->userdata['ip_address'], 'object_question_id' => $result_question_id));
		$this->db->insert('cn_flags');
		error_log(trim($this->db->last_query()));
		log_message('debug', "insertFlag:".trim($this->db->last_query()));
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
	
	public function getFlagsByUser($user_id, $all = false){
		$limit = ($all) ? '' : 'LIMIT 10' ;
		//SELECT `comment`, q.question_name, e.event_name from cn_comments, cn_questions as q, cn_events as e where cn_comments.fk_question_id = q.question_id and q.fk_event_id = e.event_id and cn_comments.fk_user_id = 10
		return $this->db->query("	SELECT 
										t.type, q.question_name, e.event_name 
									from 
										cn_flags, cn_questions as q, cn_events as e,cn_flag_types_question as t
									where 
										cn_flags.fk_question_id = q.question_id 
									and 
										q.fk_event_id = e.event_id
									and 
										cn_flags.fk_type_id = t.type_id
									and 
										cn_flags.fk_reporter_id = $user_id 
									ORDER BY 
										cn_flags.timestamp DESC  
									$limit")->result_array();
	}
	
	public function getQuestionAttention()
	{
		$limit = ($all) ? '' : 'LIMIT 10' ;
		return $this->db->query("	SELECT
										t.type, q.question_name, e.event_name, cn_flags.flag_id, q.question_id, cn_flags.object_question_id, t.type_id 
									from
										cn_flags, cn_questions as q, cn_events as e,cn_flag_types_question as t
									where
										cn_flags.fk_question_id = q.question_id
									and
										q.fk_event_id = e.event_id
									and
										t.type_id = cn_flags.fk_type_id
									and
										(cn_flags.fk_type_id = 5 or cn_flags.fk_type_id = 6) 
									and 
										cn_flags.fk_question_id not in (
																	select 
																		fk_question_id duplicate   
																	from 
																		cn_flags 
																	where 
																		cn_flags.fk_type_id = 1 
																	or 
																		cn_flags.fk_type_id = 2
																)
									ORDER BY
										cn_flags.timestamp DESC $limit")->result_array();
	}
	
	public function checkStrikeAgainst($user_id)
	{
		$query = $this->db->query(
		"SELECT 
			flag_id 
		FROM 
			`cn_flags` as f,
			`cn_questions` as q 
		WHERE 
			f.fk_question_id = q.question_id 
		AND 
			f.fk_type_id = 1 
		AND 
			q.fk_user_id = " . $user_id
		);
		if ($query->num_rows() >= 3)
			return true;
		return false;
	}
	//$parameters = array('question_status' => 'deleted','flag_reason' => 'other', 'flag_reason_other' => 'duplicate');
	
	public function checkStudentFlag($question_id,$type_id)
	{
		$query = $this->db->query(
		"SELECT 
			flag_id 
		FROM 
			`cn_flags` as f
		WHERE 
			f.fk_question_id = " . $question_id . "
		AND 
			f.fk_type_id = " . $type_id
		);
		if ($query->num_rows() >= 5)
			return true;
		return false;
	}
	public function deleteStudentFlag($flag_id)
	{
		$this->db->delete('cn_flags', array('flag_id' => $flag_id));
	}
}

?>