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
			$this->flag->flagQuestion($question_id, $type_id, $reporter_id);
	}
}
?>