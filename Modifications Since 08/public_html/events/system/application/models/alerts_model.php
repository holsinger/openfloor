<?php

class Alerts_model extends Model 
{
	public $id;
	
	function __construct()
    {
        parent::Model();
    }
    
    function insertAlert($arg_data){
		$this->db->insert('cn_alerts', $arg_data); 
		return $this->db->insert_id();
    }
    
    function updateAlert($arg_data){
		$this->db->where('alert_id', (int) $this->id);
		$this->db->update('cn_alerts', $arg_data);
		
		return $this->db->last_query();
    }
    
    public function getAlert($question_id, $alert_type) {
    	return $this->db->query("	SELECT
    									* 
    								FROM 
    									cn_alerts 
    								WHERE 
    									fk_question_id = $question_id 
    								AND 
    									alert_type = '" . $alert_type . "' 
    	")->result_array();
    }
    
    function getQuestionAttention($user_id){
		return $this->db->query("	SELECT
    									q.question_name
    								FROM
    									cn_questions as q, cn_alerts as a 
    								WHERE
    									q.question_id = a.fk_question_id 
    								AND
    									a.fk_user_id = $user_id 
    								AND
    									(a.alert_type = 'flag_inappropriate_student' 
    									 OR 
    									 a.alert_type = 'flag_duplicate_student')
    								AND
    									status = 0")->result_array();
    }
    
    function getQuestionFlagged($user_id) {
    	return $this->db->query("	SELECT
    									q.question_name
    								FROM
    									cn_questions as q, cn_alerts as a 
    								WHERE
    									q.question_id = a.fk_question_id 
    								AND
    									a.fk_user_id = $user_id 
    								AND
    									(a.alert_type = 'flag_inappropriate' 
    									 OR 
    									 a.alert_type = 'flag_duplicate')
    								AND
    									status = 0")->result_array();
    }
}

?>