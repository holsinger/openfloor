<?php

class Flag extends Controller {
	
	function __construct()
	{
		parent::Controller();
		$this->load->model('flag_model', 'flag');
	}
	
	public function flagQuestion($question_id, $type_id, $reporter_id)
	{
		$this->flag->type = 'question';
		if(!$this->flag->alreadyFlagged($question_id, $reporter_id))
			$this->flag->flag($question_id, $type_id, $reporter_id);
	}
	
	public function flagUser($user_id, $type_id, $reporter_id)
	{
		$this->flag->type = 'user';
		if(!$this->flag->alreadyFlagged($user_id, $reporter_id))
			$this->flag->flag($user_id, $type_id, $reporter_id);
	}
}
?>