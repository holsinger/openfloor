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
			case 'comment':
				return ($this->db->query("SELECT vote_id FROM cn_votes WHERE fk_user_id=$user_id AND fk_comment_id=$fk")->num_rows() > 0) ? true : false;
				break;
			default:
				exit(); // error
				break;
		}		
	}
	
	public function votedScore($question_id, $user_id)
	{
		$query = $this->db->query("SELECT vote_value FROM cn_votes WHERE fk_user_id=$user_id AND fk_question_id=$question_id order by timestamp desc");
		$voted = ($query ->num_rows() > 0) ? true : false ;
		if ($voted) 
		{
			$array = $query->result_array();
			return $array[0]['vote_value'];
		}
		else return $voted;		
	}
	
	public function getVotesByQuestion($question_id)
	{
		return $this->db->query("SELECT user_name, vote_value, timestamp FROM cn_votes, cn_users WHERE fk_question_id = $question_id AND fk_user_id=user_id")->result_array();
		// return $this->db->getwhere('cn_votes', array('fk_question_id' => $question_id))->result_array();
	}
}

?>