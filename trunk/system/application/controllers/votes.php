<?php

class Votes extends Controller
{
	function __construct()
	{
		parent::Controller();
		$this->load->model('question_model');
		$this->load->model('vote_model');
	}
	
	public function who($question_id)
	{
		// retrieve question information
		$this->question_model->question_id = $question_id;
		$results = $this->question_model->questionQueue();
		$data['question_record'] = $results[0];
		
		// retrieve votes information
		$data['votes'] = $this->vote_model->getVotesByQuestion($question_id);
		
		$this->load->view('view_question_votes', $data);
	}
}

?>