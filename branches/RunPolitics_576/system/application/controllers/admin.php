<?php

class Admin extends Controller {
	
	function __construct()
	{
		parent::Controller();
		$this->load->model('Cms_model','cms');
		$this->load->library('validation');
		$this->load->helper('url');//for redirect
		$this->load->helper('form');

		$this->load->scaffolding('cms');
		$this->userauth->check(SL_ADMIN);

	}
	
	
	function index()
	{
		$this->cms();
	}
	
	function cms ()
	{
		$data['cms_id'] = 0;
		if ( is_string($this->uri->segment(3)) ) {
			$data['cms_id'] = $this->cms->get_id_from_url($this->uri->segment(3));
			//$data['cms_name'] = $this->uri->segment(3);
		}
		$rules['cms_name'] = "trim|xss_clean";
		$rules['cms_text'] = "trim";		
		$this->validation->set_rules($rules);
		
		if ($this->validation->run() == FALSE) {
			$data['error'] = $this->validation->error_string;
		} else {
			if ($_POST['cms_id']) 
			{				
				$this->cms->update_cms($_POST);
				redirect('admin/view/');
				ob_clean();
				exit();
			} 
			else 
			{
				$this->cms->insert_cms_form();
				redirect('admin/view/');
				ob_clean();
				exit();
			}
		}
				
		//this makes the info sticky 
		$fields['cms_name']	= ( isset($_POST['cms_name']) ) ? $_POST['cms_name']:"";
		$fields['cms_text']	= ( isset($_POST['cms_text']) ) ? $_POST['cms_text']:"";
		
		//get update info
		if ($data['cms_id']>0) $data = $this->cms->get_cms($data['cms_id']);	

		$this->validation->set_fields($fields);
		$this->load->view('view_cms_form',$data);		
	}
	
	function view () {
		$data['results'] = $this->cms->get_all_cms();
		$this->load->view('view_cms',$data);			
	}
	
}
?>