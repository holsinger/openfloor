<?php

class Question_model extends Model 
{
	//vars

	var $date_begin = '';
	var $date_end = '';
	var $user_id = 0;
	var $question_status = ''; //pending, current, asked, deleted
	var $event_id = 0;
	var $question_id = 0;
	var $tag_id = 0;
	var $order_by = ''; //date,votes,
	
 	function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
    
	public function insertQuestion($questionName, $questionDesc, $userID, $eventID)
	{
		$query = "INSERT INTO cn_questions (question_name, question_desc, fk_user_id, fk_event_id) ";
		$query .="VALUES ('$questionName', '$questionDesc', $userID, $eventID)";		
		$this->db->query($query);
		
		return $this->db->insert_id();
	}
	
	/**
	 * TODO this function will return any array of question data based on the set class variables
	 */
	public function questionQue (){
		$question_array = array();
		
		$query = $this->db->query('SELECT question_id, (SELECT format(sum(vote_value)/10,0) AS number FROM cn_votes WHERE fk_question_id=question_id GROUP BY fk_question_id) as votes, question_name, question_desc, user_name, event_name FROM cn_questions, cn_events, cn_users WHERE fk_user_id=user_id AND fk_event_id=event_id ORDER BY votes DESC');
		$question_array = $query->result_array();
		
		return $question_array;
	}
}
?>