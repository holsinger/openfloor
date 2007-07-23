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
		$data['cms_id'] = 0;
		
		$data['cms_id'] = $this->cms->get_id_from_url('home');
		$data = $this->cms->get_cms($data['cms_id']);	
		
		if (count($data)>1) $this->load->view('view_message',$data);
		else $this->failSafe();
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
}
?>