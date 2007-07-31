<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_library
{
	private $question_name;
	private $event_name;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('comments_model');
		$this->CI->load->model('event_model');
		$this->CI->load->model('vote_model','vote');
	}
	
	public function createComments($results)
	{
		$commentHtml = '';
		$question_id = $results[0]['question_id'];
		$this->question_name = url_title($results[0]['question_name']);
		$this->event_name = url_title($results[0]['event_name']);
		
		if (!$comments = $this->CI->comments_model->getCommentsByQuestion($question_id)) {
			$commentHtml .= '<strong>There are no comments yet.</strong>';
		} else {
			foreach ($comments as $v)
				$commentHtml .= $this->createCommentsPod($v, $question_id);
				#TODO CHECK children
		}
		return $commentHtml;
	}
	
	public function createCommentsPod($info, $question_id)
	{
		$votes = ($info['votes'] == null) ? 0 : $info['votes'] ;
		#see if user voted
		$this->CI->vote->type = 'comment';
		$voted = $this->CI->vote->alreadyVoted($info['comment_id'],$this->CI->session->userdata('user_id'));
		
		#resize image
		$image_array = unserialize($info['user_avatar']);
		if ($image_array) $avatar_path = "./avatars/".$image_array['file_name'];
		else $avatar_path = "./images/image01.jpg";
		
		
		//get time diff
		$time_diff = timespan(strtotime($info['date']));
		
		$pod = '<div class="comment_head">';
		//$pod .= '<img src="./images/shrink.php?imgpath='.$avatar_path.'&qt=70&width=16&height=16">';
		$pod .= 'by '.anchor('user/profile/'.$info['user_name'],$info['user_name']);
		$pod .= " ({$time_diff} ago)";
		$pod .= "<span class='comment_voting'>";
		if ($voted < 0) {
			$pod .= "<img src='./images/thumbsUp.png' border='0'>";
			$pod .= " <img src='./images/votedCheckBox.png' border='0'>";
		} else if ($voted > 0) {
			$pod .= " <img src='./images/votedCheckBox.png' border='0'>";
			$pod .= " <img src='./images/thumbsDown.png' border='0'>";
		} else {
			$pod .= anchor("/comment/voteUp/{$info['comment_id']}/{$this->question_name}/{$this->event_name}", "<img src='./images/thumbsUp.png' border='0'>");
			$pod .= " ".anchor("/comment/voteDown/{$info['comment_id']}/{$this->question_name}/{$this->event_name}", "<img src='./images/thumbsDown.png' border='0'>");
		}
		$pod .= "</span>";
		$pod .= "<span class='comment_vote'>{$votes} VOTES</span>"; 
		$pod .= '</div>';
		$pod .= "<p>{$info['comment']}</p>";
		return $pod;
		/*return '<p>' . 
		"$votes votes " . 
		anchor("/comment/voteUp/{$info['comment_id']}/$this->question_name/$this->event_name", '[+] ') . 
		anchor("/comment/voteDown/{$info['comment_id']}/$this->question_name/$this->event_name", '[-] ') . 
		"<strong>Posted by:</strong> {$info['user_name']} <strong>Comment:</strong> {$info['comment']}</p>";*/
	}
}