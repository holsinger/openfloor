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
	public function view_events($error='')
	{
		$this->load->helper('url');
		//$this->load->library('table');
		
		$data['desc'] = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin condimentum varius lorem. Phasellus sodales, enim nec scelerisque egestas, tortor massa blandit ipsum, at rhoncus velit pede et velit. Sed ultricies, libero eget tincidunt vehicula, eros urna sollicitudin nisl, a viverra neque leo in elit. Etiam ut nibh. Duis bibendum tristique metus. Pellentesque at felis. Donec pretium, tortor vel blandit elementum, pede massa rhoncus turpis, sed sagittis massa mauris et enim. Aenean vel erat ac nulla blandit tincidunt. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean rhoncus sapien non urna. Nullam augue libero, viverra ac, semper elementum, dapibus et, sem. Suspendisse adipiscing risus eu libero. Phasellus consectetuer, mi blandit semper porta, lacus justo rutrum nisl, vel facilisis est pede nec risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Praesent lacinia malesuada eros. Integer eleifend posuere quam. Suspendisse at lectus. Quisque cursus.
						<br /><br />Nam sit amet tellus ac lorem dictum placerat. Phasellus lobortis enim sit amet turpis. Vivamus elit. Vivamus sed nulla. Donec ultrices cursus libero. Duis nec velit. Vestibulum rhoncus massa ac sem. Pellentesque imperdiet lectus id justo. Aliquam erat volutpat. Phasellus lacinia. Vivamus luctus est eu ligula. Aenean egestas. Donec vitae arcu ut risus ultrices eleifend. Ut elit risus, euismod id, lacinia nec, luctus vel, elit. Aenean neque. Mauris in enim. In pretium arcu et purus. Integer sodales viverra leo.
						';
		
		$events = $this->db->get('cn_events')->result_array();
		foreach($events as $k=>$v)
			if ($this->userauth->isAdmin()) $events[$k]['edit'] = anchor("event/edit_event/{$v['event_id']}", 'Edit');
			
		$data['events'] = $events;
		$data['error'] = $error;		
		
		//$this->table->set_heading('id', 'name', 'desc', 'avatar', 'sunlightid', 'date', 'location', 'edit');
    	
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
			//add event url name to array
			$array = $_POST;
			$array['event_url_name'] = url_title($_POST['event_name']);
			$affected_rows = $this->event->update_event_form($event_id,$array);
			//make sure a row was affected
			if ( $affected_rows > 0 ) {
				$error = 'Event Updated!';
				$this->view_events($error);
			} else {
				$error = 'Error Editing Event';
				$this->edit_event($event_id, $error);
			}
		} //if no error
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