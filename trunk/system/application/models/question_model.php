<?php

class Question_model extends Model 
{
	//vars

	var $date_begin;
	var $date_end;
	var $user_id;
	var $question_status; //pending, current, asked, deleted
	var $event_id;
	var $question_id;
	var $tag_id;
	var $order_by = 'votes'; //date,votes,
	
 	function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
    
	public function insertQuestion($questionName='', $questionDesc='', $userID='', $eventID='', $questionURLName='')
	{
		$query = "INSERT INTO cn_questions (question_name, question_url_name, question_desc, fk_user_id, fk_event_id) ";
		$query .="VALUES ('$questionName', '$questionURLName', '$questionDesc', $userID, $eventID)";		
		$this->db->query($query);
		
		return $this->db->insert_id();
	}
	
	public function questionQueue ()
	{	
		$where = '';
		$where .= (isset($this->date_begin)) ? " AND event_date >= $this->date_begin" : '' ;
		$where .= (isset($this->date_end)) ? " AND event_date <= $this->date_end" : '' ;
		$where .= (isset($this->user_id)) ? " AND user_id = $this->user_id" : '' ;
		$where .= (isset($this->question_status)) ? " AND question_status = $this->question_status" : '' ;
		$where .= (isset($this->event_id)) ? " AND event_id = $this->event_id" : '' ;
		$where .= (isset($this->question_id)) ? " AND question_id = $this->question_id" : '' ;
		$where .= (isset($this->tag_id)) ? " AND tag_id = $this->tag_id" : '' ;
		
		$query = $this->db->query(
			"SELECT 
				question_id, 
				(SELECT 
					format(sum(vote_value)/10,0) AS number 
				FROM 
					cn_votes 
				WHERE 
					fk_question_id=question_id 
				GROUP BY fk_question_id) as votes, 
				question_name, 
				question_desc,
				cn_questions.timestamp as date, 
				user_name, 
				event_name 
			FROM 
				cn_questions, 
				cn_events, 
				cn_users 
			WHERE 
				fk_user_id=user_id 
				$where
			AND 
				fk_event_id=event_id 
			ORDER BY 
				$this->order_by 
			DESC");
		log_message('debug', "questionQueue:".trim($this->db->last_query()));
		return $query->result_array();
	}
	
	public function voteup($fk_user_id, $fk_question_id)
	{
		$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_question_id) VALUES (10, $fk_user_id, $fk_question_id)");
	}
	
	public function votedown($fk_user_id, $fk_question_id)
	{
		$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_question_id) VALUES (-10, $fk_user_id, $fk_question_id)");
	}
	
	public function alreadyVoted($question_id, $user_id)
	{
		return ($this->db->query("SELECT vote_id FROM cn_votes WHERE fk_user_id=$user_id AND fk_question_id=$question_id")->num_rows() > 0) ? true : false ;		
	}
	
	/**
	 * return the id from the question url name
	 * 
	 * @param string $url event url name
	 * @author James Kleinschnitz
	 */
	public function get_id_from_url ($url)
	{
		 $result_array = array(); 
		 $query = $this->db->getwhere('cn_questions', array('question_url_name' => $url));
		 log_message('debug', "QUESTION:getIDfromURL:".trim($this->db->last_query()));
		 $result_array = $query->result_array();
		 return $result_array[0]['question_id'];
	}
}
?>