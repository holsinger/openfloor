<?php
class User extends Controller {

	var $error = '';
	
	function __construct()
	{
		parent::Controller();
		$this->load->helper('url');
		
		$this->load->model('User_model','user');
		
		$this->load->library('validation');
		
		$this->load->scaffolding('cn_users');
	}
	
	
	function index()
	{
		//default show create account form
		$this->view_users();
	
	}
	function loginToDo () {
		$func_args = func_get_args();
		$data['location'] = implode('/', $func_args);
		$data['error'] = 'Please login to do that.';
		$this->load->view('view_login',$data);
	}
	function login () {
		$rules['user_name'] = "trim|required|min_length[5]|max_length[12]|xss_clean";
		$rules['user_password'] = "trim|required|md5|xss_clean";
		$this->validation->set_rules($rules);
							
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
			else redirect('user/profile/'.$this->session->userdata('user_name'));
			ob_clean();
			exit();
		} else {
			$data['error'] = 'Login Failed, Please Try Again';
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
		$data['error'] = str_replace('_',' ',$error);
	
		//add image to data
		$data['capimage'] = $this->createCaptcha();
		
		//set field values
		$fields['user_name']	= ( isset($_POST['user_name']) ) ? $_POST['user_name']:"";
		$fields['user_email']	= ( isset($_POST['user_email']) ) ? $_POST['user_email']:"";	
		$this->validation->set_fields($fields);
		
		$this->load->view('view_create_account',$data);
	}
	
	function create () {
		$error = false;
		
		$rules['user_name'] = "trim|required|min_length[5]|max_length[45]|xss_clean";
		//open require if no open id
		if (!isset($_POST['user_openid'])) $rules['user_password'] = "trim|required|matches[password_confirm]|md5|xss_clean";
		if (!isset($_POST['user_openid'])) $rules['password_confirm'] = "trim|required|xss_clean";
		$rules['user_email'] = "trim|required|valid_email|xss_clean";
		$rules['captcha'] = "callback_check_captcha";
		
		$this->validation->set_rules($rules);
					
		if ($this->validation->run() == FALSE) $error = $this->validation->error_string;
		
		if ( !$error ) {
			$last_id = $this->user->insert_user_form();
			//make sure a new id was inserted
			if ( is_numeric($last_id) ) {
				//set sessions
				$this->user->login_user($this->user->user_name,$this->user->user_id);
				//send mail
				$this->load->library('email');
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'iso-8859-1';
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;				
				$this->email->initialize($config);
				$this->email->from('contact@politic20.com', 'Registration');
				$this->email->to($this->user->user_email);
				
				$this->email->subject('Thanks for Registering');
				
				$this->load->model('Cms_model','cms');
				$cms_id = $this->cms->get_id_from_url('email_registration');
				$cms = $this->cms->get_cms($cms_id);	
				$this->email->message($cms['cms_text']);
				$this->email->set_alt_message(strip_tags($cms['cms_text']));
				
				$this->email->send();
				log_message('debug', "emailReg:".trim($this->email->print_debugger()));
				//forward to a user page
				redirect('user/profile/'.$_POST['user_name']);
				ob_clean();
				exit();
			} else {
				$error = 'Error Creating Account';
			}
		} //if no error
				
		//send back the error
		$this->createAccount($error);
	}
	
	public function updateProfile()
	{
		//echo '<pre>'; print_r($_POST); echo'</pre>'; exit();
		// =====================================
		// = insert profile updating code here =
		// =====================================
		
		$error = $this->error;
		$user_id = '';
		$user_name = '';
		if ( is_numeric($this->uri->segment(3)) ) $user_id = $this->uri->segment(3);
		if ( is_string($this->uri->segment(3)) ) $user_name = $this->uri->segment(3); 
		$data = $this->user->get_user($user_id,$user_name);
		$userdata = $data;
		//set error if there is one
		$data['error'] = (count($data) > 0)?$error:'No user record found for: '.$this->uri->segment(3);
		$data['owner'] = $this->user->is_logged_in($user_id,$user_name);
		//exit(var_dump($data));
		
		// ==================
		// = uploading code =
		// ==================
		if(!empty($_FILES['userfile']['name']))
		{
			$config['upload_path'] = './avatars/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '1024';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$config['overwrite']  = FALSE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);
		
			if ( ! $this->upload->do_upload())
			{
				$this->error = $this->upload->display_errors();
			}	
			else
			{
				$data['upload_data'] = $this->upload->data();
			
				//resize image
				$config = array();
				$config['image_library'] = 'GD2';
				$config['source_image'] = './avatars/'.$data['upload_data']['file_name'];
				#$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 75;
				$config['height'] = 50;			
				$this->load->library('image_lib', $config);			
				$this->image_lib->resize();
				if ($this->image_lib->display_errors()) $this->error =  $this->image_lib->display_errors();
				else $this->error = 'Update complete!';			
			}
	
		
			#remove old image
			if (isset($_POST['old_avatar']) ) 
			{
				$filename = $_POST['old_avatar'];
				// we still probably want to catch errors, but the !is_string($this->error) was causing the file not to get deleted
				if ( file_exists($filename) /*&& !is_string($this->error)*/) unlink($filename);
				unset($_POST['old_avatar']);
			}
		}
		
		foreach($_POST as $k=>$v) $userdata[$k] = $v;
		if(isset($data['upload_data'])) $userdata['user_avatar'] = serialize($data['upload_data']);
		
		unset($userdata['user_karma'], $userdata['old_avatar']);
		//add to db
		#TODO move to model
		$this->db->where('user_id', $userdata['user_id']);
		$this->db->update('cn_users', $userdata);
				
		//send back to the profile
		$this->profile();
		
	}

	function loginOpenID () {	
		$data['error'] = "OpenID Error";
		if (isset($_POST['openid_action']) && $_POST['openid_action'] == "login"){ // Get identity from user and redirect browser to OpenID Server
			$this->load->library('SimpleOpenID');
			$this->simpleopenid->SetIdentity($_POST['openid_url']);
			$this->simpleopenid->SetTrustRoot('http://'.$_SERVER['SERVER_NAME'].'/p20/' );
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
					redirect('user/profile/'.$this->session->userdata('user_name'));
					ob_clean();
					exit();						
				} else {
					$data['error'] = 'No user record found for: '.$_GET['openid_identity'];
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
			$this->simpleopenid->SetTrustRoot('http://'.$_SERVER['SERVER_NAME'].'/p20/' );
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
	
	function profile () {
		//allow segment 3 to be an id or username
		$error = $this->error;
		$user_id = '';
		$user_name = '';
		if ( is_numeric($this->uri->segment(3)) ) $user_id = $this->uri->segment(3);
		if ( is_string($this->uri->segment(3)) ) $user_name = $this->uri->segment(3); 
		$data = $this->user->get_user($user_id,$user_name);
		//set error if there is one
		$data['error'] = (count($data) > 0)?$error:'No user record found for: '.$this->uri->segment(3);
		$data['owner'] = $this->user->is_logged_in($user_id,$user_name);

		if (is_string($data['user_avatar']) && is_array(unserialize($data['user_avatar'])) )

		{
			$image_array = unserialize($data['user_avatar']);
			
			$data['avatar_image_name'] = $image_array['file_name'];
			$data['avatar_image_height'] = $image_array['image_height'];
			$data['avatar_image_width'] = $image_array['image_width'];
			$data['avatar_image_path'] = "./avatars/".$image_array['file_name'];
		}
		else 
		{				
			$data['avatar_image_path'] = './images/image01.jpg';
		}
		//exit(var_dump($data));
		//admin is also an owner
		if ( $this->userauth->isAdmin() ) $data['owner'] = TRUE;
		$this->load->view('view_user_profile',$data);
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
	 * Edit User
	 */
	public function edit_user($user_id, $error='')
	{
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		
		$data['user_id'] = $user_id;
		$data['error'] = str_replace('_',' ',$error);		
		
		$user = $this->db->getwhere('cn_users', array('user_id'=>$user_id))->row();
		
		foreach($user as $k=>$v)
			$_POST[$k] = $v;
		
		$fields['user_name']	= ( isset($_POST['user_name']) ) ? $_POST['user_name']:"";
		$fields['user_password']	= ( isset($_POST['user_password']) ) ? $_POST['user_password']:"";
		$fields['user_avatar']	= ( isset($_POST['user_avatar']) ) ? $_POST['user_avatar']:"";
		$fields['user_display_name']	= ( isset($_POST['user_display_name']) ) ? $_POST['user_display_name']:"";
		
		$this->validation->set_fields($fields);
		$this->load->view('view_edit_user',$data);
	}
	
	public function edit_user_action($user_id)
	{
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		
		$error = false;
		
		$rules['user_name'] = "trim|required|xss_clean";
		$rules['user_password'] = "trim|required|xss_clean";
		$rules['user_avatar'] = "trim";
		$rules['user_display_name'] = "trim|xss_clean";
		
		$this->validation->set_rules($rules);
					
		if ($this->validation->run() == FALSE) $error = $this->validation->error_string;
		
		if ( !$error ) {
			$affected_rows = $this->user->update_user_form_admin($user_id);
			//make sure a row was affected
			if ( $affected_rows > 0 ) {
				redirect('user/on_edit_success');
				ob_clean();
				exit();
			} else {
				$error = 'Error Editing User or no updates were made';
			}
		} //if no error
				
		//send back the error
		$this->edit_user($user_id, $error);
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
}
?>