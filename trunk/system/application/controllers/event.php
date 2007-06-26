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
		$this->load->library('ApiData');
		$this->load->plugin('js_calendar');
		
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
			if ($this->userauth->isAdmin()) $events[$k]['edit'] = anchor("event/edit_event/{$v['event_id']}", 'Edit');
			
		$data['events'] = $events;	
		
		$this->table->set_heading('id', 'name', 'desc', 'avatar', 'sunlightid', 'date', 'location', 'edit');
    	
		$this->load->view('view_events',$data);
	}
	
	/**
	 * Edit Event
	 */
	public function edit_event($event_id, $error='')
	{
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		
		$data['event_id'] = $event_id;
		$data['error'] = str_replace('_',' ',$error);
		$data['politicians'] = $this->apidata->getAllNames();		
		
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
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		
		$error = false;
		
		$rules['event_name'] = "trim|required|max_length[100]";
		$rules['event_desc'] = "trim|required|max_length[255]";
		$rules['event_avatar'] = "trim|max_length[255]";
		$rules['sunlight_id'] = "";
		$rules['event_date'] = "trim|required";
		$rules['location'] = "trim|max_length[100]";
		
		$this->validation->set_rules($rules);
					
		if ($this->validation->run() == FALSE) $error = $this->validation->error_string;
		
		if ( !$error ) {
			$affected_rows = $this->event->update_event_form($event_id);
			//make sure a row was affected
			if ( $affected_rows > 0 ) {
				redirect('event/on_edit_success');
				ob_clean();
				exit();
			} else {
				$error = 'Error Editing Event';
			}
		} //if no error
				
		//send back the error
		$this->edit_event($event_id, $error);
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
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		
		$data['politicians'] = $this->apidata->getAllNames();		
		$data['error'] = str_replace('_',' ',$error);
		
		$_POST['event_date'] = '0000-00-00 00:00:00';		
		
		$fields['event_name']	= ( isset($_POST['event_name']) ) ? $_POST['event_name']:"";
		$fields['event_desc']	= ( isset($_POST['event_desc']) ) ? $_POST['event_desc']:"";
		$fields['event_avatar']	= ( isset($_POST['event_avatar']) ) ? $_POST['event_avatar']:"";		
		$fields['sunlight_id']	= ( isset($_POST['sunlight_id']) ) ? $_POST['sunlight_id']:"";
		$fields['event_date']	= ( isset($_POST['event_date']) ) ? $_POST['event_date']:"";
		$fields['location']	= ( isset($_POST['location']) ) ? $_POST['location']:"";	
		$this->validation->set_fields($fields);
		
		$this->load->view('view_manage_events',$data);
	}
	
	public function on_create_success()
	{
		echo 'Event creation complete!';
		$this->view_events();
	}
	
	public function create_event_action() {
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		
		$error = false;
		
		$rules['event_name'] = "trim|required|max_length[100]";
		$rules['event_desc'] = "trim|required|max_length[255]";
		$rules['event_avatar'] = "trim|max_length[255]";
		$rules['sunlight_id'] = "";
		$rules['event_date'] = "trim|required";
		$rules['location'] = "trim|max_length[100]";
		
		$this->validation->set_rules($rules);
					
		if ($this->validation->run() == FALSE) $error = $this->validation->error_string;
		
		if ( !$error ) {
			$last_id = $this->event->insert_event_form();
			//make sure a new id was inserted
			if ( is_numeric($last_id) ) {
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