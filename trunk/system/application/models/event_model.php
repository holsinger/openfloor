<?php

class Event_model extends Model
{
	function __constructor()
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
		if ( isset($_POST['event_avatar']) ) $this->db->set('event_avatar',$_POST['event_avatar']);
		if ( isset($_POST['sunlight_id']) ) $this->db->set('sunlight_id',$_POST['sunlight_id']);
		if ( isset($_POST['event_date']) ) $this->db->set('event_date',$_POST['event_date']);
		if ( isset($_POST['location']) ) $this->db->set('location',$_POST['location']);
		$this->db->insert('cn_events');
		log_message('debug', "EVENT:insertEvent:".trim($this->db->last_query()));
		$event_id = $this->db->insert_id();
		
		return $event_id;
    }

	function update_event_form($event_id,$array)
    {
        $this->db->where('event_id', (int) $event_id);
		$this->db->update('cn_events', $array);
		
		return $this->db->affected_rows();
    }
    
	public function getEvents()
	{
		$query = $this->db->query('SELECT * FROM cn_events');
		return $query->result_array();
	}
	
	/**
	 * return the id from the event url name
	 * 
	 * @param string $url event url name
	 * @author James Kleinschnitz
	 */
	public function get_id_from_url ($url)
	{
		 $result_array = array(); 
		 $query = $this->db->getwhere('cn_events', array('event_url_name' => $url));
		 log_message('debug', "EVENT:getIDfromURL:".trim($this->db->last_query()));
		 $result_array = $query->result_array();
		 return $result_array[0]['event_id'];
	}
	
/**
	 * return the id for the event url name
	 * 
	 * @param string $url event url name
	 * @author James Kleinschnitz
	 */
	public function get_event ($id,$url='',$date_start='',$date_end='')
	{
		 $result_array = array(); 
		 if ($id) $this->db->where('event_id',$id);
		 if ($url) $this->db->where('event_url_name',$url);
		 $query = $this->db->get('cn_events');
		 log_message('debug', "EVENT:getEvent:".trim($this->db->last_query()));
		 $result_array = $query->result_array();
		 return $result_array[0];
	}
}
?>