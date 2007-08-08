<?php

class Information extends Controller {

	function __construct()
	{
		parent::Controller();
		$this->load->model('Cms_model','cms');
		$this->load->library('validation');
		$this->load->helper('url');//for redirect
		$this->load->helper('form');

		$this->load->scaffolding('cms');
	}
	
	
	function index()
	{		
		/*$data['cms_id'] = 0;
		
		$data['cms_id'] = $this->cms->get_id_from_url('home');
		$data = $this->cms->get_cms($data['cms_id']);	
		
		if (count($data)>1) $this->load->view('view_message',$data);
		else $this->failSafe();*/
		$this->failSafe();
	}
	
	function failSafe()
	{
		$this->load->view('welcome_message');
	}
	
	function view ()
	{
		$data['cms_id'] = 0;
		if ( is_string($this->uri->segment(3)) ) {
			$data['cms_id'] = $this->cms->get_id_from_url($this->uri->segment(3));
			if ($data['cms_id']>0) $data = $this->cms->get_cms($data['cms_id']);	
		}
		
		if (count($data)>1) $this->load->view('view_message',$data);
		else if ($this->userauth->isAdmin()) 
		{
			redirect('admin/cms/'.$this->uri->segment(3));
			ob_clean();
			exit();
		}
		else $this->failSafe();
	}
	
	/**
	 * this function is used to return ajax data
	 */
	function viewAjax ()
	{
		$data['cms_id'] = 0;
		if ( is_string($this->uri->segment(3)) ) {
			$data['cms_id'] = $this->cms->get_id_from_url($this->uri->segment(3));
			if ($data['cms_id']>0) $data = $this->cms->get_cms($data['cms_id']);	
		}
		
		if (count($data)>1) $output = $data['cms_text'];
		else $output = 'no page found!';
		
		if ($this->userauth->isAdmin()) $output .= "<div>".anchor('admin/cms/'.$data['cms_url'], 'edit')."</div>";
		
		echo $output;
		
		return $output;
		
		exit();
	}
	
	function videoFeed ($event) {
		$this->load->model('Event_model','event');
		$event_id = $this->event->get_id_from_url($event);
		$array = $this->event->get_event($event_id);
		$array['date'] = date('m/d/Y g:i A', strtotime($array['event_date']));	
		
		//check ip
		$array['ip'] = $this->_getIP();
		if ($array['ip'] == '166.70.140.70') $array['blocked'] = true;
		else $array['blocked'] = false;
		$this->load->view('view_cn_feed',$array);
	}
	
	private function _getIP() { 
		$ip; 
	
		if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP"); 
		else if(getenv("HTTP_X_FORWARDED_FOR")) $ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if(getenv("REMOTE_ADDR")) $ip = getenv("REMOTE_ADDR"); 
		else $ip = "UNKNOWN"; 
	
		return $ip; 
	} 
}
?>