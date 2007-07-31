<?php

class Comment extends Controller
{
	public function __constructor()
	{
		parent::Controller();
		// $this->load->model('vote_model', 'vote');
		// $this->load->model('question_model');
	}
	
	public function addCommentAction()
	{
		$event_name = $_POST['event_name'];
		unset($_POST['event_name']);
		
		$question_name = $_POST['question_name'];
		unset($_POST['question_name']);
		
		$this->load->model('comments_model');
		$_POST['fk_user_id'] = $this->session->userdata('user_id');
		if($this->comments_model->insertComment())
			redirect('/question/view/' . url_title($event_name) . '/' . url_title($question_name));
	}
	
	public function voteUp($comment_id, $question_name, $event_name)
	{
		$this->userauth->check();
		$user_id = $this->session->userdata('user_id');
				
		$this->load->model('vote_model');
		$this->load->model('question_model');
		
		$question_info = $this->question_model->get_question('', $question_name);		
		$question_id = $question_info['question_id']; 
		$this->vote_model->type = 'comment';
		if(!$this->vote_model->alreadyVoted($comment_id, $user_id))
			$this->vote_model->voteUp($user_id, $comment_id);
			
		redirect('/question/view/' . url_title($event_name) . '/' . url_title($question_name));	
	}
	
	public function voteDown($comment_id, $question_name, $event_name)
	{		
		$this->userauth->check();
		$user_id = $this->session->userdata('user_id');
				
		$this->load->model('vote_model');
		$this->load->model('question_model');
		
		$question_info = $this->question_model->get_question('', $question_name);		
		$question_id = $question_info['question_id']; 
		$this->vote_model->type = 'comment';
		if(!$this->vote_model->alreadyVoted($comment_id, $user_id))
			$this->vote_model->voteDown($user_id, $comment_id);
			
		redirect('/question/view/' . url_title($event_name) . '/' . url_title($question_name));
	}
}

?>