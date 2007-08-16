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
		return $this->db->get('cn_flag_types')->result();
	}
	
	public function alreadyFlagged($fk_id, $reporter_id)
	{
		if(!in_array($this->type, array('question', 'user'))) show_error('Flag_model::type: invalid type');
		
		$this->db->where(array("fk_{$this->type}_id" => $fk_id, 'fk_reporter_id' => $reporter_id));
		$result = $this->db->get('cn_flags')->result();
			
		return !empty($result);
	}
	
	public function flagQuestion($question_id, $type_id, $reporter_id)
	{
		#TODO insert IP
		$this->db->set(array('fk_question_id' => $question_id, 'fk_type_id' => $type_id, 'fk_reporter_id' => $reporter_id));
		$this->db->insert('cn_flags');
	}
}

?>