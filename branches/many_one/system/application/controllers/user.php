<?php
/**
 * User Controller.  Used by pages that concern themselves with user management and more.
 *
 * @package default
 * @author Clark Endrizzi, James, and Rob
 **/

class User extends Controller {
	var $error = '';
	
	function __construct()
	{
		parent::Controller();
		$this->load->helper('url');
		$this->load->library('tag_lib');
		$this->load->model('tag_model', 'tag');
		$this->load->library('wordcloud');
		
		$this->load->model('User_model','user');
		$this->load->model('Cms_model','cms');
		$this->load->model('vote_model','vote');
		$this->load->model('question_model', 'question');
		
		$this->load->library('validation');
		
		$this->load->scaffolding('cn_users');
		
		$this->CI=& get_instance();
	}
	
	/**
	 * Default action, shows the users
	 *
	 * @return void
	 * @author ???
	 **/
	function index()
	{
		//default show create account form
		$this->view_users();
	}
	
	/**
	 * Works like login, but is coming from a user doing the action and allows the user to resume what they were trying to do
	 *
	 * @return void
	 * @author ????
	 **/
	function loginToDo () {
		$func_args = func_get_args();
		$data['location'] = implode('/', $func_args);
		$data['error'] = 'Please login to do that.';
		$this->load->view('view_login',$data);
	}
	
	/**
	 * Basic login form
	 *
	 * @return void
	 * @author ???
	 **/
	function login () {
		$rules['user_name'] = "trim|required|min_length[3]|max_length[75]|xss_clean";
		$rules['user_password'] = "trim|required|md5|xss_clean";
		$this->validation->set_rules($rules);
		
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Login'=>'');					
		if ($this->validation->run() == FALSE) {
			$data['error'] = $this->validation->error_string;
			$fields['user_name']	= ( isset($_POST['user_name']) ) ? $_POST['user_name']:"";	
			$this->validation->set_fields($fields);
			$this->load->view('view_login',$data);
		} else if ( $this->user->check_user_login() ) {//check if user login is correct
			//set user session
			$this->user->login_user($this->user->user_name,$this->user->user_id);			
			
			//redirect somewhere
			if (isset($_POST['redirect'])) redirect($_POST['redirect']); 
			else redirect('user/profile/'.$this->session->userdata['user_name']);
			ob_clean();
			exit();
		} else {
			$data['error'] = 'We couldn\'t log you in, the username or password may be incorrect, or you may still need to activate your account.';
			$this->load->view('view_login',$data);
		}
	}
	
	/**
	 * Basic logout functionality (removes the session variables)
	 *
	 * @return void
	 * @author ????
	 **/
	function logout() {
		//destroy session
		$this->session->sess_destroy();
		//redirect somewhere
		redirect('user/login');
		ob_clean();
		exit();
	}
	
	function createAccount ($error='') {
		$data['error'] = str_replace('_',' ',$error);
	
		//add image to data
		$data['capimage'] = $this->createCaptcha();
		
		//set field values
		$fields['user_name']	= ( isset($_POST['user_name']) ) ? $_POST['user_name']:"";
		$fields['user_email']	= ( isset($_POST['user_email']) ) ? $_POST['user_email']:"";	
		$this->validation->set_fields($fields);
		
		$this->load->view('view_create_account',$data);
	}
	
	function createAccountOI ($error='') {
		$data['error'] = str_replace('_',' ',$error);
	
		//add image to data
		$data['capimage'] = $this->createCaptcha();
		
		//set field values
		$fields['user_name']	= ( isset($_POST['user_name']) ) ? $_POST['user_name']:"";
		$fields['user_email']	= ( isset($_POST['user_email']) ) ? $_POST['user_email']:"";	
		$this->validation->set_fields($fields);
		
		$this->load->view('view_create_account_oi',$data);
	}
	
	function create () {
		$error = false;
		$custom_error = '';
		
		$rules['user_name'] = "trim|required|min_length[5]|max_length[45]|xss_clean";
		//open require if no open id
		if (!isset($_POST['user_openid'])) $rules['user_password'] = "trim|required|matches[password_confirm]|md5|xss_clean";
		if (!isset($_POST['user_openid'])) $rules['password_confirm'] = "trim|required|xss_clean";
		$rules['user_email'] = "trim|required|valid_email|xss_clean";
		$rules['captcha'] = "callback_check_captcha";
		
		$this->validation->set_rules($rules);
					
		if ($this->validation->run() == FALSE) $error = $this->validation->error_string;
		
		if ($this->user->userExists(array('user_name' => $_POST['user_name'])))
			$custom_error .= '<p>User name already taken<p>';
		if ($this->user->userExists(array('user_email' => $_POST['user_email'])))
			$custom_error .= '<p>Email address already taken</p>';
		if($custom_error && $error)
			$error .= $custom_error;
		elseif($custom_error)
			$error = $custom_error;
		
		if ( !$error ) {
			$last_id = $this->user->insert_user_form();
			//make sure a new id was inserted
			if ( is_numeric($last_id) ) {
				//set sessions
				// $this->user->login_user($this->user->user_name,$this->user->user_id);
				
				//send mail
				$this->load->library('email');
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'iso-8859-1';
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;				
				$this->email->initialize($config);
				$this->email->from('contact@runpolitics.com', 'RunPolitics.com Registration');
				$this->email->to($_POST['user_email']);
				#vars
				$this->user->user_id = $last_id;
				$timestamp = $this->user->get('timestamp');
				$url = site_url('user/activate/' . $_POST['user_password'] . '/' . base64_encode($timestamp));
				$message = 'Activate your account by following this link: ' . $url;
				$subject = 'Account Activation';
				#set subject
				$this->email->subject($subject);
				#set message
				$this->email->message($message);
				// $this->email->set_alt_message(strip_tags($message));
				#send
				// exit('<pre>' . print_r($this->email, true) . '</pre>');
				$this->email->send();
				// log_message('debug', "emailReg:".trim($this->email->print_debugger()));			
				// exit('<pre>' . print_r(trim($this->email->print_debugger()), true) . '</pre>');	
			
				//forward to a user page
				redirect('user/complete');
				// redirect('user/profile/'.$_POST['user_name']);
				ob_clean();
				exit();
			} else {
				$error = 'Error Creating Account';
			}
		} //if no error
				
		//send back the error
		$this->createAccount($error);
	}
	
	public function complete()
	{
		$this->load->view('user/activation_email_sent');
	}
	
	/**
	 * Activates the users account
	 *
	 * @return void
	 * @author Rob Stef, Clark Endrizzi (Modified, commented)
	 **/
	public function activate($password, $timestamp)
	{
		$result = $this->user->activate($password, $timestamp);
		if($result == 1){
			$user_data = $this->user->get_user_custom("timestamp", base64_decode($timestamp) );
			$this->user->login_user($user_data['user_name'], $user_data['user_id']);
			redirect("/event", 'location');
		}else{
			$data['error'] = 'A system error has occurred, your account could not be activated';
			$this->load->view('view_login', $data);
		}		
		
	}

	/**
	 * This is where the link goes that a user is sent by email.  
	 *
	 * Before this user can actually become a fully registered user, they need to set a password and user_name, which is done here.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function invite_accept($user_id, $timestamp){
		// by default we show the form for step one, unless, it's a post and validation works out
		$show_form = true;
		
		if(isset($_POST['user_name'])){
			// Setup the data to show on the form (used if validation is false)
			$data = $_POST;
			// Set validation rules
			$rules['user_name'] 	= "callback_validation_username_duplication_check";
			$rules['password_1']	= "required|callback_validation_password_check";
			$this->validation->set_rules($rules);
			// Set the name of the fields for validation errors (if any)
			$fields['user_name']	= 	"User Name";
			$fields['password_1']	= 	"Password";
			$this->validation->set_fields($fields);
			// Check validation
			if($this->validation->run()){
				$show_form = false;
			}
		}
		// If initial or validation fails, show form
		if ($show_form){
			// Page Setup Stuff
			$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(), "Setup Account"  => "");
			$data['user_id'] = $user_id;
			$data['timestamp'] = $timestamp;
			// Get 
			$this->load->view('user/finish_invite',$data);
		}else{
			// Database stuff
			if($_POST['password_1']){
				$_POST['user_password'] = MD5($_POST['password_1']);
				unset($_POST['password_1']);  unset($_POST['password_2']);
			}else{
				unset($_POST['password_1']);  unset($_POST['password_2']);
			}
			unset($_POST['user_id']);
			$_POST['user_security_level'] = '4';	// Must set this before account can be used.
			$this->user->UpdateUser($user_id, $_POST);
			
			$result = $this->user->complete_invite($user_id, $timestamp);
			if($result == 1){
				//$data['error'] = 'Your account is created.';
				$this->user->login_user($_POST['user_name'], $user_id);
				redirect("/event", 'location');
			}else{
				$data['error'] = 'A system error has occurred, your account could not be activated';
				$this->load->view('view_login', $data);
			}		
			
		}
		
	}

	function loginOpenID () {	
		$data['error'] = "OpenID Error";
		if (isset($_POST['openid_action']) && $_POST['openid_action'] == "login"){ // Get identity from user and redirect browser to OpenID Server
			$this->load->library('SimpleOpenID');
			$this->simpleopenid->SetIdentity($_POST['openid_url']);
			$this->simpleopenid->SetTrustRoot('http://'.$_SERVER['SERVER_NAME']);
			$this->simpleopenid->SetRequiredFields(array('email'));
			$this->simpleopenid->SetOptionalFields(array('fullname','dob','gender','postcode','country','language','timezone'));
			if ($this->simpleopenid->GetOpenIDServer()){
				//$this->simpleopenid->SetApprovedURL($this->config->site_url() . "/user/loginOpenID/");  	// Send Response from OpenID server to this script
				
				$this->simpleopenid->SetApprovedURL($this->config->site_url() . "?c=user&m=loginOpenID");  	// Send Response from OpenID server to this script
				$this->simpleopenid->Redirect(); 	// This will redirect user to OpenID Server
			}else{
				$error = $this->simpleopenid->GetError();
				$date['error'] = "OpenID ERROR CODE: " . $error['code'] . "<br>";
				$date['error'] .= "OpenID ERROR DESCRIPTION: " . $error['description'] . "<br>";
				$this->load->view('view_login',$data);
			}
		}//end if post login

		if(isset($_GET['openid_mode']) && $_GET['openid_mode'] == 'id_res'){ 	// Perform HTTP Request to OpenID server to validate key
			
			$this->load->library('SimpleOpenID');
			$this->simpleopenid->SetIdentity($_GET['openid_identity']);
			$openid_validation_result = $this->simpleopenid->ValidateWithServer();
			if ($openid_validation_result == true){ 		// OK HERE KEY IS VALID
				log_message('debug', 'VALID OpenID '.$_GET['openid_identity']);
				//foreach ($_GET as $key => $val) echo "$key => $val <br />";
				
				//get user data
				$data = $this->user->get_user(0,'','',$_GET['openid_identity']);
				//set error if there is one
				if (count($data) > 0) {
					$this->user->login_user($data['user_name'],$data['user_id']);
					redirect('user/profile/'.$this->session->userdata['user_name']);
					ob_clean();
					exit();						
				} else {
					$data['error'] = 'No user record found for: '.$_GET['openid_identity'];
					$data['error'] .= '<br />Have you registered your OpenID with Politic2.0  by '.anchor('user/createAccount','Creating an Account?');
					
					//$this->load->view('view_login',$data);
				}
				
				
			}else if($this->simpleopenid->IsError() == true){			// ON THE WAY, WE GOT SOME ERROR
				$error = $this->simpleopenid->GetError();
				$data['error'] = "OpenID ERROR CODE: " . $error['code'] . "<br>";
				$data['error'] .= "OpenID ERROR DESCRIPTION: " . $error['description'] . "<br>";
				//$this->load->view('view_login',$data);
			}else{											// Signature Verification Failed
				$data['error'] = "OpenID INVALID AUTHORIZATION";
				//$this->load->view('view_login',$data);
			}
		} else if (isset($_GET['openid_mode']) && $_GET['openid_mode'] == 'cancel'){ // User Canceled your Request
			$data['error'] = "OpenID USER CANCELED REQUEST";
			//$this->load->view('view_login',$data);
		}
		//$data['error'] = "OpenID Error";
		$this->load->view('view_login',$data);
	}
	
	//this function is used with openID and ceate account
	function createOpenID () {	
		$data['error'] = "OpenID Error";
		//add image to data
		$data['capimage'] = $this->createCaptcha();
		if (isset($_POST['openid_action']) && $_POST['openid_action'] == "create"){ // Get identity from user and redirect browser to OpenID Server
			$this->load->library('SimpleOpenID');
			$this->simpleopenid->SetIdentity($_POST['openid_url']);
			$this->simpleopenid->SetTrustRoot('http://'.$_SERVER['SERVER_NAME']);
			$this->simpleopenid->SetRequiredFields(array('email'));
			$this->simpleopenid->SetOptionalFields(array('fullname','dob','gender','postcode','country','language','timezone'));
			if ($this->simpleopenid->GetOpenIDServer()){
				//$this->simpleopenid->SetApprovedURL($this->config->site_url() . "/user/loginOpenID/");  	// Send Response from OpenID server to this script
				
				$this->simpleopenid->SetApprovedURL($this->config->site_url() . "?c=user&m=createOpenID");  	// Send Response from OpenID server to this script
				$this->simpleopenid->Redirect(); 	// This will redirect user to OpenID Server
			}else{
				$error = $this->simpleopenid->GetError();
				$date['error'] = "OpenID ERROR CODE: " . $error['code'] . "<br>";
				$date['error'] .= "OpenID ERROR DESCRIPTION: " . $error['description'] . "<br>";
				$this->load->view('view_login',$data);
			}
		}//end if post login

		if(isset($_GET['openid_mode']) && $_GET['openid_mode'] == 'id_res'){ 	// Perform HTTP Request to OpenID server to validate key
			
			$this->load->library('SimpleOpenID');
			$this->simpleopenid->SetIdentity($_GET['openid_identity']);
			$openid_validation_result = $this->simpleopenid->ValidateWithServer();
			if ($openid_validation_result == true){ 		// OK HERE KEY IS VALID
				log_message('debug', 'VALID OpenID '.$_GET['openid_identity']);
				//foreach ($_GET as $key => $val) echo "$key => $val <br />";
				
				//get user data
				$data['openID'] = $_GET['openid_identity'];
				$data['openID_email'] = $_GET['openid_sreg_email']; 
				$data['error'] = "";
				
			}else if($this->simpleopenid->IsError() == true){			// ON THE WAY, WE GOT SOME ERROR
				$error = $this->simpleopenid->GetError();
				$data['error'] = "OpenID ERROR CODE: " . $error['code'] . "<br>";
				$data['error'] .= "OpenID ERROR DESCRIPTION: " . $error['description'] . "<br>";
			}else{											// Signature Verification Failed
				$data['error'] = "OpenID INVALID AUTHORIZATION";
			}
		} else if (isset($_GET['openid_mode']) && $_GET['openid_mode'] == 'cancel'){ // User Canceled your Request
			$data['error'] = "OpenID USER CANCELED REQUEST";
		}
		//$data['error'] = "OpenID Error";
		$this->load->view('view_create_account',$data);
	}
	
	/**
	 * Shows the users profile
	 *
	 * Uses dynamic_tabs (js library).  THis in effect calls the profile ajax function below this to populate each section.
	 *
	 * @return void
	 * @author ????, Clark Endrizzi (Basically rewrote)
	 **/
	function profile () {
		//allow segment 3 to be an id or username
		/*
			TODO Get rid of this fugly stuff below to just accept id's (which may be the case, I think it was only for cand. with strings)
		*/
		$user_id = '';
		$user_name = '';
		if ( is_numeric($this->uri->segment(3)) ) $user_id = $this->uri->segment(3);
		if ( is_string($this->uri->segment(3)) ) $user_name = $this->uri->segment(3); 
		$data = $this->user->get_user($user_id,$user_name);
		
		//set error if there is one
		$data['error'] = (count($data) > 0)?$error:'No user record found for: '.$this->uri->segment(3);
		$data['owner'] = $this->user->is_logged_in($user_id,$user_name);

		if (is_string($data['user_avatar']) && is_array(unserialize($data['user_avatar'])) ){
			$image_array = unserialize($data['user_avatar']);
			
			$data['avatar_image_name'] = $image_array['file_name'];
			$data['avatar_image_height'] = $image_array['image_height'];
			$data['avatar_image_width'] = $image_array['image_width'];
			$data['avatar_image_path'] = "./avatars/".$image_array['file_name'];
		}else {				
			$data['avatar_image_path'] = './images/image01.jpg';
		}
		
		//admin is also an owner
		if ( $this->userauth->isAdmin() ) $data['owner'] = TRUE;
				
		$this->load->view('user/view_user_profile',$data);
	}
	
	/**
	 * Returns information about the user and their question history.  Used by the profile section (currently).
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function profile_ajax($user_id, $tab='1'){
		$data = $this->user->get_user($user_id);
		// Get permission level
		if($this->CI->session->userdata('user_id') == $user_id || $this->userauth->isAdmin()){
			$data['edit_permission'] = true;
		}
		// Do different things for each profile tab
		if($tab == 1){
			$this->load->view('user/ajax_profile_info',$data);
		}elseif($tab == 2){
			// users last 10 questions
			$data['questions'] =  $this->question->getQuestionsByUser($data['user_id']);
			foreach($data['questions'] as $k => $v) {
				$data['questions'][$k]['event_name'] = anchor('forums/cp/' . url_title($v['event_name']), substr($v['event_name'], 0, 20) . '...');
				$data['questions'][$k]['question_name'] = anchor('question/view/' . url_title($v['event_name']) . '/' . url_title($v['question_name']), substr($v['question_name'],0,50) . '...');
			}
			$this->load->view('user/ajax_profile_question',$data);
		}elseif($tab == 3){
			// users last 10 votes
			$data['votes'] = $this->vote->getVotesByUser($data['user_id']);
			foreach($data['votes'] as $k => $v) {
				$data['votes'][$k]['event_name'] = anchor('forums/cp/' . url_title($v['event_name']), substr($v['event_name'], 0, 20) . '...');
				$data['votes'][$k]['question_name'] = anchor('question/view/' . url_title($v['event_name']) . '/' . url_title($v['question_name']), substr($v['question_name'],0,50) . '...');
			}
			$this->load->view('user/ajax_profile_vote',$data);
		}
	}
	
	/**
	 * this function will check the captcha
	 **/
	function check_captcha ($str) {
	 	// First, delete old captchas
		$expiration = time()-7200; // Two hour limit
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);		
	
		// Then see if a captcha exists:
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($str, $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		if ($row->count == 0) {
			$this->validation->set_message('check_captcha', 'You must submit the characters that appears in the image');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	// ============
	// = User CMS =
	// ============
	
	/**
	 * View Users
	 */
	public function view_users()
	{
		#check that user is allowed
		//$this->userauth->check(SL_ADMIN);
		
		$this->load->helper('url');
		//$this->load->library('table');
		$this->db->orderby("user_name", "asc");
		$users = $this->db->get('cn_users')->result_array();
		foreach($users as $k=>$v) 
		{
			if ($this->userauth->isAdmin()) $users[$k]['edit'] = anchor("user/edit_user/{$v['user_id']}", 'Edit');

			if (is_string($users[$k]['user_avatar']) && is_array(unserialize($users[$k]['user_avatar'])) )
			{
				$image_array = unserialize($users[$k]['user_avatar']);
				
				$users[$k]['avatar_image_name'] = $image_array['file_name'];
				$users[$k]['avatar_image_height'] = $image_array['image_height'];
				$users[$k]['avatar_image_width'] = $image_array['image_width'];
				$users[$k]['avatar_image_path'] = "./avatars/".$image_array['file_name'];
			} 
			else
			{
				$users[$k]['avatar_image_name'] = '';
				$users[$k]['avatar_image_height'] = '';
				$users[$k]['avatar_image_width'] = '';
				$users[$k]['avatar_image_path'] = "./images/image01.jpg";
			}
		}
		$data['users'] = $users;	
		
		//$this->table->set_heading('id', 'name', 'password', 'avatar', 'display_name','email','OpenID','security level','edit');
    	
		$this->load->view('view_users',$data);
	}
	
	/**
	 * This is the controller used when editing a user
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function edit_user($user_id){
		#check that user is allowed, must be admin or the person
		if($this->CI->session->userdata('user_id') != $user_id){
			$this->userauth->check(SL_ADMIN);
		}	
		// by default we show the form for step one, unless, it's a post and validation works out
		$show_form = true;
		
		if(isset($_POST['user_name'])){
			// Setup the data to show on the form (used if validation is false)
			$data = $_POST;
			$data['user_id'] = $user_id;
			// Set validation rules
			$rules['display_name'] 	= "trim|required|xss_clean";
			$rules['user_name'] 	= "callback_validation_username_duplication_check";
			$rules['bio'] 			= "trim|xss_clean";
			$rules['password_1']	= "callback_validation_password_check";
			$rules['user_email']	= "callback_validation_email_duplication_check";
			$this->validation->set_rules($rules);
			// Set the name of the fields for validation errors (if any)
			$fields['display_name']	= 	"Display Name"; 
			$fields['user_name']	= 	"User Name";
			$fields['bio']			= 	"Biography";
			$fields['password_1']	= 	"Password Fields";
			$this->validation->set_fields($fields);
			// Check validation
			if($this->validation->run()){
				$show_form = false;
			}
		}else{
			$data = $this->user->get_user($user_id);
		}
		// If initial or validation fails, show form
		if ($show_form){
			// Page Setup Stuff
			$data['page_title'] = "Create ".$this->cms->get_cms_text('', "forums_navigation_title");
			$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(), "User Profile"=>$this->config->site_url().'user/profile/'.$data['user_name'], $data['page_title']  => "");
			// Get 
			$this->load->view('user/edit_user',$data);
		}else{
			// Upload file first
			if(!empty($_FILES['userfile']['name'])){
				$config['upload_path'] = './avatars/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= '1024';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';
				$config['overwrite']  = FALSE;
				$config['encrypt_name']  = TRUE;

				$this->load->library('upload', $config);

				if ( !$this->upload->do_upload()){
					show_error($this->upload->display_errors());
				}else{
					$data['upload_data'] = $this->upload->data();

					//resize image
					$config = array();
					$config['image_library'] = 'GD2';
					$config['source_image'] = './avatars/'.$data['upload_data']['file_name'];
					#$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 100;
					$config['height'] = 75;			
					$this->load->library('image_lib', $config);			
					$this->image_lib->resize();
					if ($this->image_lib->display_errors()) $error =  $this->image_lib->display_errors();
					$_POST['user_avatar'] = isset($data['upload_data']) ?  serialize($data['upload_data']) : '' ;
					//echo '<pre>'; print_r($_POST); echo '</pre>';	exit();	
				}
			}
			// Database stuff
			if($_POST['password_1']){
				$_POST['user_password'] = MD5($_POST['password_1']);
				unset($_POST['password_1']);  unset($_POST['password_2']);
			}else{
				unset($_POST['password_1']);  unset($_POST['password_2']);
			}
			unset($_POST['user_id']);
			$this->user->UpdateUser($user_id, $_POST);
			redirect('user/profile/'.$data['user_name'], 'location');
		}
	}
	
	/**
	 * A custom validation callback that is used to validate the password fields.  It only called for the first one but that is enough.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function validation_password_check($str){
		if ($_POST['password_1'] != $_POST['password_2']){
			$this->validation->set_message('validation_password_check', 'The password fields do not match.');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
	 * A custom validation callback that is used for the validation of the email field.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function validation_email_duplication_check($str){
		if(!$str){
			$this->validation->set_message('validation_email_duplication_check', 'The field "Email Address" requires a value.');
			return FALSE;
		}elseif ( $this->user->userExists(array('user_email' => $str, 'user_id != ' => $_POST['user_id'])) ){
			$this->validation->set_message('validation_email_duplication_check', 'The email address "'.$_POST['user_email'].'" is already in use.');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
	 * A custom validation callback that is used for the validation of the user_name field.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function validation_username_duplication_check($str){
		if(!$str){
			$this->validation->set_message('validation_username_duplication_check', 'The field "User Name" requires a value.');
			return FALSE;
		}elseif ( $this->user->userExists(array('user_name' => $str, 'user_id != ' => $_POST['user_id'])) ){
			$this->validation->set_message('validation_username_duplication_check', 'The username "'.$str.'" is already in use.');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function createCaptcha () {
		//build captch
		$this->load->plugin('captcha');
		$vals = array(
						'img_path'	 => './captcha/',
						'img_url'	 => 'captcha/'
					);
		
		$cap = create_captcha($vals);
	
		$image = array(
						'captcha_id'	=> '',
						'captcha_time'	=> $cap['time'],
						'ip_address'	=> $this->input->ip_address(),
						'word'			=> $cap['word']
					);
	
		$query = $this->db->insert_string('captcha', $image);
		$this->db->query($query);
	
		//add image to data
		return $cap['image'];
	}
	
	public function on_edit_success()
	{
		echo 'User successfully edited!';
		$this->view_users();
	}

	public function password_reset($error = '')
	{
		if($error == 'na') $error = 'There is no account associated with that e-mail address';
		$data['error'] = str_replace('_',' ',$error);
		$this->load->view('user/password_reset_view', $data);
	}
	
	public function password_reset_form()
	{
		//$array = array;
		$error = '';
		$rules['user_email'] = 'trim|required';
		
		$this->validation->set_rules($rules);
		if ($this->validation->run() == FALSE) 
			$error = $this->validation->error_string;
		
		if(!$error) { 
			$array = $this->user->password_reset($_POST['user_email']);
			if(is_array($array))
				$this->load->library('email');
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'iso-8859-1';
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;				
				$this->email->initialize($config);
				$this->email->from('contact@runpolitics.com', 'Password Reset');
				$this->email->to($_POST['user_email']);
				#vars
				$url = site_url("user/reset_password/{$array['fk_user_id']}/{$array['auth']}");
				$message = "Your username is: {$array['user_name']}.  Reset your password by following this link: $url";
				$subject = "RunPolitics.com Username Retrieval/Password Reset";
				#set subject
				$this->email->subject($subject);
				#set message
				$this->email->message($message);
				$this->email->set_alt_message(strip_tags($message));
				#send
				$this->email->send();
				log_message('debug', "emailReg:".trim($this->email->print_debugger()));			
			
				$this->load->view('user/sent_password_email.php', $_POST);
		} else {
			$this->password_reset($error);
		}
	}
	
	public function reset_password($user_id, $auth, $error='')
	{
		$data['error'] = str_replace('_',' ',$error);
		$data['user_id'] = $user_id;
		$data['auth'] = $auth;
		
		$this->load->view('user/reset_password_view', $data);
	}
	
	public function reset_password_form()
	{
		$error = '';
		$rules['user_password'] = 'trim|required|matches[user_password_confirm]|md5|xss_clean';
		$rules['user_password_confirm'] = 'trim|required|xss_clean';
		
		$this->validation->set_rules($rules);
		if ($this->validation->run() == FALSE) 
			$error = $this->validation->error_string;
		
		if(!$error) if(!$this->user->reset_password_validate($_POST['user_id'], $_POST['auth']))
			$error = 'Unauthorized';
		if(!$error) if($this->user->reset_password($_POST['user_id'], $_POST['user_password'])) {
			$this->load->view('user/successful_password_reset');
		}
		
		$this->reset_password($_POST['user_id'], $_POST['auth'], $error);
	}

	public function successful_password_reset() 
	{
		$this->load->view('user/successful_password_reset');
	}
	
	public function all($what, $user_name)
	{
		$data = $this->user->get_user(null ,$user_name);
		$display_name = $this->user->displayName($data['user_name']);
		
		switch ($what) {
			case 'votes':
				$data['header'] = "Votes by $display_name";
				$data['type'] = 'vote';
				$data['result'] = $this->vote->getVotesByUser($data['user_id'], true);
				break;
			case 'questions':
				$data['header'] = "Questions asked by $display_name";
				$data['type'] = 'question';
				$data['result'] = $this->question->getQuestionsByUser($data['user_id'], true);
				break;
			default:
				break;
		}
		
		foreach($data['result'] as $k => $v) {
			$data['result'][$k]['event_name'] = anchor('forums/cp/' . url_title($v['event_name']), substr($v['event_name'], 0, 20) . '...');
			$data['result'][$k]['question_name'] = anchor('question/view/' . url_title($v['event_name']) . '/' . url_title($v['question_name']), substr($v['question_name'],0,50) . '...');
		}
		
		$this->load->view('user/all_questions_votes.php', $data);
	}
	
	/** create users from passed info **/
	public function create_demo_user ($user_name,$password='') {
		$user_name = 'demoUser'.rand(0,1000).date('d');
		$data['user_name']=$user_name;
		$data['display_name']=$user_name;
		$data['user_email']=$user_name."@home.com";
		$data['user_password']=(strlen($password)>0) ? $password:md5($user_name);
		$data['user_security_level']=4;
		$data['user_status']=1;
		
		$user_id = $this->user->InsertUser($data);
		
		$this->user->login_user($user_name,$user_id);
		//redirect somewhere
		if (isset($_POST['redirect'])) redirect($_POST['redirect']); 
		else redirect('/');
		ob_clean();
		exit();
	}
		
}
?>