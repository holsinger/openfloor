<?php

class Classroom_model extends Model 
{
	public $id;
	
	function __construct()
    {
        parent::Model();
    }
    
    function insert($arg_data){
		$this->db->insert('cn_classroom', $arg_data); 
		return $this->db->insert_id();
    }
    
    function list_by_user($user_id)
    {
    	$this->db->where('fk_creator_id', $user_id);
    	$query = $this->db->get("cn_classroom");
    	return $query->result_array();
    }
    
    function get($classroom_id)
    {
    	$this->db->where('classroom_id', $classroom_id);
    	$query = $this->db->get("cn_classroom");
    	return $query->first_row('array');
    }
    
    function delete($classroom_id)
    {
    	$this->db->delete('cn_classroom', array('classroom_id' => $classroom_id));
    	
    	return $this->db->last_query();
    }
    
    function delete_idx_cls_stu($classroom_id)
    {
    	$this->db->delete('cn_idx_class_students', array('fk_classroom_id' => $classroom_id));
    	
    	return $this->db->last_query();
    }
    
    function get_students_count($classroom_id)
    {
    	$this->db->where('fk_classroom_id', $classroom_id);
    	$query = $this->db->get('cn_idx_class_students');
    	
    	return $query->num_rows();
    }
    
    function get_students($classroom_id)
    {
    	$sql = "
    			SELECT 
    				* 
    			FROM 
    				cn_users as u, cn_idx_class_students as c 
    			WHERE 
    				u.user_id = c.fk_student_id 
    			AND 
    				c.fk_classroom_id = $classroom_id
    	";
    				
    	$query = $this->db->query($sql);
    	
    	return $query->result_array();
    }
    
    function delete_student($classroom_id, $student_id)
    {
    	$this->db->delete('cn_idx_class_students', array('fk_classroom_id' => $classroom_id, 'fk_student_id' => $student_id));
    	
    	return $this->db->last_query();
    }
    //select * from cn_users where user_id not in (SELECT fk_student_id FROM cn_idx_class_students c where c.fk_classroom_id = 6)
    
    function get_other_students($classroom_id)
    {
    	$sql = "
    			SELECT 
    				* 
    			FROM 
    				cn_users 
    			WHERE 
    				user_id 
    			NOT IN 
    				(
    				SELECT 
    					fk_student_id 
    				FROM 
    					cn_idx_class_students c 
    				WHERE 
    					c.fk_classroom_id = $classroom_id
    				)
    			AND 
    				user_security_level >= 4
    			";
    				
    	$query = $this->db->query($sql);
    	
    	return $query->result_array();
    }
    
    function insert_cls_stu($arg_data)
    {
    	$this->db->insert('cn_idx_class_students', $arg_data);
    	
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