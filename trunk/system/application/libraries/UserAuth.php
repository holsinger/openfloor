<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserAuth {
	
	function __construct() {
		
		//we need to get access to the CI object
		$this->CI=& get_instance();

		//define user levels
		define('SL_SUPER_ADMIN',0);
		define('SL_ADMIN',2);
		define('SL_USER',4);
		define('SL_BLOCKED',100);
			
        log_message('debug', "FreakAuth Class Initialized");
		$this->CI->load->model('User_model','user');
		$this->CI->load->helper('url');
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
			redirect('user/login/');
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