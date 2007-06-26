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
	
	function login () {
		$rules['user_name'] = "trim|required|min_length[5]|max_length[12]|xss_clean";
		$rules['user_password'] = "trim|required|md5";
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
		$data['capimage'] = $cap['image'];
		
		//set field values
		$fields['user_name']	= ( isset($_POST['user_name']) ) ? $_POST['user_name']:"";
		$fields['user_email']	= ( isset($_POST['user_email']) ) ? $_POST['user_email']:"";	
		$this->validation->set_fields($fields);
		
		$this->load->view('view_create_account',$data);
	}
	
	function create () {
		$error = false;
		
		$rules['user_name'] = "trim|required|min_length[5]|max_length[12]|xss_clean";
		$rules['user_password'] = "trim|required|matches[password_confirm]|md5";
		$rules['password_confirm'] = "trim|required";
		$rules['user_email'] = "trim|required|valid_email";
		$rules['captcha'] = "callback_check_captcha";
		
		$this->validation->set_rules($rules);
					
		if ($this->validation->run() == FALSE) $error = $this->validation->error_string;
		
		if ( !$error ) {
			$last_id = $this->user->insert_user_form();
			//make sure a new id was inserted
			if ( is_numeric($last_id) ) {
				//set sessions
				$this->user->login_user($this->user->user_name,$this->user->user_id);
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
		//allow segment 3 to be an id or username
		$error = $this->error;
		$user_id = '';
		$user_name = '';
		if ( is_numeric($this->uri->segment(3)) ) $user_id = $this->uri->segment(3);
		if ( is_string($this->uri->segment(3)) ) $user_name = $this->uri->segment(3); 
		$data = $this->user->get_user($user_id,$user_name);
		//set error if there is one
		$data['error'] = (count($data) > 0)?$error:'No user record round for: '.$this->uri->segment(3);
		$data['owner'] = $this->user->is_logged_in($user_id,$user_name);
		//exit(var_dump($data));
		$this->load->view('view_user_profile',$data);
	}
	
	function update () {
		$config['upload_path'] = './avatars/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '250';
		$config['max_width']  = '640';
		$config['max_height']  = '480';
		$config['encrypt_name']  = TRUE;
				
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload('user_avatar'))
		{
			$error = array('error' => $this->upload->display_errors());
			
			$this->load->view('view_user_profile', $error);
		}	
		else
		{
			$data = array('upload_data' => $this->upload->data());
			
			$this->load->view('upload_success', $data);
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
		$this->load->helper('url');
		$this->load->library('table');
		
		$users = $this->db->get('cn_users')->result_array();
		foreach($users as $k=>$v)
			$users[$k]['edit'] = anchor("user/edit_user/{$v['user_id']}", 'Edit');
			
		$data['users'] = $users;	
		
		$this->table->set_heading('id', 'name', 'password', 'avatar', 'display_name', 'edit');
    	
		$this->load->view('view_users',$data);
	}
	
	/**
	 * Edit User
	 */
	public function edit_user($user_id, $error='')
	{
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
		$error = false;
		
		$rules['user_name'] = "trim|required";
		$rules['user_password'] = "trim|required";
		$rules['user_avatar'] = "trim";
		$rules['user_display_name'] = "trim";
		
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
	
	public function on_edit_success()
	{
		echo 'User successfully edited!';
		$this->view_users();
	}
}
?>