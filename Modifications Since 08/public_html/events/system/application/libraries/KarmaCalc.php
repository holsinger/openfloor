<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class KarmaCalc {
		
	var $karma_base=20;
	var $min_karma=10;
	var $max_karma=100;
	var $negative_per_day = 0.01;
	var $history_from = 0;
	var $points_question_user = 25;
	var $points_vote_user = 15;
	
	var $total_question_users;
	var $total_questions;
	var $total_asked;
	var $total_votes;
	var $total_asked_votes;
	
		var $max_asked;
		var $max_asked_vote;		
		var $question_asked_coef;
		var $question_asked_votes_coef;
		var $avg_asked_votes;
		
	function __construct() 
	{
		
		//we need to get access to the CI object
		$this->CI=& get_instance();		
		
		//load stuff
		$this->CI->load->model('User_model','user');
		$this->CI->load->model('Question_model','question');
		$this->CI->load->model('Vote_model','vote');
	}
	
	public function set_time ($history_time)
	{
		//set time 
		$this->history_from = $history_time; #one week
	}
		
	public function set_coeff () 
	{
		$string = '';
		/////////////////////////
		$query = $this->CI->db->query("SELECT count(*) as total FROM cn_questions WHERE timestamp > FROM_UNIXTIME({$this->history_from}) AND question_status != 'deleted'")->result_array();
		//echo $this->CI->db->last_query();
		$total_questions = $query[0]['total'];

		
		$query = $this->CI->db->query("SELECT count(*) as total FROM cn_questions WHERE timestamp > FROM_UNIXTIME({$this->history_from}) AND question_status = 'asked'")->result_array();
		//echo $this->CI->db->last_query();
		$total_asked = $query[0]['total'];
		
		$this->CI->db->where('timestamp >',"FROM_UNIXTIME({$this->history_from})");
		$total_votes = $this->CI->db->count_all('cn_votes');
		
		#TODO only count pre-asked votes
		$query = $this->CI->db->query("SELECT count(*) as total from cn_votes, cn_questions  WHERE cn_votes.timestamp > FROM_UNIXTIME({$this->history_from}) and cn_questions.question_id = cn_votes.fk_question_id and cn_questions.question_status = 'asked'");
		$data = $query->result_array();
		$total_asked_votes = $data[0]['total'];
		$query->free_result();		
		
		$query = $this->CI->db->query("select count(*) as total from cn_users,cn_questions where cn_questions.timestamp > FROM_UNIXTIME({$this->history_from}) and cn_questions.question_status != 'deleted' and cn_users.user_id = cn_questions.fk_user_id");
		$data = $query->result_array();
		$total_question_users = $data[0]['total'];
		$query->free_result();
		
		
		$string .= "Total question users: $total_question_users\n<br />";
		$string .= "Questions: $total_questions, Asked: $total_asked\n<br />";
		$string .= "Votes: $total_votes, Asked Votes: $total_asked_votes\n<br />";
		
		//set class vars
		$this->total_question_users = $total_question_users;
		$this->total_questions = $total_questions;
		$this->total_asked = $total_asked;
		$this->total_votes = $total_votes;
		$this->total_asked_votes = $total_asked_votes;
		
		///////////////////////
		$query = $this->CI->db->query("SELECT count(*) as questions, cn_users.user_id from cn_questions, cn_users WHERE cn_questions.timestamp > FROM_UNIXTIME({$this->history_from}) and cn_questions.fk_user_id=cn_users.user_id and cn_questions.question_status = 'asked' group by cn_users.user_id order by questions desc limit 1");
		$row = $query->result_array(); 
		log_message('debug', "max_asked:".trim($this->CI->db->last_query()));
		$max_asked = $row[0]['questions'];
		$query->free_result();
		
		#TODO only count pre-asked votes
		$query = $this->CI->db->query("SELECT count(*) as votes, cn_users.user_id from cn_votes, cn_users, cn_questions WHERE cn_votes.timestamp > FROM_UNIXTIME({$this->history_from}) and cn_votes.fk_user_id=cn_users.user_id and cn_questions.question_id = cn_votes.fk_question_id and cn_questions.question_status = 'asked' group by cn_users.user_id order by votes desc limit 1");
		$row = $query->result_array(); 
		log_message('debug', "max_asked_vote:".trim($this->CI->db->last_query()));
		$max_asked_vote = $row[0]['votes'];
		$query->free_result();
		
		
		$string .= "MAX Votes = $max_asked_vote\n<br />";
		
		//set class vars
		$this->max_asked = $max_asked;
		$this->max_asked_vote =$max_asked_vote;
		
		$this->question_asked_coef = $total_asked / $max_asked;
		$this->question_asked_votes_coef = $total_asked_votes / $max_asked_vote;
		$this->avg_asked_votes = .66*($total_asked_votes/$total_votes);
		
		
		$string .= "AVG published votes: $this->avg_asked_votes\n<br />";
		
		return $string;
		
	}
	
	/**
	 * this function set a single users karam
	 * 
	 * @param array $user the user stat values
	 * 
	 * @auther James Kleinschnitz (insperatiion from pligg)
	 */
	public function user_karma ($user)
	{
		$detractors = 0;
		$promoters = 0;
		
		if ($this->CI->userauth->isAdmin()){
			//* (0) 24 hours elapses and you have not responded to an alert
			if (!empty($user['alert_24'])) $detractors += $user['alert_24'];
			//* (0) 56 hours elapses and you have not responded to an alert
			if (!empty($user['alert_56'])) $detractors += $user['alert_56'];
			//* (1) Your answer given receives more 0-6 votes than 9-10 votes from students
			//* (9) An answer you give receives more 9-10 votes than 0-6 votes from students
			if (!empty($user['answer_rate']))
			{
				foreach ($user['answer_rate'] as $k => $rate)
				{
					if ($rate > 0) $promoters += 1;
					elseif ($rate < 0) $detractors += 1;
				}
			}
			//* #todo (4) You log into an event but do nothing during the event ¨C you take no actions
			//* (10) You provide an additional answer after an event is closed
			if (!empty($user['finished_question_answer'])) $promoters += $user['finished_question_answer'];
			//* (10) You promote a question somewhere in the queue
			if (!empty($user['t_flagged_promoted'])) $promoters += $user['t_flagged_promoted'];
			//* (10) You create an OpenFloor event/instance in response to a student-generated request
			//* (9) You respond to an alert within 5 hours
			if (!empty($user['alert_5'])) $promoters += $user['alert_5'];
			//* (9) Teacher makes a comment on a question
			if (!empty($user['comments'])) $promoters += $user['comments'];
		}
		elseif (!$this->CI->userauth->isAdmin()){
			//* (0) Your account is frozen
			if (!empty($user['user_freeze'])) $detractors += 1;
			//* (1) Your question receives 50 down votes
			if (!empty($user['down_votes'])) 
			{
				if ($user['down_votes'] >= 50) $detractors += 1;
			}
			
			
			//* (1)You do not log into an event that you are required to attend
			
			
			//* (6) Your question receives the 3rd inappropriate flag from another student
			//* (4) Your question receives the 4th inappropriate flag from another student
			//* (2) Your question receives the 5th inappropriate flag from another student
			if (!empty($user['s_inappropriate_flag']))
			{
				foreach ($user['s_inappropriate_flag'] as $k => $count)
				{
					if ($count == 3) $detractors += 1;
					if ($count == 4) $detractors += 1;
					if ($count == 5) $detractors += 1;
				}
			}
			//* (2) A teacher agrees with the students¡¯ inappropriate flag votes, and deletes your question
			if (!empty($user['agree_inappropriate'])) $detractors += $user['agree_inappropriate'];
			 
			//* #todo(4) You log into an event but do nothing during the event ¨C you take no actions
			
			//* (6) Your question receives the 3rd duplicate flag vote from another student
			//* (6) Your question receives the 5th duplicate flag vote from another student
			if (!empty($user['s_duplicate_flag']))
			{
				foreach ($user['s_duplicate_flag'] as $k => $count)
				{
					if ($count == 3) $detractors += 1;
					if ($count == 5) $detractors += 1;
				}
			}
			//* (6) A teacher agrees with the students¡¯ duplicate flag votes, and deletes your question
			if (!empty($user['agree_duplicate'])) $detractors += $user['agree_duplicate'];
			
			//* (10) Your question is popular and receives 100 total votes, and/or 50 total comments
			if (!empty($user['s_votes']) || !empty($user['s_comments']))
			{
				if ($user['s_votes'] >= 100 || $user['s_comments'] >= 50) $promoters += 1;
			}
			//* (10) Your question gets answered
			if (!empty($user['answers_got'])) $promoters += $user['answers_got'];
			//* (10) Your question gets flagged as ¡°promoted¡± by the teacher
			if (!empty($user['s_flagged_promoted'])) $promoters += $user['s_flagged_promoted'];
			
			//* #todo(10) You request an OpenFloor event/instance
			
			//* (10) Your question gets 50 up votes and/or 25 comments
			if (!empty($user['up_votes']) || !empty($user['comments_25']))
			{
				if ($user['up_votes'] >= 50 || $user['comments_25'] >= 25) $promoters += 1;
			}
			//* (9) You give feedback to a teacher/respondent when they answer a question
			if (!empty($user['feedback'])) $promoters += $user['feedback'];
			//* (9) You make a comment
			if (!empty($user['yours_comments'])) $promoters += $user['yours_comments'];
			//* (9) You vote on someone else¡¯s question
			if (!empty($user['vote_someone_else'])) $promoters += $user['vote_someone_else'];
		}
		$karma = ($promoters - $detractors) / ($promoters + $detractors) * 100;
		return ceil($karma);
	}
}
		
?>