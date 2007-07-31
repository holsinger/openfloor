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
		$event_type = $_POST['event_type'];
		unset($_POST['event_type']);
		
		$event_name = $_POST['event_name'];
		unset($_POST['event_name']);
		
		$name = $_POST['name'];
		unset($_POST['name']);
		
		$this->load->model('comments_model');
		$_POST['fk_user_id'] = $this->session->userdata('user_id');
		if($this->comments_model->insertComment()) {
			if($event_type == 'question')
				redirect('/question/view/' . url_title($event_name) . '/' . url_title($name));
			else
				redirect('/video/view/' . url_title($event_name) . '/' . url_title($name));
		}
	}
	
	public function voteUp($comment_id, $name, $event_name, $type)
	{
		$this->userauth->check();
		$user_id = $this->session->userdata('user_id');
				
		$this->load->model('vote_model');
		if($type  == 'question') {
			$this->load->model('question_model', 'model');
		
			$question_info = $this->question_model->get_question('', $question_name);		
			$question_id = $question_info['question_id']; 
			$this->vote_model->type = 'comment';
			if(!$this->vote_model->alreadyVoted($comment_id, $user_id))
				$this->vote_model->voteUp($user_id, $comment_id);
			
			redirect('/question/view/' . url_title($event_name) . '/' . url_title($question_name));
		} else {
			$this->load->model('video_model', 'model');
		
			$video_info = $this->model->get_video('', $name);		
			$video_id = $video_info['video_id']; 
			$this->vote_model->type = 'comment';
			if(!$this->vote_model->alreadyVoted($comment_id, $user_id))
				$this->vote_model->voteUp($user_id, $comment_id);
			
			redirect('/video/view/' . url_title($event_name) . '/' . url_title($name));
		}
	}
	
	public function voteDown($comment_id, $name, $event_name, $type)
	{
		$this->userauth->check();
		$user_id = $this->session->userdata('user_id');
				
		$this->load->model('vote_model');
		if($type == 'question') {
			$this->load->model('question_model', 'model');
		
			$question_info = $this->question_model->get_question('', $question_name);		
			$question_id = $question_info['question_id']; 
			$this->vote_model->type = 'comment';
			if(!$this->vote_model->alreadyVoted($comment_id, $user_id))
				$this->vote_model->voteDown($user_id, $comment_id);
			
			redirect('/question/view/' . url_title($event_name) . '/' . url_title($question_name));
		} else {
			$this->load->model('video_model', 'model');
		
			$video_info = $this->model->get_video('', $name);		
			$video_id = $video_info['video_id']; 
			$this->vote_model->type = 'comment';
			if(!$this->vote_model->alreadyVoted($comment_id, $user_id))
				$this->vote_model->voteDown($user_id, $comment_id);
			
			redirect('/video/view/' . url_title($event_name) . '/' . url_title($name));
		}
	}
}

?>