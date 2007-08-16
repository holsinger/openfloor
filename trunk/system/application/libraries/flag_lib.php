<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flag_lib {

	public function __construct()
	{	
		$this->CI=& get_instance();
	}
	
	public function createQuestionFlagHTML($question_id)
	{
		$this->CI->flag->type = 'question';
		if($this->CI->flag->alreadyFlagged($question_id, $this->CI->session->userdata('user_id')))
			return "<div id=\"flag$question_id\" style=\"display:none;\">This question has been flagged</div>";
		$link = '';
		foreach ($this->CI->flag->getFlagTypes() as $type)			
			$link .= "<p><a href=\"javascript:queueUpdater.flagQuestion($question_id, {$type->type_id}, {$this->CI->session->userdata('user_id')});\">{$type->type}</a></p>";
		return "<div id=\"flag$question_id\" style=\"display:none;\">$link</div>";
	}
}