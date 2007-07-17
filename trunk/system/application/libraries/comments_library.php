<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_library
{
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('comments_model');
	}
	
	public function createComments($vars)
	{
		$question_id = $vars['results'][0]['question_id'];
		
		if (!$comments = $this->CI->comments_model->getCommentsByQuestion($question_id)) {
			echo 'There are no comments.';
		} else {
			foreach ($comments as $v)
				echo $this->createCommentsPod($v, $question_id);
		}
		
		if ($this->CI->userauth->isUser())
			echo '<p>' . anchor("/comment/addComment/$question_id",'Add a comment') . '</p>';
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