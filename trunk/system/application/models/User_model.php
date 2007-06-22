<?
class User_model extends Model {

	var $user_id   = 0;	
    var $user_name   = '';
    var $user_password = '';
    var $user_avatar = '';
    var $user_display_name = '';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
    
    function get_last_ten_users()
    {
        $query = $this->db->get('cn_users', 10);
        return $query->result();
    }

    /**
     * this function will insert data from a posted form
     */	
    function insert_user_form()
    {
        if ( isset($_POST['user_name']) ) $this->db->set('user_name',$_POST['user_name']);
        if ( isset($_POST['user_email']) ) $this->db->set('user_email',$_POST['user_email']);
		if ( isset($_POST['user_password']) ) $this->db->set('user_password',$_POST['user_password']);
		if ( isset($_POST['user_avatar']) ) $this->db->set('user_avatar',$_POST['user_avatar']);
		if ( isset($_POST['user_display_name']) ) $this->db->set('user_display_name',$_POST['user_display_name']);
		$this->db->insert('cn_users');
		
		$user_id = $this->db->insert_id();
		
		//set the class vars
	    $this->user_id = $user_id;	
	    $this->user_name = $_POST['user_name'];
	    $this->user_avatar  = $_POST['user_email'];
	    
		return $user_id;
    }

    /**
     * this function will update data from a posted form
     */	
    function update_user_form()
    {
    	//make sure we have a user id for the where clause
    	if ( !is_numeric($_POST['user_id']) ) return false;
    		
    	$this->db->where('user_id',$_POST['user_id']);	
        if ( isset($_POST['user_name']) ) $this->db->set('user_name',$_POST['user_name']);
		if ( isset($_POST['user_password']) ) $this->db->set('user_password',MD5($_POST['user_password']));
		if ( isset($_POST['user_avatar']) ) $this->db->set('user_avatar',$_POST['user_avatar']);
		if ( isset($_POST['user_display_name']) ) $this->db->set('user_display_name',$_POST['user_display_name']);
		$this->db->update('cn_users');
		return $this->db->affected_rows();
    }
    
    /**
     * this function will validate a user login
     */
	function check_user_login () {
		$this->db->where('user_name',$_POST['user_name']);
		$this->db->where('user_password',$_POST['user_password']);		
		$query = $this->db->get('cn_users');
		log_message('debug',"UserLogin: ".$this->db->last_query());
		if ($query->num_rows() > 0) {
		   $row = $query->row();
		   
		   //set the class vars
		   $this->user_id = $row->user_id;	
		   $this->user_name = $row->user_name;
		   $this->user_avatar  = $row->user_avatar;
		   $this->user_avatar  = $row->user_email;
		   $this->user_display_name = $row->user_display_name;
		   return true;
		} else {
			return false;
		}
	}
	
	/**
	 * this function will get user data return in an array
	 * 
	 * @param string user_id
	 * @param string user_name
	 * @param string user_email
	 * @param string user_openid
	 * @retun array (user_id,user_name,user_email,user_avatar,user_openid)
	 * @autho James Kleinschnitz
	 * */
	function get_user ($user_id,$user_name='',$user_email='',$user_openid='') {
		if ( $user_id ) $this->db->where('user_id',$user_id);
		if ( $user_name ) $this->db->where('user_name',$user_name);
		if ( $user_email ) $this->db->where('user_email',$user_email);
		if ( $user_openid ) $this->db->where('user_openid',$user_openid);
		$query = $this->db->get('cn_users');
		if ($query->num_rows() > 0) {
			$user_array = $query->result_array();
			unset ($user_array[0]['user_password']);
			return $user_array[0];
		} else {
			return array();
		}//end if else results
	}
	
	/**
	 * this function determine if a user is logged in
	 * 
	 * @param string user_id
	 * @param string user_name
	 * @retun boolean 
	 * @autho James Kleinschnitz
	 * */
	function is_logged_in ($user_id,$user_name='') {
		//return true if input value == sessions and logged in is set
		if ( $this->session->userdata('logged_in') == "asdjfhlak#adsfLKJHJ" ) {
			if ( $user_id && ($this->session->userdata('user_id')==$user_id) ) return true;
			if ( $user_name && ($this->session->userdata('user_name')==$user_name) ) return true;			
		}
		//make sure we return something
		return false;
	}
	
/**
	 * this function determine if a user is logged in
	 * 
	 * @param string user_name
	 * @param string user_id
	 * @retun boolean 
	 * @autho James Kleinschnitz
	 * */
	function login_user ($user_name,$user_id) {
		$data['user_name'] = $user_name;
		$data['user_id'] = $user_id;
		$data['logged_in'] = "asdjfhlak#adsfLKJHJ";
		
		$this->session->set_userdata($data);
		return true;
	}
}
?>