<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class KarmaCalc {
		
	var $karma_base=10;
	var $min_karma=6;
	var $max_karma=30;
	var $negative_per_day = 0.3;
	var $history_from = 0;
	var $points_question_user = 6;
	var $points_vote_user = 10;
	
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
		if($user['question_count'] > 0) 
			$pnot = ($user['question_count']-$user['question_asked_count'])/($user['question_count']);
		else $pnot = 0;
		$ppub = $user['question_count']/$this->total_asked;
		$karma_1 = -$pnot*$this->points_question_user/5 +  $ppub*$this->points_question_user*$this->question_asked_coef;
	//	echo $user->username . " $pnot, $ppub = $karma_1\n";
	
	
		if($user['vote_count'] > 0) 
			$pnot = $user['vote_asked_count']/$user['vote_count'];
		else $pnot = 0;
	//	$ppub = $user->published_votes/$total_published_votes;
		$karma_2 = ($pnot-$this->avg_asked_votes)*$this->points_vote_user*($user['vote_count']/$this->max_asked_vote);
	
	
		$karma_3 = 0;
		if (strtotime($user['last_activity']) < time()-86400*2) {
			#TODO refigure this data to not just be based off of votes table
			$result_array = $this->CI->db->query("select UNIX_TIMESTAMP(max(timestamp)) as time from cn_votes where fk_user_id={$user['user_id']}")->result_array();
			
			$past_time=time() - $result_array[0]['time'];
			$karma_3 = - min($past_time*$this->negative_per_day/(3600*24), 4);
		}
		$karma = max($karma_base+$karma_1+$karma_2+$karma_3, $this->min_karma);
		$karma = min($karma, $this->max_karma);
		//echo $user['user_id'] . ": $karma\n<br>";
		return ceil($karma);
	}
}
		
?>