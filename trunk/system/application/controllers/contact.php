<?php
class Contact extends Controller 
{
	function __construct()
	{
		parent::Controller();
		$this->load->library('tag_lib');
		$this->load->model('tag_model', 'tag');
		$this->load->model('Cms_model','cms_model');
		$this->load->library('validation');
		$this->load->library('time_lib');
		$this->load->library('wordcloud');
		$this->load->model('Cms_model','cms');
		$this->load->helper('url');//for redirect
		$this->load->helper('form');
	}
	
	function index () {
		$this->showForm();
	}
	function showForm($contact_type){
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),"Contact Us"=> "");
		$data['contact_type'] = $contact_type;
		$data['contact_page_name'] = ucwords(str_replace("_", " ", $contact_type));

		$cms_data = $this->cms_model->get_cms(0, $contact_type);
		$data['contact_page_desc'] = $cms_data['cms_text'];
				
		// user info, if posted use it for validation purposes
		if($_POST){
			$data['sender_name'] = $_POST['sender_name'];
			$data['sender_email'] = $_POST['sender_email'];
			$data['feedback'] = $_POST['feedback'];
		}else{
			if($this->userauth->isUser()){
				$data['sender_name'] = $this->userauth->user_name;
				$data['sender_email'] = $this->userauth->user_email;
			}else{
				$data['sender_name'] = "";
				$data['sender_email'] = "";
			}
		}

		
		// Validation stuff
		$this->load->library('validation');
		$rules['sender_name'] = "required";
		$rules['feedback'] = "required";
		$rules['sender_email'] = "required|valid_email";
		$this->validation->set_rules($rules);
		$this->validation->set_error_delimiters('<div class="errorArea">', '</div>');
		
		if ($this->validation->run() == FALSE){
			$this->load->view('contact/contact_us', $data);
		}else{
			$this->send($data);
		}
		
		
	}
	
	private function send($data){
		// Variable Stuff
		$data['contact_type'] = $_POST['contact_type'];
		$type_title = ucwords(str_replace("_", " ", $data['contact_type']));
		
		if($data['contact_type'] == 'contact_us'){
			$data['thank_you_desc'] = 'Your feedback has been received.  Thanks for helping make Run Politics better.';
		}elseif($data['contact_type'] == 'request_an_event'){
			$data['thank_you_desc'] = 'Thanks for your request.  Our staff will look over your request and contact you if necessary.';
		}elseif($data['contact_type'] == 'feedback'){
			$data['thank_you_desc'] = 'Thanks for your feedback.  Our staff will look over your request and contact you if necessary.';
		}

		$cms_data = $this->cms_model->get_cms(0, $data['contact_type']);
		//echo("Important Info: ".$data['sender_name'].",".$data['sender_email'].",".$cms_data['custom_1']);
		
		// Setup and send email
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from(str_replace(" ","_",$data['sender_name']), $data['sender_email']);
		$this->email->to($cms_data['custom_1']);

		$this->email->subject('Run Politics - '.$type_title.' Feedback');
		$this->email->message('
		<b>Sender</b>: '.$data['sender_name'].'<br />
		<b>Email</b>: '.$data['sender_email'].'<br /><br />
		<b>The following feedback was provided through the "'.$type_title.'" feature of runpolitics.com:</b><br />
		'.$data['feedback']);

		$this->email->send();
		
		// Load View Thanking Person
		$this->load->view('contact/thank_you', $data);
	}
}
?>