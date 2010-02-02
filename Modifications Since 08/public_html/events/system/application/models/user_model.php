<?php
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
    
	/**
	 * Gets the last 10 numbers, or how many are specified.
	 *
	 * @param int $num
	 * @return void
	 * @author Rob Stef, Clark Endrizzi
	 **/
    function get_last_ten_users($num = 10)
    {
        $query = $this->db->get('cn_users', $num);
        return $query->result();
    }

	
    public function activate($password, $timestamp)
    {
    	$this->db->set('user_status', true);
		$this->db->where('user_password', $password);
		$this->db->where('timestamp', base64_decode($timestamp));
		$this->db->update('cn_users');
		return $this->db->affected_rows();
    }

	/**
	 * Completes the last stuff required for a user to become setup from an invitation.  Similar to activate but without the password
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function complete_invite($user_id, $timestamp){
    	$this->db->set('user_status', true);
		$this->db->where('user_id', $user_id);
		$this->db->where('timestamp', base64_decode($timestamp));
		$this->db->update('cn_users');
		return $this->db->affected_rows();
    }	
	
	/**
	 * Add a new record to the user table.  Pass the data which is an associative array with field_name => field_value pairs
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function InsertUser($data){
		$this->db->insert('cn_users', $data); 
		return $this->db->insert_id();
	}
	
	/**
	 * Update a user record.  Pass the id to be updated and the data which is an associative array with field_name => field_value pairs
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function UpdateUser($user_id, $data){
		$this->db->where('user_id', (int) $user_id);
		$this->db->update('cn_users', $data);
		
		return $this->db->affected_rows();
	}

	/**
	 * Deletes a user that is specified by an id in the argument list
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function DeleteUser($user_id){
		$this->db->delete('cn_users', array('user_id' => $user_id));
	}
	
	/**
	 * Inserts the association record that is used between and user and an event.  Should this be on this model?
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function InsertUserEventAssociation($user_id, $event_id){
		$data = array(
			"fk_user_id" 	=> $user_id,
			"fk_event_id"	=> $event_id
		);
		$this->db->insert("cn_idx_users_events", $data);
		return $this->db->insert_id();
	}

	/**
	 * Deletes the association record that is used between and user and an event.  Should this be on this model?
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function DeleteUserEventAssociation( $user_id, $event_id){
		$this->db->delete('cn_idx_users_events', array('fk_user_id' => $user_id, 'fk_event_id' => $event_id));
		
	}

	/**
	 * Gets all the different users (Respondants) for a single event
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function GetUsersInEvent($event_id){
		return $this->db->select('*')->from('cn_idx_users_events')->where('fk_event_id', $event_id)->orderby("id", "asc")->get()->result_array();
	}
	
	/**
	 * Gets The current respondent
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function GetCurrentRespondentInEvent($event_id){
		$where = array(
			"fk_event_id"		=>	$event_id,
			"current_responder"	=>	'1'
		);
		return $this->db->select('*')->from('cn_idx_users_events')->where($where)->get()->result_array();
	}
	
	/**
	 * Get Event Status
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function GetRespondent($event_id, $user_id){
		$return_array = $this->db->select('*')->from('cn_idx_users_events')->where(array('fk_event_id' => $event_id, 'fk_user_id' => $user_id))->get()->result_array();
		//echo($this->db->last_query());
		return $return_array;
	}
	
	/**
	 * Updates the user event association.  Called it this to be consistent to the above functions
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function UpdateUserEventAssociation($association_id, $data){
		$this->db->where('id', (int) $association_id);
		$this->db->update('cn_idx_users_events', $data);
		
		return $this->db->affected_rows();
	}
	
	/**
	 * This function will do a search for the field provides with any record that contains the search_string.  Perhaps fuzzy is a little strong.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function FuzzySearch($field_name, $search_string){
		$query = $this->db->query("SELECT * FROM cn_users WHERE $field_name LIKE '%$search_string%'");
		return $query->result_array();
	}

	/**
     * this function will insert data from a posted form  (This maybe should be deprecated in light of the InsertUser function - CTE)
     */	
    function insert_user_form($can_id = null)
    {
    	if ( isset($_POST['user_name']) ) $this->db->set('user_name',$_POST['user_name']);
    	if ( isset($_POST['user_email']) ) $this->db->set('user_email',$_POST['user_email']);
		if ( isset($_POST['user_password']) ) $this->db->set('user_password',$_POST['user_password']);
		if ( isset($_POST['user_avatar']) ) $this->db->set('user_avatar',$_POST['user_avatar']);
		$this->db->set('ip_address',$ip=$_SERVER['REMOTE_ADDR']);
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
     * this function will update data from a posted form  (This maybe should be deprecated in light of the UpdateUser function - CTE)
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
		$this->db->where('user_status', true);
		$this->db->where('user_freeze', false);
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
	 * @return array (user_id,user_name,user_email,user_avatar,user_openid)
	 * @author James Kleinschnitz
	 * */
	function get_user ($user_id, $user_name='', $user_email='', $user_openid='') {
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
	 * This is like the the function above, but you specify what field to search by instead of a long list, this could probably replace the above
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function get_user_custom($field, $value)
	{
		$this->db->where($field,$value);
		$query = $this->db->get('cn_users');
		
		log_message('debug', "GET_USER_CUSTOM:".$this->db->last_query());
		if ($query->num_rows() > 0) {
			$user_array = $query->result_array();
			unset ($user_array[0]['user_password']);
			return $user_array[0];
		} else {
			return array();
		}
	}
	
	/**
	 * this function determine if a user is logged in
	 * 
	 * @param string user_id
	 * @param string user_name
	 * @return boolean 
	 * @author James Kleinschnitz
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
		$data['logged_in'] = "asdjfhlak#adsfLKJHJ";  // By Thors axe!  What the hell?  - CTE
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
    	$user_array = array();
    	$result_array = array();
    	if ($this->userauth->isAdmin()){
	    	//get alert response 24hours (Teacher)
	    	$time_diff = 24 * 3600;
	    	$history_from_24 = $history_from - $time_diff;
	    	$end_time_24 = $history_from + $time_diff;
	    	
	    	$query = $this->db->query("	SELECT 
	    									count(*) as total 
	    								FROM 
	    									cn_alerts 
	    								WHERE 
	    									(
	    									create_time > FROM_UNIXTIME({$history_from_24}) 
	    								AND 
	    									create_time < FROM_UNIXTIME({$end_time_24})
	    								AND 
	    									status = 0
	    								AND 
	    									fk_user_id = {$user_id} 
	    									)
	    								OR
	    									(
	    									create_time > FROM_UNIXTIME({$history_from_24})  
	    								AND
	    									timediff(create_time,respond_time) > '24:00:00'  
	    								AND
	    									status = 1
	    								AND 
	    									fk_user_id = {$user_id} 
	    									)");
	    	$result_array = $query->result_array();
	    	//echo $this->db->last_query();
			$query->free_result();
			$user_array['alert_24'] = $result_array[0]['total'];
			
	    	//get alert response 56hours (Teacher)
			$time_diff = 56 * 3600;
	    	$history_from_56 = $history_from - $time_diff;
	    	$end_time_56 = $history_from + $time_diff;
	    	$query = $this->db->query("	SELECT 
	    									count(*) as total 
	    								FROM 
	    									cn_alerts 
	    								WHERE 
	    									(
	    									create_time > FROM_UNIXTIME({$history_from_56}) 
	    								AND 
	    									create_time < FROM_UNIXTIME({$end_time_56})
	    								AND 
	    									status = 0
	    								AND 
	    									fk_user_id = {$user_id} 
	    									)
	    								OR
	    									(
	    									create_time > FROM_UNIXTIME({$history_from_56})  
	    								AND
	    									timediff(create_time,respond_time) > '56:00:00'  
	    								AND
	    									status = 1
	    								AND 
	    									fk_user_id = {$user_id}
	    									)");
	    	$result_array = $query->result_array();
	    	//echo $this->db->last_query();
			$query->free_result();
			$user_array['alert_56'] = $result_array[0]['total'];
			
			//get answer's rate
			$query = $this->db->query("	SELECT 
											a.rate 
										FROM
											cn_answers as a, cn_questions as q  
										WHERE
											a.fk_question_id = q.question_id 
										AND
											a.fk_user_id = {$user_id} 
										AND 
											q.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['answer_rate'] = $result_array;
	
			
			//get action 56hours
			
			//get answer's create time that later than the event's finish time
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_answers as a, cn_questions as q, cn_events as e 
										WHERE
											a.fk_question_id = q.question_id 
										AND
											q.fk_event_id = e.event_id 
										AND
											e.event_finished = 1 
										AND
											a.timestamp > e.finish_time 
										AND
											a.fk_user_id = {$user_id} 
										AND 
											a.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['finished_question_answer'] = $result_array[0]['total'];
			
			//get flagged question as promoted that the question's flag reporter is teacher
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_flags as f  
										WHERE
											f.fk_reporter_id = {$user_id} 
										AND
											f.fk_type_id = 4 
										AND 
											f.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['t_flagged_promoted'] = $result_array[0]['total'];
			
			//response to a student's request, create a new event.
			
	    	//get alert response 5hours (Teacher)
	    	$time_diff = 5 * 3600;
	    	$history_from_5 = $history_from - $time_diff;
	    	$query = $this->db->query("	SELECT 
	    									count(*) as total 
	    								FROM 
	    									cn_alerts 
	    								WHERE 
	    									create_time > FROM_UNIXTIME({$history_from_5})  
	    								AND
	    									timediff(create_time,respond_time) > '05:00:00'  
	    								AND
	    									status = 1
	    								AND 
	    									fk_user_id = {$user_id}");
	    	$result_array = $query->result_array();
	    	//echo $this->db->last_query();
			$query->free_result();
			$user_array['alert_5'] = $result_array[0]['total'];
	    	
			//Teacher makes comments on a question
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_comments as c  
										WHERE
											c.fk_user_id = {$user_id} 
										AND 
											c.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['comments'] = $result_array[0]['total'];
    	}
    	elseif (!$this->userauth->isAdmin()){
			//Start Student Karma's collection
	//		* (0) Your account is frozen
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_users as u  
										WHERE
											u.user_id = {$user_id} 
										AND 
											u.user_freeze = 1 
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['user_freeze'] = $result_array[0]['total'];
	
	//		* (1) Your question receives 50 down votes
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_votes as v, cn_questions as q   
										WHERE
											v.fk_question_id = q.question_id 
										AND 
											q.fk_user_id = {$user_id} 
										AND
											vote_value < 0 
										AND 
											v.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['down_votes'] = $result_array[0]['total'];
			
			
	//		* (1)You do not log into an event that you are required to attend
	
	//		* (6) Your question receives the 3rd inappropriate flag from another student
	//		* (4) Your question receives the 4th inappropriate flag from another student
	//		* (2) Your question receives the 5th inappropriate flag from another student
			$query = $this->db->query("	SELECT 
											count(*) as flags 
										FROM
											cn_flags as f, cn_questions as q   
										WHERE
											f.fk_question_id = q.question_id
										AND
											f.fk_type_id = 5 
										AND 
											q.fk_user_id = {$user_id} 
										AND 
											q.timestamp > FROM_UNIXTIME({$history_from})
										GROUP BY 
											f.fk_question_id
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['s_inappropriate_flag'] = $result_array;
	
	//		* (2) A teacher agrees with the students¡¯ inappropriate flag votes, and deletes your question 
			$query = $this->db->query("	SELECT 
											count(*) as total  
										FROM
											cn_flags as f, cn_questions as q, cn_alerts as a 
										WHERE
											f.fk_question_id = q.question_id
										AND
											a.fk_question_id = q.question_id  
										AND
											f.fk_type_id = 1   
										AND
											a.alert_type = 'flag_inappropriate_student' 
										AND 
											q.fk_user_id = {$user_id} 
										AND 
											a.respond_time > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			//echo $this->db->last_query();
			$query->free_result();
			$user_array['agree_inappropriate'] = $result_array[0]['total'];
			
	//		* (4) You log into an event but do nothing during the event ¨C you take no actions
	
			
	//		* (6) Your question receives the 3rd duplicate flag vote from another student
	//		* (6) Your question receives the 5th duplicate flag vote from another student
			$query = $this->db->query("	SELECT 
											count(*) as flags 
										FROM
											cn_flags as f, cn_questions as q   
										WHERE
											f.fk_question_id = q.question_id
										AND
											f.fk_type_id = 6 
										AND 
											q.fk_user_id = {$user_id} 
										AND 
											q.timestamp > FROM_UNIXTIME({$history_from})
										GROUP BY 
											f.fk_question_id
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['s_duplicate_flag'] = $result_array;
			
	//		* (6) A teacher agrees with the students¡¯ duplicate flag votes, and deletes your question
			$query = $this->db->query("	SELECT 
											count(*) as total  
										FROM
											cn_flags as f, cn_questions as q, cn_alerts as a 
										WHERE
											f.fk_question_id = q.question_id
										AND
											a.fk_question_id = q.question_id  
										AND
											f.fk_type_id = 2   
										AND
											a.alert_type = 'flag_duplicate_student' 
										AND 
											q.fk_user_id = {$user_id} 
										AND 
											a.respond_time > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['agree_duplicate'] = $result_array[0]['total'];
	
	//		* (10) Your question is popular and receives 100 total votes, and/or 50 total comments
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_votes as v, cn_questions as q   
										WHERE
											v.fk_question_id = q.question_id 
										AND 
											q.fk_user_id = {$user_id} 
										AND 
											v.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['s_votes'] = $result_array[0]['total'];
					
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_comments as c, cn_questions as q   
										WHERE
											c.fk_question_id = q.question_id 
										AND 
											q.fk_user_id = {$user_id} 
										AND 
											c.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['s_comments'] = $result_array[0]['total'];
					
	//		* (10) Your question gets answered
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_answers as a, cn_questions as q   
										WHERE
											a.fk_question_id = q.question_id 
										AND 
											q.fk_user_id = {$user_id} 
										AND 
											a.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['answers_got'] = $result_array[0]['total'];
			
	//		* (10) Your question gets flagged as ¡°promoted¡± by the teacher
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_flags as f, cn_questions as q   
										WHERE
											f.fk_question_id = q.question_id 
										AND 
											q.fk_user_id = {$user_id} 
										AND
											f.fk_type_id = 4 
										AND 
											f.timestamp > FROM_UNIXTIME({$history_from})  
										");
			$result_array = $query->result_array();
//			echo $this->db->last_query();
			$query->free_result();
			$user_array['s_flagged_promoted'] = $result_array[0]['total'];
	
	//		* (10) You request an OpenFloor event/instance
	//		* (10) Your question gets 50 up votes and/or 25 comments
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_votes as v, cn_questions as q   
										WHERE
											v.fk_question_id = q.question_id 
										AND 
											q.fk_user_id = {$user_id} 
										AND
											v.vote_value > 0 
										AND 
											v.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['up_votes'] = $result_array[0]['total'];
			
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_comments as c, cn_questions as q   
										WHERE
											c.fk_question_id = q.question_id 
										AND 
											q.fk_user_id = {$user_id} 
										AND 
											c.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['comments_25'] = $result_array[0]['total'];
			
	//		* (9) You give feedback to a teacher/respondent when they answer a question
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_answer_rate as r    
										WHERE 
											r.fk_user_id = {$user_id} 
										AND 
											r.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['feedback'] = $result_array[0]['total'];
			
	//		* (9) You make a comment
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_comments as c  
										WHERE
											c.fk_user_id = {$user_id} 
										AND 
											c.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['yours_comments'] = $result_array[0]['total'];
			
	//		* (9) You vote on someone else¡¯s question
			$query = $this->db->query("	SELECT 
											count(*) as total 
										FROM
											cn_votes as v, cn_questions as q   
										WHERE
											v.fk_question_id = q.question_id 
										AND
											v.fk_user_id = {$user_id}
										AND
											q.fk_user_id <> {$user_id} 
										AND 
											v.timestamp > FROM_UNIXTIME({$history_from})
										");
			$result_array = $query->result_array();
			$query->free_result();
			$user_array['vote_someone_else'] = $result_array[0]['total'];
    	}
		return $user_array;
			
    }//
    
    /**
     * get stats need for karma
     * 
     * @param UNIXTIME $history_from time to kout user records till
     * @param  int $user_id optional
     * 
     * @author James Kleinschnitz 
     */
//    public function get_stats ($history_from,$user_id=0)
//    {
//    	$result_array = array();
//    	$user_array = array();
//    	
//    	//total questions submitted
//			$query = $this->db->query("SELECT count(*) as total, fk_user_id FROM cn_questions WHERE timestamp > FROM_UNIXTIME({$history_from}) AND question_status != 'deleted' group by fk_user_id");
//    	$result_array = $query->result_array();
//			//echo $this->db->last_query();
//			$query->free_result();
//			
//			foreach ($result_array as $array) 
//			{
//				$user_array[$array['fk_user_id']]['user_id'] = $array['fk_user_id'];
//				$user_array[$array['fk_user_id']]['question_count'] = $array['total']; 
//			}
//			
//			//total questions asked
//			$query = $this->db->query("SELECT count(*) as total, fk_user_id FROM cn_questions WHERE timestamp > FROM_UNIXTIME({$history_from}) AND question_status = 'asked' group by fk_user_id");
//			$result_array = $query->result_array();
//			$query->free_result();
//			
//    	foreach ($result_array as $array) 
//			{
//				$user_array[$array['fk_user_id']]['user_id'] = $array['fk_user_id'];
//				$user_array[$array['fk_user_id']]['question_asked_count'] = $array['total']; 
//			}
//			
//			//total num casted votes
//			$query = $this->db->query("SELECT count(*) as total, cn_votes.fk_user_id from cn_votes, cn_questions  WHERE cn_votes.timestamp > FROM_UNIXTIME({$history_from}) and cn_questions.question_id = cn_votes.fk_question_id and cn_questions.question_status = 'asked' group by cn_votes.fk_user_id");
//			$result_array = $query->result_array();
//			$query->free_result();
//			
//    	foreach ($result_array as $array) 
//			{
//				$user_array[$array['fk_user_id']]['user_id'] = $array['fk_user_id'];
//				$user_array[$array['fk_user_id']]['vote_count'] = $array['total']; 
//			}
//			
//			//total asked votes
//			$query = $this->db->query("select count(*) as total, user_id from cn_users,cn_questions where cn_questions.timestamp > FROM_UNIXTIME({$history_from}) and cn_questions.question_status != 'deleted' and cn_users.user_id = cn_questions.fk_user_id group by user_id");
//			$result_array = $query->result_array();
//			$query->free_result();
//			
//    	foreach ($result_array as $array) 
//			{
//				$user_array[$array['user_id']]['user_id'] = $array['fk_user_id'];
//				$user_array[$array['user_id']]['vote_asked_count'] = $array['total']; 
//			}
//			
//			//get last activity date
//			$this->db->select('fk_user_id,timestamp');
//			$this->db->groupby('fk_user_id');
//			$this->db->orderby('timestamp','desc');
//			$query = $this->db->get('cn_questions');
//			$result_array = $query->result_array();
//			$query->free_result();
//			
//    	foreach ($result_array as $array) 
//			{
//				$user_array[$array['fk_user_id']]['user_id'] = $array['fk_user_id'];
//				$user_array[$array['fk_user_id']]['last_activity'] = $array['timestamp']; 
//			}
//			
//    	$this->db->select('fk_user_id,timestamp');
//			$this->db->groupby('fk_user_id');
//			$this->db->orderby('timestamp','desc');
//			$query = $this->db->get('cn_votes');
//			$result_array = $query->result_array();
//			$query->free_result();
//			
//    	foreach ($result_array as $array) 
//			{
//				$user_array[$array['fk_user_id']]['user_id'] = $array['fk_user_id'];
//				//set only if is newer then past value
//				if ( strtotime($array['timestamp']) > strtotime($user_array[$array['fk_user_id']]['last_activity']) )
//				{
//					$user_array[$array['fk_user_id']]['last_activity'] = $array['timestamp'];
//				} 
//			}
//			
//			return $user_array;
//			
//    }//
		
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
	/**
	 * Checks that the user exists either by the sent criteria.  Seems like this could be done in a standard where function.
	 * 
	 * @return void
	 * @author ???, Clark Endrizzi (Updated and commented)
	 **/
	public function userExists($user){
		// Check to make sure the right arguments were given
		/*
		if(!in_array($user, array('user_name', 'user_email')) || count($user) != 1){
			show_error('User_model::userExists: malformed argument');
		}*/
		// If so run it
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
		$array = array('fk_user_id' => $fk_user_id, 'user_name' =>$result->user_name, 'auth' => $auth);
		$this->db->insert('cn_password_reset', array('fk_user_id' => $array['fk_user_id'], 'auth' => $array['auth']));
		if($this->db->affected_rows() == 1) {
			// $url = site_url("user/reset_password/$fk_user_id/$auth");
			// $message = 'Reset your password by following this link: ' . $url;
			// $subject = "RunPolitics.com Password Reset";
			// mail($result->user_email, $subject, $message);
			// $data['email'] = $result->user_email;
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

	public function last_10()
	{
		return $this->db->select('user_name, user_email, timestamp')->orderby('user_id', 'desc')->limit(10)->get('cn_users')->result();
	}

	public function get($field)
	{
		return $this->db->select($field)->where('user_id', $this->user_id)->get('cn_users')->row()->$field;
	}
	
	/**
	 * this function will return true if argument is an active user 
	 * @param string username
	 * @return boolean
	 * @author James Kleinschnitz
	 **/
	public function is_username($value='')
	{
		return $this->userExists(array('user_name'=>$value,'user_status'=>1));
	}
	
	public function freezeUser($user_id)
	{
        $this->db->where('user_id', (int) $user_id);
		$this->db->update('cn_users', array('user_freeze' => 1));
		
		return $this->db->affected_rows();
	}
	
	public function getFreezeUser()
	{
		return $this->db->query('SELECT * FROM cn_users where user_freeze = 1 order by timestamp desc')->result_array();
	}
	
	public function getUserIdByEmail($email)
	{
		$result = $this->db->query("SELECT user_id FROM cn_users WHERE user_email = '" . $email . "'")->result_array();
		return $result[0]['user_id'];
	}
}
?>