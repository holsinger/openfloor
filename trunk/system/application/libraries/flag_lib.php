<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flag_lib {
	public $type;

	public function __construct()
	{	
		$this->CI=& get_instance();
	}
	
	public function createFlagHTML($fk_id)
	{
		if(!in_array($this->type, array('question', 'user'))) show_error('Flag_lib::type: invalid type');
		
		$this->CI->flag->type = $this->type;
		if($this->CI->flag->alreadyFlagged($fk_id, $this->CI->session->userdata('user_id')))
			return "<div id=\"flag_{$this->type}$fk_id\" style=\"display:none;\">This {$this->type} has been flagged</div>";
		$link = '';
		foreach ($this->CI->flag->getFlagTypes() as $type)			
			$link .= "<p><a href=\"javascript:queueUpdater.flag{$this->type}($fk_id, {$type->type_id}, {$this->CI->session->userdata('user_id')});\">{$type->type}</a></p>";
		return "<div id=\"flag_{$this->type}$fk_id\" style=\"display:none;\">$link</div>";
	}
}