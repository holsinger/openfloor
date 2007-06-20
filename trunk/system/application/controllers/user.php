<?php
class User extends Controller {

	function __construct()
	{
		parent::Controller();
		$this->load->helper('url');
		
		$this->load->model('User_model','user');
		
		$this->load->scaffolding('cn_users');
	}
	
	
	function index()
	{
		//default show create account form
		$this->createAccount();
	
	}
	
	function login () {
		if (!isset($_POST['user_name']) || !isset($_POST['user_password'])) {
			$data['error'] = '';
			$this->load->view('view_login',$data);
		} else if ( $this->user->check_user_login() ) {//check if user login is correct
			//set user session
			$data['user_name'] = $this->user->user_name;
			$data['user_avatar'] = $this->user->user_avatar;
			$data['user_display_name'] = $this->user->user_display_name;
			$data['logged_in'] = "asdjfhlak#adsfLKJHJ";
			
			$this->session->set_userdata($data);
			
			//redirect somewhere
			redirect('user/profile/'.$this->session->userdata('user_name'));
			ob_clean();
			exit();
		} else {
			$data['error'] = 'Login Error';
			$this->load->view('view_login',$data);
		}
	}
	
	function logout() {
		//destroy session
		$this->session->sess_destroy();
		//redirect somewhere
		redirect('user/login');
		ob_clean();
		exit();
	}
	function createAccount ($error='') {
		$data['error'] = $error;
		$this->load->view('view_create_account',$data);
	}
	
	function create () {
		$last_id = $this->user->insert_user_form();
		//make sure a new id was inserted
		if ( is_numeric($last_id) ) {
			//forward to a user page
			redirect('user/profile/'.$_POST['user_name']);
			ob_clean();
			exit();
		} else {
			$this->createAccount();
		}
	}
	
	function loginOpenID () {		
		$this->load->library('SimpleOpenId');
		$this->simpleopenid->SetIdentity($_POST['openid_url']);
		$this->simpleopenid->SetTrustRoot($this->config->site_url() );
		$this->simpleopenid->SetRequiredFields(array('email','fullname'));
		$this->simpleopenid->SetOptionalFields(array('dob','gender','postcode','country','language','timezone'));
		if ($this->simpleopenid->GetOpenIDServer()){
			$this->simpleopenid->SetApprovedURL($this->config->site_url() . "/user/loginOpenID/");  	// Send Response from OpenID server to this script
			$this->simpleopenid->Redirect(); 	// This will redirect user to OpenID Server
		}else{
			$error = $this->simpleopenid->GetError();
			echo "ERROR CODE: " . $error['code'] . "<br>";
			echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
		}
	}
	
	function profile () {
		$user_name = $this->uri->segment(3);
		echo "user: {$user_name}";
		
	}
}
?>