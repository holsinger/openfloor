<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flag_lib {
	public $type;

	public function __construct()
	{	
		$this->CI=& get_instance();
	}
	
	public function createFlagHTML($fk_id, $event_name = '')
	{
		$event_name = url_title($event_name);
		if(!in_array($this->type, array('question', 'user'))) show_error('Flag_lib::type: invalid type');
		
		$this->CI->flag->type = $this->type;
		if(!$this->CI->userauth->isUser()) {
			$link = anchor("/user/loginToDo/conventionnext/queue/event/$event_name", 'Log in to flag items.');
		} elseif($this->CI->flag->alreadyFlagged($fk_id, $this->CI->session->userdata('user_id')))
			$link = 'You have already flagged this.';
		else {	
			$link = '';
			foreach ($this->CI->flag->getFlagTypes() as $type)			
				$link .= "<a class=\"flag-option\" href=\"javascript:queueUpdater.flag{$this->type}($fk_id, {$type->type_id}, {$this->CI->session->userdata('user_id')});\">{$type->type}</a>";
		}
		return "<div id=\"flag_{$this->type}$fk_id\" class=\"flag-$this->type\" style=\"display:none;\"><div class=\"close_flag_window\" onClick=\"javascript:$('flag_{$this->type}$fk_id').setStyle({display:'none'});\"></div>$link</div>";
	}
}