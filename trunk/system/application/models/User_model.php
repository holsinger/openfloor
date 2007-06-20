<?
class User_model extends Model {

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
		if ( isset($_POST['user_password']) ) $this->db->set('user_password',MD5($_POST['user_password']));
		if ( isset($_POST['user_avatar']) ) $this->db->set('user_avatar',$_POST['user_avatar']);
		if ( isset($_POST['user_display_name']) ) $this->db->set('user_display_name',$_POST['user_display_name']);
		$this->db->insert('cn_users');
		return $this->db->insert_id();
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
		$this->db->where('user_password',md5($_POST['user_name']));		
		$query = $this->db->get('cn_users');
		log_message('debug',"UserLogin: ".$this->db->last_query());
		if ($query->num_rows() > 0) {
		   $row = $query->row();
		
		   $this->user_name = $row->user_name;
		   $this->user_avatar  = $row->user_avatar;
		   $this->user_display_name = $row->user_display_name;
		   return true;
		} else {
			return false;
		}
	}

}
?>