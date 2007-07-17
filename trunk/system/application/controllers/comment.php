<?php

class Comment extends Controller
{
	public function __constructor()
	{
		parent::Controller();
		$this->load->model('comments_model', 'vote');
	}
	
	public function addComment($question_id)
	{
		// quick & dirty error checking, revise
		if(!is_numeric($this->session->userdata('user_id')))
		{
			echo 'not logged in';
			exit();
		}
		
		$data['question_id'] = $question_id;
		// echo "QuestionID: $question_id UserID: $user_id";
		
		$this->load->view('view_add_comment', $data);
	}
	
	public function addCommentAction()
	{
		$_POST['fk_user_id'] = $this->session->userdata('user_id');
		if($this->comments_model->insertComment())
			redirect("/question/queue/event/question_event/question/{$_POST['fk_question_id']}");
	}
	
	public function voteUp($comment_id, $question_id)
	{
		$user_id = $this->session->userdata('user_id');
				
		$this->load->model('comments_model');
		if(!$this->comments_model->alreadyVoted($comment_id, $user_id))
			$this->comments_model->voteUp($user_id, $comment_id);
			
		redirect("/question/queue/event/question_event/question/$question_id");	
	}
	
	public function voteDown($comment_id, $question_id)
	{		
		$user_id = $this->session->userdata('user_id');
				
		$this->load->model('comments_model');
		if(!$this->comments_model->alreadyVoted($comment_id, $user_id))
			$this->comments_model->voteDown($user_id, $comment_id);
			
		redirect("/question/queue/event/question_event/question/$question_id");
	}
}

?>