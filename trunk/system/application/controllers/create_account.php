<?php
class Create_account extends Controller {

	function __construct()
	{
		parent::Controller();
		$this->load->helper('url');
		$this->load->helper('form');
		
		$this->load->scaffolding('cn_users');
	}
	
	
	function index()
	{
		//get the view
		$this->load->view('view_create_account');
	
	}
	
	function createUser () {
		if ( isset($_POST['user_name']) ) $this->db->set('user_name',$_POST['user_name']);
		if ( isset($_POST['user_password']) ) $this->db->set('user_password',MD5($_POST['user_password']));
		if ( isset($_POST['user_avatar']) ) $this->db->set('user_avatar',$_POST['user_avatar']);
		if ( isset($_POST['user_display_name']) ) $this->db->set('user_display_name',$_POST['user_display_name']);
		$this->db->insert('cn_users');
		$last_id = $this->db->call_function('insert_id');
		//forward to a user page
		redirect('profile/user/'.$_POST['user_name']);
		ob_clean();
		exit();
	}
}
?>