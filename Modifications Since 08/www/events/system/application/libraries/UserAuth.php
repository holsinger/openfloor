<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserAuth {
	
	var $user_id = 0;
	var $user_karma = 0;
	var $user_name = '';
	var $user_email = '';
	var $user_avatar = '';
	var $user_avatar_path = '';
	var $candidate = false;
	var $display_name = '';
	
	function __construct() {
		
		//we need to get access to the CI object
		$this->CI=& get_instance();

		//define user levels
		define('SL_SUPER_ADMIN',0);
		define('SL_ADMIN',2);
		define('SL_USER',4);
		define('SL_BLOCKED',100);
			
		$this->CI->load->model('User_model','user');
		$this->CI->load->model('event_model','event');
		$this->CI->load->helper('url');
		
		//set user vars
		$this->set_user();
	}
	
	
	function set_user()
	{
		if ( $this->isUser() )
		{
			$this->user_id = $this->CI->session->userdata('user_id');
			//get karma score
			$user_array = $this->CI->user->get_user($this->CI->session->userdata('user_id'));
			$this->user_karma = $user_array['user_karma'];
			$this->user_name = $this->display_name = $user_array['user_name'];
			$this->user_email = $user_array['user_email'];
			$this->candidate = isset($user_array['fk_can_id']);
			
			$image_array = unserialize($user_array['user_avatar']);
			if ($image_array) {
				$this->user_avatar_path = "./avatars/".$image_array['file_name'];
				$this->user_avatar = $image_array['file_name'];
			}	else 	{
				$this->user_avatar_path = "./images/image01.jpg";
				$this->user_avatar = 'image01.jpg';
			}
			
			// set display name (if candidate)
			if($this->candidate) $this->display_name = $this->CI->user->displayName($user_array['user_id']);
			
			#TODO check user security level get all user info
		}
	}
	/**
	 * this function should check to that the user has the correct rights
	 * if does not have correct rights send to login page
	 *	
	 * @param string $security_level
	 * @author James KLeinschnitz
	 */
	public function check($security_level=SL_USER)
	{
		if ( $this->CI->user->check_status ($security_level) ) return TRUE;
		else {
			redirect('user/loginToDo' . $this->CI->uri->uri_string());
			ob_clean();
			exit();			
		}
	}
	
	/**
	 * returns boolean of user status
	 *
	 * @return boolean
	 * @author James Kleinschnitz
	 */
	public function isUser ()
	{
		return $this->CI->user->is_logged_in($this->CI->session->userdata('user_id'));
	}
	
	/**
	 * returns boolean of user admin status
	 *
	 * @return boolean
	 * @author James Kleinschnitz
	 */
	public function isAdmin ()
	{
		//make sure we have a user session
		if ( !$this->CI->user->is_logged_in($this->CI->session->userdata('user_id')) ) return FALSE;
		
		if ( $this->CI->user->check_status (SL_ADMIN) ) return TRUE;
		else return FALSE;
	}
	
	/**
	 * Returns whether the user qualifies as an administrator.  This returns true if the user has specific permissions for the event or 
	 * if the user is an admin.  Used when checking for admin rights for events.
	 *
	 * @return boolean
	 * @author Clark Endrizzi
	 */
	public function isEventAdmin($event_id){
		if ( !$this->CI->user->is_logged_in($this->CI->session->userdata('user_id')) ) return FALSE;
		// First check for admin through the normal method
		if($this->isAdmin()){
			return TRUE;
		}else{
			$event_data = $this->CI->event->get_event($event_id);
			if( $event_data['creator_id'] == $this->CI->session->userdata('user_id') ){
				return TRUE;
			}else{
				/*
					TODO Add extra permission checking when the feature is added.
				*/
				return FALSE;
			}
		}
	}
	
	/**
	 * returns boolean of user super admin status
	 *
	 * @return boolean
	 * @author James Kleinschnitz
	 */
	public function isSuperAdmin ()
	{
		//make sure we have a user session
		if ( !$this->CI->user->is_logged_in($this->CI->session->userdata('user_id')) ) return FALSE;
		
		if ( $this->CI->user->check_status (SL_SUPER_ADMIN) ) return TRUE;
		else return FALSE;
		
	}
}

?>