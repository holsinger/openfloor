<?php
/**
 * Event Controller
 */

class Event extends Controller
{
	/**
	 * Constructor
	 * This function may be able to be cleaned up...
	 */
	public function __construct()
	{
		parent::Controller();
		$this->load->helper('url');
		
		$this->load->model('Event_model','event');
		
		$this->load->library('validation');
		
		$this->load->scaffolding('cn_events');
	}
	
	/**
	 * Index Function
	 */
	public function index()
	{
		// $this->create_event();
		$this->view_events();
	}
	
	/**
	 * View Events
	 */
	public function view_events()
	{
		$this->load->helper('url');
		$this->load->library('table');
		
		$events = $this->db->get('cn_events')->result_array();
		foreach($events as $k=>$v)
			$events[$k]['edit'] = anchor("event/edit_event/{$v['event_id']}", 'Edit');
			
		$data['events'] = $events;	
		
		$this->table->set_heading('id', 'name', 'desc', 'avatar', 'sunlightid', 'date', 'location', 'edit');
    	
		$this->load->view('view_events',$data);
	}
	
	/**
	 * Edit Event
	 */
	public function edit_event($event_id, $error='')
	{
		$data['event_id'] = $event_id;
		$data['error'] = str_replace('_',' ',$error);		
		
		$event = $this->db->getwhere('cn_events', array('event_id'=>$event_id))->row();
		
		foreach($event as $k=>$v)
			$_POST[$k] = $v;
		
		$fields['event_name']	= ( isset($_POST['event_name']) ) ? $_POST['event_name']:"";
		$fields['event_desc']	= ( isset($_POST['event_desc']) ) ? $_POST['event_desc']:"";
		$fields['event_avatar']	= ( isset($_POST['event_avatar']) ) ? $_POST['event_avatar']:"";
		$fields['sunlight_id']	= ( isset($_POST['sunlight_id']) ) ? $_POST['sunlight_id']:"";
		$fields['event_date']	= ( isset($_POST['event_date']) ) ? $_POST['event_date']:"";
		$fields['location']	= ( isset($_POST['location']) ) ? $_POST['location']:"";
		
		$this->validation->set_fields($fields);
		$this->load->view('view_edit_event',$data);
	}
	
	public function edit_event_action($event_id)
	{
		$error = false;
		
		$rules['event_name'] = "";
		$rules['event_desc'] = "";
		$rules['event_avatar'] = "";
		$rules['sunlight_id'] = "";
		$rules['event_date'] = "";
		$rules['location'] = "";
		
		$this->validation->set_rules($rules);
					
		if ($this->validation->run() == FALSE) $error = $this->validation->error_string;
		
		if ( !$error ) {
			$affected_rows = $this->event->update_event_form($event_id);
			//make sure a new id was inserted
			if ( $affected_rows > 0 ) {
				//set sessions
				//$this->user->login_user($this->user->user_name,$this->user->user_id);
				//forward to a user page
				redirect('event/on_edit_success');
				ob_clean();
				exit();
			} else {
				$error = 'Error Editing Event';
			}
		} //if no error
				
		//send back the error
		$this->create_event($event_id, $error);
	}
	
	public function on_edit_success()
	{
		echo 'Event successfully edited!';
		$this->view_events();
	}
	
	/**
	 * Create Event
	 */	
	public function create_event($error='')
	{
		$data['error'] = str_replace('_',' ',$error);		
		//print_r($_POST);
		$fields['event_name']	= ( isset($_POST['event_name']) ) ? $_POST['event_name']:"";
		$fields['event_desc']	= ( isset($_POST['event_desc']) ) ? $_POST['event_desc']:"";	
		$this->validation->set_fields($fields);
		
		$this->load->view('view_manage_events',$data);
	}
	
	public function on_create_success()
	{
		echo 'Event creation complete!';
		$this->view_events();
	}
	
	public function create_event_action() {
		// print_r($_POST); exit();
		$error = false;
		
		$rules['event_name'] = "";
		$rules['event_desc'] = "";
		$rules['event_avatar'] = "";
		$rules['sunlight_id'] = "";
		$rules['event_date'] = "";
		$rules['location'] = "";
		
		$this->validation->set_rules($rules);
					
		if ($this->validation->run() == FALSE) $error = $this->validation->error_string;
		
		if ( !$error ) {
			$last_id = $this->event->insert_event_form();
			//make sure a new id was inserted
			if ( is_numeric($last_id) ) {
				//set sessions
				//$this->user->login_user($this->user->user_name,$this->user->user_id);
				//forward to a user page
				redirect('event/on_create_success');
				ob_clean();
				exit();
			} else {
				$error = 'Error Creating Event';
			}
		} //if no error
				
		//send back the error
		$this->create_event($error);
	}
}