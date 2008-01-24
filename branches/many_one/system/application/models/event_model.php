<?php

class Event_model extends Model
{
	var $id;
	
	function __construct()
	{
		parent::Model();
	}
	
	function insert_event_form()
    {
		
		if ( isset($_POST['event_name']) ) {
			$this->db->set('event_name',$_POST['event_name']);
			$this->db->set('event_url_name',url_title($_POST['event_name']));
		}
    	if ( isset($_POST['event_desc']) ) $this->db->set('event_desc',$_POST['event_desc']);
	    if ( isset($_POST['event_desc_brief']) ) $this->db->set('event_desc_brief',$_POST['event_desc_brief']);
	    if ( isset($_POST['event_type']) ) $this->db->set('event_type',$_POST['event_type']);
		if ( isset($_POST['event_avatar']) ) $this->db->set('event_avatar',$_POST['event_avatar']);
		if ( isset($_POST['event_date']) ) $this->db->set('event_date',$_POST['event_date']);
		if ( isset($_POST['location']) ) $this->db->set('location',$_POST['location']);
		if ( isset($_POST['creator_id']) ) $this->db->set('creator_id',$_POST['creator_id']);
		if ( isset($_POST['stream_low']) ) $this->db->set('stream_low',$_POST['stream_low']);
		if ( isset($_POST['stream_high']) ) $this->db->set('stream_high',$_POST['stream_high']);
		$this->db->insert('cn_events');
		log_message('debug', "EVENT:insertEvent:".trim($this->db->last_query()));
		$event_id = $this->db->insert_id();
		
		return $event_id;
    }

	function get_unfinished_events_by_creator($creator_id){
		$query = $this->db->query('SELECT * FROM cn_events WHERE creator_id = '.$creator_id.' AND input_complete = 0 ORDER BY  event_date');
		return $query->result_array();
	}

	function update_event_form($event_id,$array)
    {
        $this->db->where('event_id', (int) $event_id);
		$this->db->update('cn_events', $array);
		
		return $this->db->affected_rows();
    }
    
	public function getEvents()
	{
		$query = $this->db->query('SELECT * FROM cn_events WHERE input_complete = 1');
		return $query->result_array();
	}
	
	public function getEventsByDate()
	{
		$query = $this->db->query('SELECT * FROM cn_events WHERE input_complete = 1 ORDER BY event_date DESC');
		return $query->result_array();
	}
		
	public function get_id_from_url ($url)
	{
		$result = $this->db->getwhere('cn_events', array('event_url_name' => $url))->row_array();
		log_message('debug', "EVENT:getIDfromURL:".trim($this->db->last_query()));
		if(empty($result)) return false;
		return $result['event_id'];
	}
	
	public function get_event ($id, $url='',$date_start='',$date_end='')
	{
		$result_array = array(); 
		if ($id) $this->db->where('event_id',$id);
		if ($url) $this->db->where('event_url_name',$url);

		$query = $this->db->get('cn_events');
		log_message('debug', "EVENT:getEvent:".trim($this->db->last_query()));
		$result_array = $query->result_array();

		if (count($result_array) > 0){
			return $result_array[0];
		}else{
			return false; 
		} 
			
		 
	}
	
 	public function get_event_type ($id) 
 	{
 		$array = $this->get_event($id);
 		return $array['event_type'];
 	}

	public function restart_question_timer($event_id)
	{
		$event_id = $this->db->escape($event_id);
		$this->db->query("UPDATE cn_events SET last_response=now() WHERE event_id=$event_id");
	}

	public function last_response($event_id)
	{
		$last_response = $this->db->getwhere('cn_events', array('event_id' => $event_id))->row()->last_response;
		return date('m/d/Y g:i:s A', strtotime($last_response));
	}
	
	public function addCanToEvent($can_id, $event_id)
	{
		$this->db->insert('cn_idx_candidates_events', array('fk_can_id' => $can_id, 'fk_event_id' => $event_id));
	}
	
	public function removeCanFromEvent($can_id, $event_id)
	{
		$this->db->delete('cn_idx_candidates_events', array('fk_can_id' => $can_id, 'fk_event_id' => $event_id));
	}

	/**
	 * Get candidates within an event
	 *
	 * @return void
	 * @author Clark Endrizzi, Rob Stef
	 **/
	public function getCansInEvent($event_id, $full = false)
	{
		$candidates = $this->db->select('*')->from('cn_idx_users_events')->where('fk_event_id', $event_id)->orderby("id", "asc")->get()->result_array();
		if(count($candidates) > 0 ){
			$return = array();
			foreach($candidates as $v){
				$return[] = $v['fk_user_id'];
			} 
			if(!$full){
				return $return;
			}else{
				$array = $this->db->query("SELECT user_id, display_name FROM cn_idx_users_events, cn_users WHERE fk_user_id = user_id AND fk_event_id = $event_id ORDER BY id ASC")->result_array();
				return $array;
			}
		}
		
	}

	public function rss_upcoming_questions($event_id)
	{
		// how dow we want to order these?
		return $this->db->query("SELECT event_name, question_name, question_desc FROM cn_questions, cn_events WHERE fk_event_id = event_id AND question_status = 'pending' and fk_event_id = $event_id;")->result();
		// return $this->db->select('question_name, question_desc')->where(array('fk_event_id' => $event_id, 'question_status' => 'pending'))->get('cn_questions')->result();
	}

	public function get($field)
	{
		return $this->db->select($field)->where('event_id', $this->id)->get('cn_events')->row()->$field;
	}

	public function streaming()
	{
		if(!isset($this->id)) exit();
		return $this->db->select('streaming')->where('event_id', $this->id)->get('cn_events')->row()->streaming;
	}

	public function rss_events()
	{
		return $this->db->select('event_id, event_name, event_desc')->orderby('event_date', 'desc')->get('cn_events')->result();
	}

	public function UpdateField($event_id, $field_name, $field_value)
	{
		$this->db->query("UPDATE cn_events SET $field_name = '$field_value' WHERE event_id = $event_id");
		return $this->db->affected_rows();
	}
}
?>