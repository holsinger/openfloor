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
	var $flag_reason;
	var $flag_reason_other;
	
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
		if (isset($array['flag_reason'])) $this->db->set ('flag_reason',$array['flag_reason']);
		if (isset($array['flag_reason_other'])) $this->db->set ('flag_reason_other',$array['flag_reason_other']);
		$this->db->update('cn_questions');
		error_log(trim($this->db->last_query()));
		log_message('debug', "updateQuestion:".trim($this->db->last_query()));
		return $this->db->affected_rows();
	}
	
	public function questionQueue()
	{
		$where = '';
		$tag_append = '';
		
		$where .= (isset($this->date_begin)) ? " AND event_date >= $this->date_begin" : '' ;
		$where .= (isset($this->date_end)) ? " AND event_date <= $this->date_end" : '' ;
		$where .= (isset($this->user_id)) ? " AND user_id = $this->user_id" : '' ;
		$where .= (isset($this->question_status)) ? " AND question_status = '$this->question_status'" : '' ;
		$where .= (isset($this->event_id)) ? " AND event_id = $this->event_id" : '' ;
		$where .= (isset($this->question_id)) ? " AND question_id = $this->question_id" : '' ;
		$where .= (isset($this->flag_reason)) ? " AND flag_reason = '$this->flag_reason'" : '' ;
		$where .= (isset($this->flag_reason_other)) ? " AND flag_reason_other = '$this->flag_reason_other'" : '' ;
		
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
				location,
				flag_reason,
				flag_reason_other
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
	
	/**
	 * Returns a question record
	 *
	 * @return void
	 * @author Rob S, Clark Endrizzi (cleaned up)
	 **/
	public function get_question ($id, $url='')
	{
		 $result_array = array(); 
		
		 $query = $this->db->query("SELECT 
		 								* 
		 							FROM 
		 								cn_answers as a, cn_questions as q 
		 							WHERE 
		 								a.fk_question_id = q.question_id 
		 							AND 
		 								a.fk_question_id = $id");
		 log_message('debug', "QUESTIONS:getQuestions:".trim($this->db->last_query()));
		 $result_array = $query->result_array();
		
		 return $result_array[0];
	}
	
	public function get_answer ($id, $url='')
	{
		 $result_array = array(); 
		
		 $query = $this->db->query("SELECT 
		 								* 
		 							FROM 
		 								cn_answers as a, cn_questions as q 
		 							WHERE 
		 								a.fk_question_id = q.question_id 
		 							AND 
		 								a.fk_question_id = $id 
		 							AND 
		 								a.fk_user_id = {$this->userauth->user_id}");
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
	 
	public function getAnsweredByUser($user_id, $all = false)
	{
		$limit = ($all) ? '' : 'LIMIT 10' ;
		return $this->db->query("SELECT event_name, question_name, question_answer FROM cn_questions, cn_events WHERE fk_event_id = event_id AND question_status = 'asked' AND fk_user_id = $user_id $limit")->result_array();
	}

	// ============================================================================
	// = get_next_question - Returns the next question that has the highest votes =
	// ============================================================================
	public function get_next_question($event_id)
	{
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
			WHERE 
				cn_questions.fk_user_id=user_id 
				AND event_id = $event_id
				AND question_status = 'pending'
			AND 
				fk_event_id=event_id 
			ORDER BY 
				$this->order_by DESC
			LIMIT 1"
		);
		$results = $query->result_array();
		return $results[0]['question_id']; 
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

	public function current_question($event_id)
	{
		return $this->db->select('question_name')->where(array('fk_event_id' => $event_id, 'question_status' => 'current'))->get('cn_questions')->row()->question_name;
	}
	
	public function upcoming_question($event_id)
	{
		return $this->db->query(
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
				question_name 
			FROM 
				cn_questions, 
				cn_events 
			WHERE 
				event_id = 2
			AND 
				fk_event_id=event_id AND question_status = 'pending'
			ORDER BY 
				votes
			DESC 
			LIMIT 1")->row();
	}

	public function change_to_current($event_id, $question_id)
	{
		$this->db->update(
			'cn_questions',
			array('question_status' => 'asked'),
			array('question_status' => 'current', 'fk_event_id' => $event_id)
		);
		
		$this->db->update(
			'cn_questions',
			array('question_status' => 'current'),
			array('question_id' => $question_id)
		);
	}

	public function count_upcoming_questions($event_id)
	{
		return $this->db->query("SELECT count(*) AS count FROM cn_questions WHERE question_status='{$this->question_status}' AND fk_event_id=$event_id")->row()->count;
	}

	public function count_flagged_questions($event_id)
	{
		return $this->db->query("SELECT count(*) AS count FROM cn_questions WHERE question_status='{$this->question_status}' AND flag_reason='{$this->flag_reason}' AND flag_reason_other='{$this->flag_reason_other}' AND fk_event_id=$event_id")->row()->count;
	}
	
	public function getQuestions($event_id)
	{
		$result = $this->db->query("SELECT question_id,question_name FROM cn_questions WHERE fk_event_id=$event_id and question_status <> 'deleted'")->result_array();
		return $result;
	}
	
	public function getQuestionsByUserFlag($user_id)
	{
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
										q.fk_user_id = $user_id 
									ORDER BY 
										cn_flags.timestamp DESC  
									$limit")->result_array();
	}
	
	public function get_feedback($user_id)
	{
		$limit = ($all) ? '' : 'LIMIT 10' ;
		//SELECT `comment`, q.question_name, e.event_name from cn_comments, cn_questions as q, cn_events as e where cn_comments.fk_question_id = q.question_id and q.fk_event_id = e.event_id and cn_comments.fk_user_id = 10
		return $this->db->query("	SELECT 
										q.question_name, a.answer, r.rate 
									FROM 
										cn_questions as q, cn_answers as a, cn_answer_rate as r 
									WHERE 
										q.question_id = a.fk_question_id 
									AND 
										a.answer_id = r.fk_answer_id 
									AND 
										r.fk_user_id = $user_id 
									$limit")->result_array();
	}
	
	public function getPrivateQuestions(){
		return $this->db->query("	SELECT
										question_name
									FROM
										cn_questions 
									WHERE
										question_status = 'pending' 
									AND
										flag_reason = 'other'
									AND
										flag_reason_other = 'private'
								")->result_array();
	}
	
	public function get_answers($question_id) {
		$query = $this->db->query("
									SELECT
										a.answer_id,a.answer,a.fk_user_id,u.user_name
									FROM
										cn_answers as a, cn_questions as q, cn_users as u
									WHERE
                    					a.fk_question_id = q.question_id
									AND
  										a.fk_user_id = u.user_id
									AND
										question_id = $question_id 
								");
		$result = $query->result_array();
//		echo $this->db->last_query();
		return $result;
	}
	
	public function haveAnswered ($question_id, $user_id) {
		$result = $this->db->query("SELECT a.answer_id FROM cn_answers as a WHERE a.fk_question_id = $question_id AND a.fk_user_id = $user_id")->num_rows();
		return $result;
	}
	
	public function insertAnswer ($arg_data) {
		$this->db->insert('cn_answers', $arg_data); 
		return $this->db->insert_id();
	}

    public function updateAnswer($arg_data){
		$this->db->where('fk_question_id', $arg_data['fk_question_id']);
		$this->db->where('fk_user_id', $arg_data['fk_user_id']);
		$this->db->update('cn_answers', $arg_data);
		
		return $this->db->last_query();
    }
    
    public function have_rated($user_id, $answer_id){
    	$result = $this->db->query("SELECT
    									* 
    								FROM 
    									cn_answer_rate as r 
    								WHERE 
    									r.fk_user_id = $user_id 
    								AND 
    									r.fk_answer_id = $answer_id")->num_rows();
    	return $result;
    }
    
    public function insert_answer_rate($arg_data){
    	$this->db->insert('cn_answer_rate', $arg_data);
    	return $this->db->insert_id();
    }
    
    public function update_answer_rate($arg_data){
    	$this->db->where('fk_user_id', $arg_data['fk_user_id']);
    	$this->db->where('fk_answer_id', $arg_data['fk_answer_id']);
    	$this->db->update('cn_answer_rate', $arg_data);
    	
    	return $this->db->last_query();
    }
    
    public function getAnswerRate($question_id){
    	$result = $this->db->query("
    								SELECT 
    									a.fk_user_id, r.rate 
    								FROM 
    									cn_answers as a, cn_answer_rate as r 
    								WHERE 
    									a.answer_id = r.fk_answer_id 
    								AND 
    									a.fk_question_id = $question_id")->result_array();
    	
    	return $result;								
    }
    
    public function get_rates($answer_id)
    {
    	$result = $this->db->query("
    								SELECT 
    									r.rate 
    								FROM 
    									cn_answer_rate as r 
    								WHERE 
    									r.fk_answer_id = $answer_id
    								")->result_array();
    	return $result;
    }
    
    public function save_rate($answer_id, $feedback)
    {
    	$this->db->where('answer_id',$answer_id);
    	$this->db->update('cn_answers', array('rate' => $feedback));
    	return $this->db->last_query();
    }
}
?>