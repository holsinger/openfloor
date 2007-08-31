<?php

class Vote_model extends Model 
{
	//vars
	public $type = 'question';
	
 	function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
    
	
	public function voteup($fk_user_id, $fk)
	{
		switch($this->type)
		{
			case 'question':			
				$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_question_id) VALUES (10, $fk_user_id, $fk)");
				break;
			case 'video':			
				$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_video_id) VALUES (10, $fk_user_id, $fk)");
				break;
			case 'comment':
				$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_comment_id) VALUES (10, $fk_user_id, $fk)");
				break;
			default:
				exit(); // error
				break;
		}
	}
	
	public function votedown($fk_user_id, $fk)
	{
		switch($this->type)
		{
			case 'question':			
				$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_question_id) VALUES (-10, $fk_user_id, $fk)");
				break;
			case 'video':			
				$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_video_id) VALUES (-10, $fk_user_id, $fk)");
				break;
			case 'comment':
				$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_comment_id) VALUES (-10, $fk_user_id, $fk)");
				break;
			default:
				exit(); // error
				break;
		}
	}
	
	public function alreadyVoted($fk, $user_id)
	{
		switch($this->type)
		{
			case 'question':			
				return ($this->db->query("SELECT vote_id FROM cn_votes WHERE fk_user_id=$user_id AND fk_question_id=$fk")->num_rows() > 0) ? true : false;
				break;
			case 'video':			
				return ($this->db->query("SELECT vote_id FROM cn_votes WHERE fk_user_id=$user_id AND fk_video_id=$fk")->num_rows() > 0) ? true : false;
				break;
			case 'comment':
				$query = $this->db->query("SELECT vote_value FROM cn_votes WHERE fk_user_id=$user_id AND fk_comment_id=$fk");
				$result = $query->result_array();
				return ($query->num_rows() > 0) ? $result[0]['vote_value'] : 0;
				break;
			default:
				exit(); // error
				break;
		}		
	}
	
	public function votedScore($fk_id, $user_id)
	{
		switch ($this->type) 
		{
		case 'question':			
				$query = $this->db->query("SELECT vote_value FROM cn_votes WHERE fk_user_id=$user_id AND fk_question_id=$fk_id order by timestamp desc");
				break;
			case 'video':			
				$query = $this->db->query("SELECT vote_value FROM cn_votes WHERE fk_user_id=$user_id AND fk_video_id=$fk_id order by timestamp desc");
				break;
			case 'comment':
				$query = $this->db->query("SELECT vote_value FROM cn_votes WHERE fk_user_id=$user_id AND fk_comment_id=$fk_id order by timestamp desc");
				break;
			default:
				$query = $this->db->query("SELECT vote_value FROM cn_votes WHERE fk_user_id=$user_id AND fk_question_id=$ques$fk_idtion_id order by timestamp desc");
				break;
		}
		$voted = ($query ->num_rows() > 0) ? true : false ;
		if ($voted) 
		{
			$array = $query->result_array();
			return $array[0]['vote_value'];
		}
		else return 0;		
	}
	
	public function getVotesByQuestion($question_id)
	{
		return $this->db->query("SELECT user_name, user_avatar, vote_value, timestamp FROM cn_votes, cn_users WHERE fk_question_id = $question_id AND fk_user_id=user_id")->result_array();
		// return $this->db->getwhere('cn_votes', array('fk_question_id' => $question_id))->result_array();
	}
		
	public function getVotesByUser($user_id)
	{
		return $this->db->query("SELECT vote_value, user_name, event_name, question_name FROM cn_questions, cn_votes as v, cn_users, cn_events WHERE  v.fk_user_id = user_id AND v.fk_question_id = question_id AND fk_event_id = event_id AND user_id=$user_id LIMIT 10")->result_array();
	}
	
	public function getVotesByVideo($video_id)
	{
		return $this->db->query("SELECT user_name, vote_value, timestamp FROM cn_votes, cn_users WHERE fk_video_id = $video_id AND fk_user_id=user_id")->result_array();
		// return $this->db->getwhere('cn_votes', array('fk_question_id' => $question_id))->result_array();
	}
	
	public function getVotesByComment($comment_id)
	{
		return $this->db->query("SELECT user_name, vote_value, timestamp FROM cn_votes, cn_users WHERE fk_comment_id = $comment_id AND fk_user_id=user_id")->result_array();
		// return $this->db->getwhere('cn_votes', array('fk_question_id' => $question_id))->result_array();
	}
	
	public function deleteVote($fk_id, $user_id)
	{
		switch ($this->type) 
		{
		case 'question':			
			$this->db->where('fk_question_id', $fk_id);
			$this->db->where('fk_user_id', $user_id);
			$this->db->delete('cn_votes');
			break;
		default:
			break;
		}
	}
}

?>