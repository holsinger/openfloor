<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_library
{
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('comments_model');
		$this->CI->load->model('event_model');
	}
	
	public function createComments($vars)
	{
		$question_id = $vars['results'][0]['question_id']; // do i still need this?
		$question_name = $vars['results'][0]['question_name'];
		
		if (!$comments = $this->CI->comments_model->getCommentsByQuestion($question_id)) {
			echo 'There are no comments.';
		} else {
			foreach ($comments as $v)
				echo $this->createCommentsPod($v, $question_id);
		}
		
		$event_type = $this->CI->event_model->get_event_type($question_id);
		//echo '<p>' . anchor("/comment/addComment/$question_name/$event_type",'Add a comment') . '</p>';
	}
	
	public function createCommentsPod($info, $question_id)
	{
		$votes = ($info['votes'] == null) ? 0 : $info['votes'] ;
		
		echo '<p>' . 
		"$votes votes " . 
		anchor("/comment/voteUp/{$info['comment_id']}/$question_id", '[+] ') . 
		anchor("/comment/voteDown/{$info['comment_id']}/$question_id", '[-] ') . 
		"<strong>Posted by:</strong> {$info['user_name']} <strong>Comment:</strong> {$info['comment']}</p>";
	}
}