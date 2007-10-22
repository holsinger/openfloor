<?php
class Contact extends Controller 
{
	function __construct()
	{
		parent::Controller();
		$this->load->model('Cms_model','cms_model');
		$this->load->library('validation');
		$this->load->library('time_lib');
		$this->load->helper('url');//for redirect
		$this->load->helper('form');
	}
	
	function index () {
		$this->showForm();
	}
	function showForm($contact_type){
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),"Contact Us"=>$this->config->site_url()."contact/showForm/contact_us");
		$data['contact_type'] = $contact_type;
		if($contact_type == 'contact_us'){
			$data['contact_page_name'] = "Contact Us";
		}elseif($contact_type == 'request_an_event'){
			$data['contact_page_name'] = "Request An Event";
		}
		$cms_data = $this->cms_model->get_cms(0, $contact_type);
		$data['contact_page_desc'] = $cms_data['cms_text'];
		
		$this->load->view('contact/contact_us', $data);
	}
	
	function send(){
		// Variable Stuff
		$data['contact_type'] = $_POST['contact_type'];
		if($_POST['contact_type'] == 'contact_us'){
			$data['thank_you_desc'] = 'Your feedback has been received.  Thanks for helping make Run Politics better.';
			$type_title = "Contact Us";
		}elseif($_POST['contact_type'] == 'request_an_event'){
			$data['thank_you_desc'] = 'Thanks for your request.  Our staff will look over your request and contact you if necessary.';
			$type_title = "Request An Event";
		}
		if($this->userauth->isUser()){
			$sender_name = $this->userauth->user_name;
			$sender_email = $this->userauth->user_email;
		}else{
			$sender_name = "Anonymous";
			$sender_email = "";
		}
		$cms_data = $this->cms_model->get_cms(0, $_POST['contact_type']);
		echo("Important Info: ".$sender_name.",".$sender_email.",".$cms_data['custom_1']);
		// Setup and send email
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from($sender_name, $sender_email);
		$this->email->to($cms_data['custom_1']);

		$this->email->subject('Run Politics - '.$type_title.' Feedback');
		$this->email->message('<b>The following feedback was provided through the "'.$type_title.'" feature of runpolitics.com:</b><br /><br />'.$_POST['feedback']);

		$this->email->send();
		
		// Load View Thanking Person
		$this->load->view('contact/thank_you', $data);
	}
}
?>