<?php

class Comment extends Controller
{
	public function __constructor()
	{
		parent::Controller();
		// $this->load->model('vote_model', 'vote');
		// $this->load->model('question_model');
	}
	
	// public function addComment($question_name, $event_type)
	// 	{
	// 		// quick & dirty error checking, revise
	// 		$this->userauth->check();
	// 		$this->load->model('question_model');
	// 		
	// 		$question_info = $this->question_model->get_question('', $question_name);
	// 		
	// 		$data['question_id'] = $question_info['question_id'];
	// 		$data['event_type'] = $event_type;
	// 		$data['question_name'] = $question_name;
	// 		// echo "QuestionID: $question_id UserID: $user_id";
	// 		
	// 		$this->load->view('view_add_comment', $data);
	// 	}
	
	public function addCommentAction()
	{
		$event_name = $_POST['event_name'];
		unset($_POST['event_name']);
		
		$question_name = $_POST['question_name'];
		unset($_POST['question_name']);
		
		$this->load->model('comments_model');
		$_POST['fk_user_id'] = $this->session->userdata('user_id');
		if($this->comments_model->insertComment())
			redirect("/question/queue/event/$event_name/question/$question_name");
	}
	
	public function voteUp($comment_id, $question_name)
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
			
		redirect("/question/queue/event/question_event/question/$question_id");	
	}
	
	public function voteDown($comment_id, $question_name)
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
			
		redirect("/question/queue/event/question_event/question/$question_id");
	}
}

?>