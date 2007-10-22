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
		$this->load->model('tag_model');
		
    }
    
	public function insertQuestion($questionName='', $questionDesc='', $userID=0, $eventID=0, $questionURLName='')
	{
		$questionName = $this->db->escape($questionName);
		$questionDesc = $this->db->escape($questionDesc);
		$userID = $this->db->escape($userID);
		$eventID = $this->db->escape($eventID);
		$questionURLName = $this->db->escape($questionURLName);
		
		$query = "INSERT INTO cn_questions (question_name, question_url_name, question_desc, fk_user_id, fk_event_id) ";
		$query .="VALUES ($questionName, $questionURLName, $questionDesc, $userID, $eventID)";		
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
		$tag_append = '';
		
		$where .= (isset($this->date_begin)) ? " AND event_date >= $this->date_begin" : '' ;
		$where .= (isset($this->date_end)) ? " AND event_date <= $this->date_end" : '' ;
		$where .= (isset($this->user_id)) ? " AND user_id = $this->user_id" : '' ;
		$where .= (isset($this->question_status)) ? " AND question_status = '$this->question_status'" : '' ;
		$where .= (isset($this->event_id)) ? " AND event_id = $this->event_id" : '' ;
		$where .= (isset($this->question_id)) ? " AND question_id = $this->question_id" : '' ;
		
		if(isset($this->tag_id)) {
			$tag_append = ', cn_idx_tags_questions';
			$where .= " AND	fk_tag_id=$this->tag_id	AND cn_idx_tags_questions.fk_question_id = question_id";
		}
		
		$limit = '';
		if (isset($this->limit) && isset ($this->offset)) {
			$limit .= "LIMIT $this->offset, $this->limit";
		} elseif (isset($this->limit)) {
			$limit .= "LIMIT $this->limit";
		}
		
		$query = $this->db->query(
			"SELECT 
				question_id, 
				IFNULL((SELECT 
					cast(format(sum(vote_value)/10,0) as signed) AS number 
				FROM 
					cn_votes 
				WHERE 
					fk_question_id=question_id 
				AND vote_id IN (SELECT max(vote_id) FROM cn_votes WHERE fk_question_id = question_id GROUP BY fk_user_id)	 					
				GROUP BY fk_question_id), 0) as votes,
				(SELECT count(*) FROM cn_comments WHERE fk_question_id=question_id) as comment_count,
				question_name, 
				question_desc,
				question_status,
				question_answer,
				cn_questions.timestamp as date, 
				user_name,
				user_id, 
				user_avatar,
				event_name,
				event_desc,
				event_url_name,
				location
			FROM 
				cn_questions, 
				cn_events, 
				cn_users
				$tag_append 
			WHERE 
				cn_questions.fk_user_id=user_id 
				$where
			AND 
				fk_event_id=event_id 
			ORDER BY 
				$this->order_by 
			DESC 
				$limit");
		log_message('debug', "questionQueue:".trim($this->db->last_query()));
		$results = $query->result_array();
		
		// get our tags real quick & determine how old the question is
		foreach($results as $k=>$v) {
			# TODO this method for getting the vote count is not as speed friendly as the monolithic single-query above
			// I was unsuccessful getting this into the query above because of the double-nested sub-query
			$results[$k]['vote_count'] = $this->db->query("SELECT count(*) AS vote_count FROM (SELECT * FROM cn_votes WHERE fk_question_id = {$v['question_id']} GROUP BY fk_user_id) AS sq")->row()->vote_count;
			$tags = $this->tag_model->getTagsByQuestion($v['question_id']);
			if(empty($tags))
				$results[$k]['tags'] = array();
			else	
				foreach($tags as $v2)
					$results[$k]['tags'][] = $v2['value'];	
		}
		return $results;
	}
	
	public function get_question ($id, $url='')
	{
		 $result_array = array(); 
		 if ($id) $this->db->where('question_id',$id);
		 if ($url) $this->db->where('question_url_name',$url);
		if($this->event_id) $this->db->where('fk_event_id', $this->event_id);
		 $query = $this->db->get('cn_questions');
		 log_message('debug', "QUESTIONS:getQuestions:".trim($this->db->last_query()));
		 $result_array = $query->result_array();
		 return $result_array[0];
	}
	
	public function get_id_from_url ($url)
	{
		$result_array = $this->get_question(0,$url);
		return $result_array['question_id'];
	}
	
	public function numQuestions($event_id)
	{
		$result = $this->db->query("SELECT count(*) as count FROM cn_questions WHERE fk_event_id=$event_id")->result_array();
		return $result[0]['count'];
	}
	
	/**
	 * make sure the given event has only the given question marked current
	 */
	public function singleCurrent ($event_id,$question_id) 
	{
		$this->db->where('fk_event_id',$event_id);
		$this->db->where('question_id !=',$question_id);
		$this->db->where('question_status','current');
		$query = $this->db->get('cn_questions');
		log_message('debug', "QUESTIONS:singleCurrent:".trim($this->db->last_query()));
		$result_array = $query->result_array();
		foreach ($result_array as $row) {
			$this->db->where('question_id',$row['question_id']);
			$this->db->set ('question_status','asked');
			$this->db->update('cn_questions');
			$question_id = $row['question_id'];
		}
		return $question_id;
	}
	 
	public function getQuestionsByUser($user_id, $all = false)
	{
		$limit = ($all) ? '' : 'LIMIT 10' ;
		return $this->db->query("SELECT event_name, question_name FROM cn_questions, cn_events WHERE fk_event_id = event_id AND fk_user_id = $user_id $limit")->result_array();
	}	

	public function rss_questions_by_tag($tag)
	{
		$tag = $this->db->escape($tag);
		return $this->db->query("	SELECT question_id, question_name, question_desc, event_name 
									FROM cn_questions, cn_idx_tags_questions, cn_tags, cn_events 
									WHERE fk_question_id = question_id 
									AND fk_event_id = event_id
									AND fk_tag_id = tag_id 
									AND value = $tag")->result();
	}

	public function last_10()
	{
		return $this->db->select('question_name')->orderby('question_id', 'desc')->limit(10)->get('cn_questions')->result();
	}

	public function set_asked_time($question_id)
	{
		$this->db->query("UPDATE cn_questions SET question_asked = now() WHERE question_id = $question_id");
	}

	public function get($field)
	{
		return $this->db->select($field)->where('question_id', $this->question_id)->get('cn_questions')->row()->$field;
	}
}
?>