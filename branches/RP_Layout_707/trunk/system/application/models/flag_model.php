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
}

?>