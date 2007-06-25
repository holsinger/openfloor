<?php

class Event_model extends Model
{
	function __constructor()
	{
		parent::Model();
	}
	
	function insert_event_form()
    {
		foreach($_POST as $k=>$v)
			$_POST[$k] = $this->db->escape($v);
		
		if ( isset($_POST['event_name']) ) $this->db->set('event_name',$_POST['event_name']);
        if ( isset($_POST['event_desc']) ) $this->db->set('event_desc',$_POST['event_desc']);
		if ( isset($_POST['event_avatar']) ) $this->db->set('event_avatar',$_POST['event_avatar']);
		if ( isset($_POST['sunlight_id']) ) $this->db->set('sunlight_id',$_POST['sunlight_id']);
		if ( isset($_POST['event_date']) ) $this->db->set('event_date',$_POST['event_date']);
		if ( isset($_POST['location']) ) $this->db->set('location',$_POST['location']);
		$this->db->insert('cn_events');
		
		$event_id = $this->db->insert_id();
		
		return $event_id;
    }

	function update_event_form($event_id)
    {
        $this->db->where('event_id', (int) $event_id);
		$this->db->update('cn_events', $_POST);
		
		return $this->db->affected_rows();
    }
}
?>