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
	}
	
	public function createComments($results)
	{
		$question_id = $results[0]['question_id'];
		$this->question_name = url_title($results[0]['question_name']);
		$this->event_name = url_title($results[0]['event_name']);
		
		if (!$comments = $this->CI->comments_model->getCommentsByQuestion($question_id)) {
			return 'There are no comments.';
		} else {
			foreach ($comments as $v)
				return $this->createCommentsPod($v, $question_id);
		}
	}
	
	public function createCommentsPod($info, $question_id)
	{
		$votes = ($info['votes'] == null) ? 0 : $info['votes'] ;
		
		return '<p>' . 
		"$votes votes " . 
		anchor("/comment/voteUp/{$info['comment_id']}/$this->question_name/$this->event_name", '[+] ') . 
		anchor("/comment/voteDown/{$info['comment_id']}/$this->question_name/$this->event_name", '[-] ') . 
		"<strong>Posted by:</strong> {$info['user_name']} <strong>Comment:</strong> {$info['comment']}</p>";
	}
}