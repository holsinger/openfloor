<?php

class Question_model extends Model 
{
	//vars

	var $date_begin;
	var $date_end;
	var $user_id;
	var $question_status = 'pending'; //pending, current, asked, deleted
	var $event_id;
	var $question_id;
	var $tag_id;
	var $order_by = 'votes'; //date,votes,
	var $offset;
	var $limit;
	
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
	
	public function updateQuestion ($question_id, $array) 
	{
		$this->db->where ('question_id',$question_id);
		if (isset($array['question_name'])) $this->db->set ('question_name',$array['question_name']);
		if (isset($array['question_url_name'])) $this->db->set ('question_url_name',$array['question_url_name']);
		if (isset($array['question_desc'])) $this->db->set ('question_desc',$array['question_desc']);
		if (isset($array['question_status'])) $this->db->set ('question_status',$array['question_status']);
		if (isset($array['question_answer'])) $this->db->set ('question_answer',$array['question_answer']);
		$this->db->update('cn_questions');
		log_message('debug', "updateQuestion:".trim($this->db->last_query()));
		return $this->db->affected_rows();
	}
	
	public function questionQueue ()
	{	
		$where = '';
		$where .= (isset($this->date_begin)) ? " AND event_date >= $this->date_begin" : '' ;
		$where .= (isset($this->date_end)) ? " AND event_date <= $this->date_end" : '' ;
		$where .= (isset($this->user_id)) ? " AND user_id = $this->user_id" : '' ;
		$where .= (isset($this->question_status)) ? " AND question_status = '$this->question_status'" : '' ;
		$where .= (isset($this->event_id)) ? " AND event_id = $this->event_id" : '' ;
		$where .= (isset($this->question_id)) ? " AND question_id = $this->question_id" : '' ;
		$where .= (isset($this->tag_id)) ? " AND tag_id = $this->tag_id" : '' ;
		
		$limit = '';
		if (isset($this->limit) && isset ($this->offset)) {
			$limit .= "LIMIT $this->offset, $this->limit";
		} elseif (isset($this->limit)) {
			$limit .= "LIMIT $this->limit";
		}
		
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
			DESC 
				$limit");
		log_message('debug', "questionQueue:".trim($this->db->last_query()));
		return $query->result_array();
	}
	
	/**
	 * return the id from the question url name
	 * 
	 * @param string $url event url name
	 * @author James Kleinschnitz
	 */
	public function get_question ($id, $url='')
	{
		 $result_array = array(); 
		 if ($id) $this->db->where('question_id',$id);
		 if ($url) $this->db->where('question_url_name',$url);
		 $query = $this->db->get('cn_questions');
		 log_message('debug', "QUESTIONS:getQuestions:".trim($this->db->last_query()));
		 $result_array = $query->result_array();
		 return $result_array[0];
	}
	
	/**
	 * return the id from the question url name
	 * 
	 * @param string $url event url name
	 * @author James Kleinschnitz
	 */
	public function get_id_from_url ($url)
	{
		 $result_array = $this->get_question(0,$url);
		 return $result_array['question_id'];
	}
	
	public function numQuestions()
	{
		return $this->db->count_all('cn_questions');
	}
}
?>