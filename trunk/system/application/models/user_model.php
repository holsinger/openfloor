<?
class User_model extends Model {

	var $user_id   = 0;	
    var $user_name   = '';
    var $user_email   = '';
    var $user_password = '';
    var $user_avatar = '';
    var $default_security_level = SL_USER;

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
    function insert_user_form($can_id = null)
    {
    	if ( isset($_POST['user_name']) ) $this->db->set('user_name',$_POST['user_name']);
    	if ( isset($_POST['user_email']) ) $this->db->set('user_email',$_POST['user_email']);
		if ( isset($_POST['user_password']) ) $this->db->set('user_password',$_POST['user_password']);
		if ( isset($_POST['user_avatar']) ) $this->db->set('user_avatar',$_POST['user_avatar']);
		if ( isset($_POST['user_openid']) ) $this->db->set('user_openid',$_POST['user_openid']);
		if ( isset($can_id) ) $this->db->set('fk_can_id',$can_id);
		$this->db->set('user_security_level',$this->default_security_level);
		$this->db->insert('cn_users');
		
		$user_id = $this->db->insert_id();
		
		//set the class vars
	    $this->user_id = $user_id;	
	    $this->user_name = $_POST['user_name'];
	    $this->user_email  = $_POST['user_email'];
	    //$this->user_avatar  = $_POST['user_avatar'];
	    		
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
		$this->db->update('cn_users');
		return $this->db->affected_rows();
    }
    
    /**
     * this function will validate a user login
     */
	function check_user_login () {
		// candidate check
		if(strpos($_POST['user_name'], '@') !== false)
			$_POST['user_name'] = '_' . url_title($_POST['user_name']);
			
		$this->db->where('user_name',$_POST['user_name']);
		$this->db->where('user_password',$_POST['user_password']);		
		$query = $this->db->get('cn_users');
		log_message('debug',"UserLogin: ".$this->db->last_query());
		if ($query->num_rows() > 0) {
		   $row = $query->row();
		   if ($row->user_security_level > 4) 
		   {
			   return false;
			   exit();
		   }
		   
		   //set the class vars
		   $this->user_id = $row->user_id;	
		   $this->user_name = $row->user_name;
		   $this->user_avatar  = $row->user_avatar;
		   $this->user_avatar  = $row->user_email;
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
		log_message('debug', "GET_USER:".$this->db->last_query());
		if ($query->num_rows() > 0) {
			$user_array = $query->result_array();
			//var_dump($user_array);
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
		#TODO remove user_name from the sessions use userauth obj
		$data['user_name'] = $user_name; 
		$data['user_id'] = $user_id;
		$data['logged_in'] = "asdjfhlak#adsfLKJHJ";
		
		$this->session->set_userdata($data);
		return true;
	}
	
	function update_user_form_admin($user_id)
    {
        $this->db->where('user_id', (int) $user_id);
		$this->db->update('cn_users', $_POST);
		
		return $this->db->affected_rows();
    }
    
    /**
     * this will check if the user has param status
     * user)id is optional other wise it will get it from the session
     * 
     * @param int security_level the security levle in question
     * @param int user_id the id of the user in question
     */
    public function check_status ($security_level,$user_id=0)
    {
    	$user_array = array();
    	#make sure we have a user id to use
    	if ($this->userauth->user_id) $this->db->where('user_id', (int) $this->userauth->user_id);
    	else if ($user_id) $this->db->where('user_id', (int) $user_id);
    	else 
    	{
    		log_message('error','USER:CHECK_STATUS:no user id found');
    		return FALSE;
    	}
    	#get user record
    	$query = $this->db->get('cn_users');
		log_message('debug', "GET_USER:".$this->db->last_query());
		if ($query->num_rows() > 0) {
			$user_array = $query->result_array();
			//var_dump($user_array);
			
			#now check user security level
			if ( $user_array[0]['user_security_level'] <= $security_level ) return TRUE;
			else return FALSE;
		} else {
			return FALSE;
		}//end if else results
    	
    }
    
    /**
     * get stats need for karma
     * 
     * @param UNIXTIME $history_from time to kout user records till
     * @param  int $user_id optional
     * 
     * @author James Kleinschnitz 
     */
    public function get_stats ($history_from,$user_id=0)
    {
    	$result_array = array();
    	$user_array = array();
    	
    	//total questions submitted
			$query = $this->db->query("SELECT count(*) as total, fk_user_id FROM cn_questions WHERE timestamp > FROM_UNIXTIME({$history_from}) AND question_status != 'deleted' group by fk_user_id");
    	$result_array = $query->result_array();
			//echo $this->db->last_query();
			$query->free_result();
			
			foreach ($result_array as $array) 
			{
				$user_array[$array['fk_user_id']]['user_id'] = $array['fk_user_id'];
				$user_array[$array['fk_user_id']]['question_count'] = $array['total']; 
			}
			
			//total questions asked
			$query = $this->db->query("SELECT count(*) as total, fk_user_id FROM cn_questions WHERE timestamp > FROM_UNIXTIME({$history_from}) AND question_status = 'asked' group by fk_user_id");
			$result_array = $query->result_array();
			$query->free_result();
			
    	foreach ($result_array as $array) 
			{
				$user_array[$array['fk_user_id']]['user_id'] = $array['fk_user_id'];
				$user_array[$array['fk_user_id']]['question_asked_count'] = $array['total']; 
			}
			
			//total num casted votes
			$query = $this->db->query("SELECT count(*) as total, cn_votes.fk_user_id from cn_votes, cn_questions  WHERE cn_votes.timestamp > FROM_UNIXTIME({$history_from}) and cn_questions.question_id = cn_votes.fk_question_id and cn_questions.question_status = 'asked' group by cn_votes.fk_user_id");
			$result_array = $query->result_array();
			$query->free_result();
			
    	foreach ($result_array as $array) 
			{
				$user_array[$array['fk_user_id']]['user_id'] = $array['fk_user_id'];
				$user_array[$array['fk_user_id']]['vote_count'] = $array['total']; 
			}
			
			//total asked votes
			$query = $this->db->query("select count(*) as total, user_id from cn_users,cn_questions where cn_questions.timestamp > FROM_UNIXTIME({$history_from}) and cn_questions.question_status != 'deleted' and cn_users.user_id = cn_questions.fk_user_id group by user_id");
			$result_array = $query->result_array();
			$query->free_result();
			
    	foreach ($result_array as $array) 
			{
				$user_array[$array['user_id']]['user_id'] = $array['fk_user_id'];
				$user_array[$array['user_id']]['vote_asked_count'] = $array['total']; 
			}
			
			//get last activity date
			$this->db->select('fk_user_id,timestamp');
			$this->db->groupby('fk_user_id');
			$this->db->orderby('timestamp','desc');
			$query = $this->db->get('cn_questions');
			$result_array = $query->result_array();
			$query->free_result();
			
    	foreach ($result_array as $array) 
			{
				$user_array[$array['fk_user_id']]['user_id'] = $array['fk_user_id'];
				$user_array[$array['fk_user_id']]['last_activity'] = $array['timestamp']; 
			}
			
    	$this->db->select('fk_user_id,timestamp');
			$this->db->groupby('fk_user_id');
			$this->db->orderby('timestamp','desc');
			$query = $this->db->get('cn_votes');
			$result_array = $query->result_array();
			$query->free_result();
			
    	foreach ($result_array as $array) 
			{
				$user_array[$array['fk_user_id']]['user_id'] = $array['fk_user_id'];
				//set only if is newer then past value
				if ( strtotime($array['timestamp']) > strtotime($user_array[$array['fk_user_id']]['last_activity']) )
				{
					$user_array[$array['fk_user_id']]['last_activity'] = $array['timestamp'];
				} 
			}
			
			return $user_array;
			
    }//
		
    /**
     * @param int $user_id 
     * @param int $user_karma new karma score for a user
     */
	public function set_karma ($user_id,$user_karma) 
	{
		$this->db->where("user_id",$user_id);
		$this->db->set("user_karma",$user_karma);
		$this->db->update("cn_users");
	}
	
	public function get_karma ($user_id) 
	{
			$this->db->where("user_id",$user_id);
			$query = $this->db->get("cn_users");
			$array = $query->result_array();
			return $array[0]['user_karma'];			
	}

	public function userExists($user)
	{
		$array_keys = array_keys($user);
		if(!in_array($array_keys[0], array('user_name', 'user_email')) || count($user) != 1)
			show_error('User_model::userExists: malformed argument');
		$result = $this->db->getwhere('cn_users', $user)->row_array();
		return empty($result) ? false : true ;
	}
	
	public function password_reset($user_email)
	{
		$result = $this->db->getwhere('cn_users', array('user_email' => $user_email))->row();
		
		if(empty($result))
			redirect('user/password_reset/na');
			
		$fk_user_id = $result->user_id;
		$auth = md5(uniqid(rand(), true));
		$array = array('fk_user_id' => $fk_user_id, 'auth' => $auth);
		$this->db->insert('cn_password_reset', $array);
		if($this->db->affected_rows() == 1) {
//			$url = site_url("user/reset_password/$fk_user_id/$auth");
//			$message = 'Reset your password by following this link: ' . $url;
//			$subject = "RunPolitics.com Password Reset";
//			mail($result->user_email, $subject, $message);
//			$data['email'] = $result->user_email;
			return $array;
		}		
		return false;
	}
	
	public function reset_password($user_id, $password)
	{
		$this->db->where('user_id', $user_id);
		$this->db->update('cn_users', array('user_password' => $password));
		if($this->db->affected_rows() == 1) {
			$this->db->where('fk_user_id', $user_id);
			$this->db->delete('cn_password_reset');
			redirect('user/successful_password_reset');
		}	
		else redirect();
	}
	
	public function reset_password_validate($user_id, $auth)
	{
		$result = $this->db->getwhere('cn_password_reset', array('fk_user_id' => $user_id, 'auth' => $auth))->row();
		return !empty($result);
	}
	
	public function displayName($user)
	{
		$a = is_numeric($user) ? $this->get_user($user) : $this->get_user(null, $user);
		if(!isset($a['fk_can_id'])) return $a['user_name'];
		return $this->db->select('can_display_name')->from('cn_candidates')->where('can_id',$a['fk_can_id'])->get()->row()->can_display_name;
	}
	
	public function bio($user)
	{
		$a = is_numeric($user) ? $this->get_user($user) : $this->get_user(null, $user);
		if(!isset($a['fk_can_id'])) return '';
		return $this->db->select('can_bio')->from('cn_candidates')->where('can_id',$a['fk_can_id'])->get()->row()->can_bio;
	}
	
	public function can_id($user)
	{
		$a = is_numeric($user) ? $this->get_user($user) : $this->get_user(null, $user);
		if(!isset($a['fk_can_id'])) return false;
		return $a['fk_can_id'];
	}

	public function user_name($user_id)
	{
		return $this->db->select('user_name')->from('cn_users')->where('user_id',$user_id)->get()->row()->user_name;
	}
}
?>