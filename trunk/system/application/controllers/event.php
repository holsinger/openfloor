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
		$this->load->model('Cms_model','cms');
		
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
		
		$data['cms_id'] = $this->cms->get_id_from_url('ConventionNext');
		$data = $this->cms->get_cms($data['cms_id']);	
			
		$events = $this->db->get('cn_events')->result_array();
		//echo '<pre>'; print_r($events); echo '</pre>'; exit();
		
		
		foreach($events as $k=>$v) {
			if ($this->userauth->isAdmin()) $events[$k]['edit'] = anchor("event/edit_event/{$v['event_id']}", 'Edit');
			$file_name = '';
			if (is_array($temp_array = unserialize($events[$k]['event_avatar']))) $file_name = $temp_array['file_name'];
			$events[$k]['event_avatar'] = $file_name;
		}
			
		$data['events'] = $events;
		$data['error'] = $error;		
		
		//$this->table->set_heading('id', 'name', 'desc', 'avatar', 'sunlightid', 'date', 'location', 'edit');
    $data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/');	
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
		//print_r($event); exit();
		$data['avatar_image_name'] = (is_array($temp_array = unserialize($event->event_avatar))) ? $temp_array['file_name'] : '' ;
		
		foreach($event as $k=>$v)
			$_POST[$k] = $v;
		
		$fields['event_name']	= ( isset($_POST['event_name']) ) ? $_POST['event_name']:"";
		$fields['event_type']	= ( isset($_POST['event_type']) ) ? $_POST['event_type']:"";
		$fields['event_desc']	= ( isset($_POST['event_desc']) ) ? $_POST['event_desc']:"";
		//$fields['event_avatar']	= ( isset($_POST['event_avatar']) ) ? $_POST['event_avatar']:"";		
		$fields['sunlight_id']	= ( isset($_POST['sunlight_id']) ) ? $_POST['sunlight_id']:"";
		$fields['event_date']	= ( isset($_POST['event_date']) ) ? $_POST['event_date']:"";
		$fields['location']	= ( isset($_POST['location']) ) ? $_POST['location']:"";
		
		$this->validation->set_fields($fields);
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/');
		$this->load->view('view_edit_event',$data);
	}
	
	public function edit_event_action($event_id)
	{
		
		
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		$error = false;
		
		
		// ==================
		// = uploading code =
		// ==================
		$config['upload_path'] = './avatars/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1024';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  = FALSE;
		$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload())
		{
			$this->error = $this->upload->display_errors();
		}	
		else
		{
			$data['upload_data'] = $this->upload->data();
			//echo '<pre>'; print_r($data); echo'</pre>'; exit();
			
			//resize image
			$config = array();
			$config['image_library'] = 'GD2';
			$config['source_image'] = './avatars/'.$data['upload_data']['file_name'];
			#$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 75;
			$config['height'] = 50;			
			$this->load->library('image_lib', $config);			
			$this->image_lib->resize();
			if ($this->image_lib->display_errors()) $this->error =  $this->image_lib->display_errors();
			else $this->error = 'Update complete!';			
		}
		
		#remove old image
		if (isset($_POST['old_avatar']) ) 
		{
			$filename = $_POST['old_avatar'];
			if ( file_exists($filename) && !is_string($this->error)) unlink ($filename);
			unset($_POST['old_avatar']);
		}
		
		// foreach($_POST as $k=>$v) $userdata[$k] = $v;
		// if(isset($data['upload_data'])) $userdata['user_avatar'] = serialize($data['upload_data']);
		
		//add to db
		#TODO move to model
		// $this->db->where('user_id', $userdata['user_id']);
		// $this->db->update('cn_users', $userdata);
				
		//send back to the profile
		// $this->profile();  // Actually, send back to event_view
		
		// echo '<pre>'; print_r($data); echo '</pre>'; exit();
		$_POST['event_avatar'] = isset($data['upload_data']) ?  serialize($data['upload_data']) : '' ;
		
		
		$rules['event_name'] = "trim|required|max_length[100]|xss_clean";
		$rules['event_desc'] = "trim|required|max_length[255]|xss_clean";
		$rules['event_avatar'] = ''; //"trim|max_length[255]";
		$rules['sunlight_id'] = "";
		$rules['event_date'] = "trim|required|xss_clean";
		$rules['location'] = "trim|max_length[100]|xss_clean";
		
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
		$fields['event_type']	= ( isset($_POST['event_type']) ) ? $_POST['event_type']:"";
		$fields['event_desc']	= ( isset($_POST['event_desc']) ) ? $_POST['event_desc']:"";
		$fields['event_avatar']	= ( isset($_POST['event_avatar']) ) ? $_POST['event_avatar']:"";		
		$fields['sunlight_id']	= ( isset($_POST['sunlight_id']) ) ? $_POST['sunlight_id']:"";
		$fields['event_date']	= ( isset($_POST['event_date']) ) ? $_POST['event_date']:"";
		$fields['location']	= ( isset($_POST['location']) ) ? $_POST['location']:"";	
		$this->validation->set_fields($fields);
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/');
		$this->load->view('view_manage_events',$data);
	}
	
	
	public function create_event_action() {
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		
		$error = false;
		
		$rules['event_name'] = "trim|required|max_length[100]|xss_clean";
		$rules['event_desc'] = "trim|required|max_length[255]|xss_clean";
		//$rules['event_avatar'] = "trim|max_length[255]";
		$rules['sunlight_id'] = "";
		$rules['event_date'] = "trim|required|xss_clean";
		$rules['event_type'] = "required";
		$rules['location'] = "trim|max_length[100]|xss_clean";
		
		$this->validation->set_rules($rules);
					
		if ($this->validation->run() == FALSE) $error = $this->validation->error_string;
		
		if(!empty($_FILES['userfile']['name']))
		{
			// ==================
			// = uploading code =
			// ==================
			$config['upload_path'] = './avatars/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '1024';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$config['overwrite']  = FALSE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);
		
			if ( ! $this->upload->do_upload())
			{
				$error = $this->upload->display_errors();
			}	
			else
			{
				$data['upload_data'] = $this->upload->data();
				//echo '<pre>'; print_r($data); echo'</pre>'; exit();
			
				//resize image
				$config = array();
				$config['image_library'] = 'GD2';
				$config['source_image'] = './avatars/'.$data['upload_data']['file_name'];
				#$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 75;
				$config['height'] = 50;			
				$this->load->library('image_lib', $config);			
				$this->image_lib->resize();
				if ($this->image_lib->display_errors()) $error =  $this->image_lib->display_errors();
				$_POST['event_avatar'] = isset($data['upload_data']) ?  serialize($data['upload_data']) : '' ;		
			}
		}
		
		if ( !$error ) {
			$last_id = $this->event->insert_event_form();
			//make sure a new id was inserted
			if ( is_numeric($last_id) ) {
				$error = 'Event creation complete!';
				$this->view_events($error);
			} else {
				$error = 'Error Creating Event';
				$this->view_events($error);
			}
		} //if no error
				
		//send back the error
		$this->create_event($error);
	}
}