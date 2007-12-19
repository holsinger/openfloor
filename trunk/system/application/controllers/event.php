<?php

class Event extends Controller
{
	public function __construct()
	{
		parent::Controller();
		$this->load->helper('url');
		
		$this->load->model('Event_model','event');
		$this->load->model('Cms_model','cms');
		$this->load->model('Candidate_model', 'candidate');
		$this->load->model('tag_model', 'tag');
		
		$this->load->library('validation');
		$this->load->library('ApiData');
		$this->load->library('Utilities');
		$this->load->library('tag_lib');
		$this->load->library('wordcloud');
		$this->load->plugin('js_calendar');
				
		$this->load->scaffolding('cn_events');
		$this->CI=& get_instance();
	}
	
	public function index()
	{
		// $this->create_event();
		$this->view_events();
	}
	
	public function view_events($error='')
	{
		$this->load->helper('url');
		//$this->load->library('table');
		
		$data['cms_id'] = $this->cms->get_id_from_url('ConventionNext');
		$data = $this->cms->get_cms($data['cms_id']);	
			
		$events = $this->event->getEventsByDate();
		//echo '<pre>'; print_r($events); echo '</pre>'; exit();
		
		
		foreach($events as $k=>$v) {
			if ($this->userauth->isAdmin()) {
				$events[$k]['edit'] = anchor("event/admin_panel/{$v['event_id']}", 'Admin')." | ".
				anchor('forums/liveQueue/' . url_title($v['event_name']), 'Live Queue')." | ".
				anchor('forums/candidateQueue/' . url_title($v['event_name']), 'Candidate Queue')." | ".
				anchor("admin/dashboard/".url_title($v['event_name']), 'Admin Dashboard')." | ".
				anchor("forums/overall_reaction/".url_title($v['event_name']), 'Overall Reaction');
			}
			$file_name = '';
			if (is_array($temp_array = unserialize($events[$k]['event_avatar']))) $file_name = $temp_array['file_name'];
			$events[$k]['event_avatar'] = $file_name;
		}
			
		$data['events'] = $events;
		$data['error'] = $error;		
		
		//$this->table->set_heading('id', 'name', 'desc', 'avatar', 'sunlightid', 'date', 'location', 'edit');
		// $data['rightpods'] = array('gvideo'=>array(),'gblog'=>array(),'dynamic'=>array());

		// tag cloud
		$data['cloud'] = $this->tag_lib->createTagCloud(null);
		// Last of the page setup, including the breadcrumb and titles which are generated dynamically
		$data['page_title'] = $this->cms->get_cms_text('', "forums_name");
		$data['future_title'] = $this->cms->get_cms_text('', "forums_future_title");
		$data['past_title'] = $this->cms->get_cms_text('', "forums_past_title");
		$data['live_title'] = $this->cms->get_cms_text('', "forums_live_title");
		$data['rightpods'] = array('accordion' => array(), 'dynamic'=>array());
		$data['left_nav'] = 'events';  
		$data['left_nav_data'] = array('title' => $this->cms->get_cms_text('', "forums_navigation_title") );
		$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name") => $this->config->site_url(), $data['page_title'] => "");	
		$this->load->view('view_events',$data);
	}
	
	public function edit_event($event_id, $error='')
	{
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		
		$data['event_id'] = $event_id;
		$data['error'] = str_replace('_',' ',$error);
		//$data['politicians'] = $this->apidata->getAllNames();		
		
		$event = $this->db->getwhere('cn_events', array('event_id'=>$event_id))->row();
		
		$data['avatar_image_name'] = (is_array($temp_array = unserialize($event->event_avatar))) ? $temp_array['file_name'] : '' ;
		
		foreach($event as $k=>$v)
			$_POST[$k] = $v;
		
		$fields['event_name']	= ( isset($_POST['event_name']) ) ? $_POST['event_name']:"";
		$fields['event_type']	= ( isset($_POST['event_type']) ) ? $_POST['event_type']:"";
		$fields['event_desc']	= ( isset($_POST['event_desc']) ) ? $_POST['event_desc']:"";
		$fields['event_desc_brief']	= ( isset($_POST['event_desc_brief']) ) ? $_POST['event_desc_brief']:"";
		//$fields['event_avatar']	= ( isset($_POST['event_avatar']) ) ? $_POST['event_avatar']:"";		
		$fields['sunlight_id']	= ( isset($_POST['sunlight_id']) ) ? $_POST['sunlight_id']:"";
		$fields['event_date']	= ( isset($_POST['event_date']) ) ? $_POST['event_date']:"";
		$fields['location']	= ( isset($_POST['location']) ) ? $_POST['location']:"";
		$fields['moderator_info']	= ( isset($_POST['moderator_info']) ) ? $_POST['moderator_info']:"";
		$fields['agenda']	= ( isset($_POST['agenda']) ) ? $_POST['agenda']:"";
		$fields['rules']	= ( isset($_POST['rules']) ) ? $_POST['rules']:"";
		$fields['other_instructions']	= ( isset($_POST['other_instructions']) ) ? $_POST['other_instructions']:"";
		$fields['stream_high']	= ( isset($_POST['stream_high']) ) ? $_POST['stream_high']:"";
		$fields['stream_low']	= ( isset($_POST['stream_low']) ) ? $_POST['stream_low']:"";
		$fields['blocked_ips']	= ( isset($_POST['blocked_ips']) ) ? $_POST['blocked_ips']:"";
		$fields['streaming']	= ( isset($_POST['streaming']) ) ? $_POST['streaming']:"";
		$fields['event_finished']	= ( isset($_POST['event_finished']) ) ? $_POST['event_finished']:"";
		
		// participating candidates
		$data['candidates'] = $this->candidate->getCandidates();
		$cansInEvent = $this->candidate->cansInEvent($event_id);
		$data['cansInEvent'] = array();
		foreach($cansInEvent as $v) $data['cansInEvent'][] = $v['fk_can_id'];
		
		$this->validation->set_fields($fields);
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/');
		$this->load->view('view_edit_event',$data);
	}
	
	public function edit_event_action($event_id)
	{
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		$error = false;
		
		// ==============
		// = Candidates =
		// ==============
		
		// in case no candidates were selected
		if(!isset($_POST['candidates'])) $_POST['candidates'] = array(); 
		$cansInEvent = unserialize(urldecode($_POST['cansInEvent']));
		
		if($_POST['candidates'] != $cansInEvent) { // a change was made
			$candidateChange = true;
			
			// Determine the new and old candidates.
			$add = array_diff($_POST['candidates'], $cansInEvent);
			$delete = array_diff($cansInEvent, $_POST['candidates']);
			
			// Add new candidates, if needed.
			if (!empty($add)) foreach($add as $v) $this->event->addCanToEvent($v, $event_id);
			
			// Delete old candidates, if necessary.
			if (!empty($delete)) foreach($delete as $v) $this->event->removeCanFromEvent($v, $event_id);
		}
		unset($_POST['candidates']);
		unset($_POST['cansInEvent']);
		
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
		
		if(!empty($_FILES['userfile']['name']))
		{
			if ( ! $this->upload->do_upload())
			{
				$error = $this->upload->display_errors();
				// exit($this->error);
			}	
			else
			{
				#remove old image
				if (isset($_POST['old_avatar']) ) 
				{
					$filename = $_POST['old_avatar'];
					// we still probably want to catch errors, but the !is_string($this->error) was causing the file not to get deleted
					if ( file_exists($filename) && $filename != './avatars/') unlink ($filename);
					unset($_POST['old_avatar']);
				}

				$data['upload_data'] = $this->upload->data();
				
				//resize image
				$config = array();
				$config['image_library'] = 'GD2';
				$config['source_image'] = './avatars/'.$data['upload_data']['file_name'];
				#$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 100;
				$config['height'] = 75;			
				$this->load->library('image_lib', $config);			
				$this->image_lib->resize();
				if ($this->image_lib->display_errors()) $this->error =  $this->image_lib->display_errors();
				else $this->error = 'Update complete!';			
			}		
		}
		
		if (isset($data['upload_data'])) {
			$_POST['event_avatar'] = serialize($data['upload_data']);
		}
		
		$rules['event_name'] = "trim|required|max_length[100]|xss_clean";
		$rules['event_desc'] = "trim|required|max_length[65535]";
		$rules['event_desc_brief'] = "trim|required|max_length[150]|xss_clean";
		$rules['sunlight_id'] = "";
		$rules['event_date'] = "trim|required|xss_clean";
		$rules['location'] = "trim|max_length[65535]";
		$rules['moderator_info'] = "trim|max_length[65535]";
		$rules['agenda'] = "trim|max_length[65535]";
		$rules['rules'] = "trim|max_length[65535]";
		$rules['other_instructions'] = "trim|max_length[65535]";
		$rules['stream_high'] = "trim|max_length[65535]";
		$rules['stream_low'] = "trim|max_length[65535]";
		$rules['blocked_ips'] = "trim|max_length[65535]";
		$rules['streaming'] = '';
		$rules['event_finished'] = '';
		#TODO is validation even being performed??
		if ( !$error ) {
			//add event url name to array
			$array = $_POST;
			$array['event_url_name'] = url_title($_POST['event_name']);
			unset($array['old_avatar']);
			$affected_rows = $this->event->update_event_form($event_id,$array);
			
			//make sure a row was affected
			if ( $affected_rows > 0 ) {
				$error = 'Event Updated!';
				$this->view_events($error);
			} elseif ($candidateChange) {
				$error = 'Event Updated!';
				$this->view_events($error);			
			} else {
				$error = 'Error editing event or no changes were made';
				$this->edit_event($event_id, $error);
			}
		}else{ //if no error
			$this->view_events($error);
		}
		
	}
	
	public function on_edit_success()
	{
		echo 'Event successfully edited!';
		$this->view_events();
	}

	/**
	 * Referenced by the create_event function.  Basically if the user has some unfinished events then it will take them here.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function event_resume(){
		
		redirect("/event/create_event/".$_POST['unfinished_event'], 'location');
	}
	
	/**
	 * Step One of the event creation process.  Also used for editing since they both use a common interface
	 *
     * Edit mode is enabled by using passing the event_id for the first parameter and "Edit" in the second
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function create_event($event_id = "none", $option = ""){
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);	
		// by default we show the form for step one, unless, it's a post and validation works out
		$show_form = true;
		
		// If post is set then we know it's coming from the submission, from which we'll want to post data and we'll want to set rules
		// for catching any errors.  If not then it can ban a new form or an update, in which case we do different things below.
		if($_POST){	
			// Format the date stuff
			if($_POST['am_pm'] == 'pm'){
				$_POST['event_date'] = $_POST['date_selected'].' '.(substr($_POST['event_time'],0, 2) + 12).substr($_POST['event_time'],2, 3);
			}else{
				$_POST['event_date'] = $_POST['date_selected'].' '.$_POST['event_time'];
			}
			// Setup the data to show on the form (used if validation is false)
			$data = $_POST;
			$data['event_time'] = (string)$_POST['event_time'];
			// Set validation rules
			$rules['event_name'] = "trim|required|max_length[100]|xss_clean";
			$rules['event_desc'] = "trim|required|max_length[65535]";
			$rules['event_desc_brief'] = "trim|required|max_length[150]|xss_clean";
			$rules['location'] = "trim|max_length[65535]";
			$rules['event_time']	= "callback_validation_time_check";
			$this->validation->set_rules($rules);
			// Set the name of the fields for validation errors (if any)
			$fields['event_name']		= 	"Event Name"; 
			$fields['event_desc']		= 	"Event Description";
			$fields['event_desc_brief']	= 	"Event Description Brief";
			$fields['event_avatar']		= 	"Event Avatar";		
			$fields['event_date']		= 	"Event Date";
			$fields['event_time']		= 	"Event Time";
			$fields['location']			= 	"Location";	
			$this->validation->set_fields($fields);
			// Check validation
			if ($this->validation->run()){
				$show_form = false;
			}
		}else{
			// Inititial page load
			// If event_id is set it is an update, if not then it's new and we'll want to set the default values for a new form.
			if($event_id != 'none'){
				$data['event_id'] = $event_id;
				// pull from db
				$data = $this->event->get_event($event_id);
				$date_exploded = explode(" ", $data['event_date']);
				$data['date_selected'] = $date_exploded[0];
				
				if(substr($date_exploded[1],0, 2) > 12){
					$data['am_pm'] = 'pm';
					$data['event_time'] = "0".(substr($date_exploded[1],0, 2) - 12).substr($date_exploded[1],2, 3);
				}else{
					$data['event_time'] = substr($date_exploded[1],0, 5);
				}
				
			}else{
				$data['event_time'] = '00:00';
				$data['date_selected'] = date('Y-m-d');
				if($option != 'ignore'){
					$unfinished_events = $this->event->get_unfinished_events_by_creator($this->CI->session->userdata('user_id'));
				
					if(count($unfinished_events) > 0){
						$data['unfinished_events'] = $unfinished_events;
						$this->load->view('event/unfinished_events',$data);
						return;
					}
				}
			}
			
		}
	
		// If initial or validation fails, show form
		if ($show_form){
			// Page Setup Stuff
			if($option == 'edit'){
				$data['page_title'] = "Edit ".$this->cms->get_cms_text('', "forums_navigation_title");
				$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', $data['page_title']  => "");
			}else{
				$data['page_title'] = "Create ".$this->cms->get_cms_text('', "forums_navigation_title")." Step One";
				$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', $data['page_title']  => "");
			}
			
			$data['option'] = $option;
			$this->load->view('event/manage_events_one',$data);
			return;
		}else{
			// Upload file first
			if(!empty($_FILES['userfile']['name'])){
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

				if ( ! $this->upload->do_upload()){
					$error = $this->upload->display_errors();
				}else{
					$data['upload_data'] = $this->upload->data();

					//resize image
					$config = array();
					$config['image_library'] = 'GD2';
					$config['source_image'] = './avatars/'.$data['upload_data']['file_name'];
					#$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 100;
					$config['height'] = 75;			
					$this->load->library('image_lib', $config);			
					$this->image_lib->resize();
					if ($this->image_lib->display_errors()) $error =  $this->image_lib->display_errors();
					$_POST['event_avatar'] = isset($data['upload_data']) ?  serialize($data['upload_data']) : '' ;
					//echo '<pre>'; print_r($_POST); echo '</pre>';	exit();	
				}
			}
			// Database stuff now
			if ( $event_id != 'none' ) {
				unset($_POST['date_selected']);
				unset($_POST['event_time']);
				unset($_POST['am_pm']);
				$_POST['event_date'].":00";
				$_POST['creator_id'] = $this->CI->session->userdata('user_id');
				$this->event->update_event_form($event_id,$_POST);
				
				if($option == 'edit'){
					redirect("/event/admin_panel/$event_id", 'location');
				}else{
					redirect("/event/create_event_two/$event_id", 'location');
				}
			}else{
				$_POST['creator_id'] = $this->CI->session->userdata('user_id');
				$last_id = $this->event->insert_event_form();

				redirect("/event/create_event_two/$last_id", 'location');				
			}
			
			
		}
		
	}
	
	/**
	 * A custom validation callback that is used for the validation of the time field.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function validation_time_check($str){
		if (!preg_match('/[0-9][0-9]:[0-9][0-9]/', $str)){
			$this->validation->set_message('validation_time_check', 'The "Event Time" needs to be in the format of ##:## (ie 09:30).');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
	 * Step two of the event creation process.  Also used for editing sicne they use a common interface
	 *
	 * Edit mode is enabled by using passing the event_id for the first parameter and "Edit" in the second
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function create_event_two($event_id, $option){
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);	
		// by default we show the form for step one, unless, it's a post and validation works out
		$show_form = true;
		$data['event_id'] = $event_id;
		$data['candidates'] = $this->candidate->cansInEvent($event_id);
		for($i = 0; $i < count($data['candidates']); $i++){
			$data['candidates'][$i] = $this->candidate->getCandidate( $data['candidates'][$i]['fk_can_id'] );
		}
		if(isset($_POST['did_submit'])){
			print_r($_POST);
			//$show_form = false;
		}
		// If initial or validation fails, show form
		if ($show_form){
			// Page Setup Stuff
			$data['page_title'] = "Create ".$this->cms->get_cms_text('', "forums_navigation_title");
			$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', $data['page_title']  => "");
			$data['option'] = $option;
			// Get 
			$this->load->view('event/manage_events_two',$data);
		}else{
			if($option == 'edit'){
				redirect("/event/admin_panel/$event_id/two", 'location');
			}else{
				redirect("/event/create_event_three/$event_id", 'location');
			}
		}
		
	}
	
	/**
	 * Step Three of the event creation process.  Also used for editing since they both use a common interface
	 *
     * Edit mode is enabled by using passing the event_id for the first parameter and "Edit" in the second
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function create_event_three($event_id, $option){
		#check that user is allowed
		$this->userauth->isUser();	
		// by default we show the form for step one, unless, it's a post and validation works out
		$show_form = true;
		
		// If post is set then we know it's coming from the submission, from which we'll want to post data and we'll want to set rules
		// for catching any errors.  If not then it can ban a new form or an update, in which case we do different things below.
		if($_POST){	
			// Setup the data to show on the form (used if validation is false)
			$data = $_POST;
			// Set validation rules
			$rules['moderator_info'] = "xss_clean";
			$rules['agenda'] = "xss_clean";
			$rules['rules'] = "xss_clean";
			$rules['other_instructions'] = "xss_clean";
			$this->validation->set_rules($rules);
			// Set the name of the fields for validation errors (if any)
			$fields['moderator_info']	= 	"Moderator Information"; 
			$fields['agenda']		= 	"Agenda";
			$fields['rules']	= 	"Rules";
			$fields['other_instructions']		= 	"Other Instructions";
			$this->validation->set_fields($fields);
			// Check validation
			if ($this->validation->run()){
				$show_form = false;
			}
		}else{
			// Inititial page load
			// If event_id is set it is an update, if not then it's new and we'll want to set the default values for a new form.
			if($event_id != 'none'){
				// pull from db
				$data = $this->event->get_event($event_id);
			}
			
		}
	
		// If initial or validation fails, show form
		if ($show_form){
			// Page Setup Stuff
			$data['event_id'] = $event_id;
			$data['page_title'] = "Create ".$this->cms->get_cms_text('', "forums_navigation_title");
			$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', $data['page_title']  => "");
			$data['option'] = $option;
			
			$this->load->view('event/manage_events_three',$data);
			return;
		}else{
			$_POST['input_complete'] = "1";
			$this->event->update_event_form($event_id,$_POST);
			$data = $this->event->get_event($event_id);
			if($option == 'edit'){
				redirect("/event/admin_panel/$event_id/three", 'location');
			}else{
				redirect("/event/admin_panel/".url_title($data['event_id']), 'location');
			}
			
		}
		
	}

	/**
	 * This provides the "remove" and "delete" functionality of event creation.  You can delete only if you meet the requirements.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function delete_speaker($can_id){
		$this->candidate->SetID($can_id);
		$this->candidate->DeleteCandidate();
	}
	
	/**
	 * This is used to search a candidate upon entering an event.  This way we reduce the duplication that can happen so easily
	 *
	 * @return (depends)
	 * @author Clark Endrizzi
	 **/
	public function search_candidate($event_id){
		
	}
	
	public function manage_candidate($event_id, $can_id){
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);	
		
		$show_form = true;		// by default we show the form for step one, unless, it's a post and validation works out
		
		if($_POST){	
			// Setup the data to show on the form (used if validation is false)
			$data = $_POST;
			// Set validation rules
			$rules['can_display_name'] = "trim|required|max_length[100]|xss_clean";
			$rules['can_bio'] = "trim|required|max_length[65535]|xss_clean";
			$rules['can_email'] = "trim|required|max_length[150]|xss_clean";
			$this->validation->set_rules($rules);
			// Set the name of the fields for validation errors (if any)
			$fields['can_display_name']		= 	"Speaker Display Name"; 
			$fields['can_bio']		= 	"Speaker Biography";
			$fields['can_email']	= 	"Speaker Email";
			$this->validation->set_fields($fields);
			// Check validation
			if ($this->validation->run()){
				$show_form = false;
			}
		}else{
			// Inititial page load
			// If event_id is set it is an update, if not then it's new and we'll want to set the default values for a new form.
			if($can_id){				
				// pull from db
				$data = $this->candidate->getCandidate($can_id);
			}
			
		}
		
		// If initial or validation fails, show form
		if ($show_form){
			// Page Setup Stuff
			if($can_id){
				$data['page_title'] = "Edit Speaker";
			}else{
				$data['page_title'] = "Create Speaker";
			}
			$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', $data['page_title']  => "");
			
			$data['event_id'] = $event_id;
			$data['can_id'] = $can_id;
			$this->load->view('candidate/manage_candidate',$data);
		}else{
			// Upload file first
			if(!empty($_FILES['userfile']['name'])){
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

				if ( ! $this->upload->do_upload()){
					$error = $this->upload->display_errors();
				}else{
					$data['upload_data'] = $this->upload->data();

					//resize image
					$config = array();
					$config['image_library'] = 'GD2';
					$config['source_image'] = './avatars/'.$data['upload_data']['file_name'];
					#$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 100;
					$config['height'] = 75;			
					$this->load->library('image_lib', $config);			
					$this->image_lib->resize();
					if ($this->image_lib->display_errors()) $error =  $this->image_lib->display_errors();
					$_POST['event_avatar'] = isset($data['upload_data']) ?  serialize($data['upload_data']) : '' ;
					//echo '<pre>'; print_r($_POST); echo '</pre>';	exit();	
				}
			}
			// Database stuff now
			if ( $can_id ) {
				$this->candidate->SetID($can_id);
				$this->candidate->SetData($_POST);
				$this->candidate->UpdateCandidate();
			}else{
				$this->candidate->SetData($_POST);
				$last_id = $this->candidate->InsertCandidate();
				$last_can_id = $this->candidate->InsertCandidateEventAssociation($last_id, $event_id);
			}
			// Show view
			redirect("/event/create_event_two/$event_id", 'location');
			
		}
		
	}
		
	public function create_event_action() 
	{
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		
		$error = false;
		
		$rules['event_name'] = "trim|required|max_length[100]|xss_clean";
		$rules['event_desc'] = "trim|required|max_length[65535]";
		$rules['event_desc_brief'] = "trim|required|max_length[150]|xss_clean";
		//$rules['event_avatar'] = "trim|max_length[255]";
		$rules['sunlight_id'] = "";
		$rules['event_date'] = "trim|required|xss_clean";
		$rules['event_type'] = "required";
		$rules['location'] = "trim|max_length[65535]";
		
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
				
				//resize image
				$config = array();
				$config['image_library'] = 'GD2';
				$config['source_image'] = './avatars/'.$data['upload_data']['file_name'];
				#$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 100;
				$config['height'] = 75;			
				$this->load->library('image_lib', $config);			
				$this->image_lib->resize();
				if ($this->image_lib->display_errors()) $error =  $this->image_lib->display_errors();
				$_POST['event_avatar'] = isset($data['upload_data']) ?  serialize($data['upload_data']) : '' ;
				//echo '<pre>'; print_r($_POST); echo '</pre>';	exit();	
			}
		}
		
		if ( !$error ) {
			$last_id = $this->event->insert_event_form();
			//make sure a new id was inserted
			if ( is_numeric($last_id) ) {
				$error = 'Event creation complete!';
				// $this->view_events($error);
				$this->edit_event($last_id);
				return;
			} else {
				$error = 'Error Creating Event';
				$this->view_events($error);
			}
		} //if no error
				
		//send back the error
		$this->create_event($error);
	}

	public function view($event_name)
	{
		$data['event'] = $this->event->get_event(null, $event_name);
		$temp_participants = $this->event->getCansInEvent($this->event->get_id_from_url($event_name));
		$temp_count = 0;
		foreach($temp_participants as $v){
			$data['event']['participants'] .= $this->candidate->linkToProfile($v);
			if($temp_count < (count($temp_participants) - 1) ){
				$data['event']['participants'] .= ', ';
			}
			
			$temp_count++;
		}
		$data['event_url'] = "event/$event_name";
		
		$data['event']['event_avatar'] = is_array($temp_array = unserialize($data['event']['event_avatar'])) ? $temp_array['file_name'] : '' ;
		$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', 'Details' => '');
		$this->load->view('event/view',$data);
	}
	
	public function GetEventsForSidebar()
	{
		$events = $this->event->getEventsByDate();
		$massaged_data = Array();  // for the sake of readability.
		// Massage the information
		foreach ($events as $key => $array){
			if (strtotime($array['event_date']) >= strtotime(date('Y-m-d')) ){
				$return_array['upcoming_events'][] = $array;
			}elseif (strtotime($array['event_date']) < strtotime(date('Y-m-d'))){
				$return_array['past_events'][] = $array;
			}
		}
		// Header
		$st.='<div class="double_line_container">
			<span style="font-weight: normal; font-family: Arial Black;	font-variant: small-caps; font-size: 25px; font-family: Georgia; color: #033D7C">'.$this->cms->get_cms_text('', "forums_name").'</span>
		</div>';
		// Since this is used by ajax, we need to return viewable material
		$st .= '<h3 class="subheader">'.$this->cms->get_cms_text('', "forums_future_title").'</h3><ul>';
		if(isset($return_array['upcoming_events'])){
			$count = 0;
			foreach ($return_array['upcoming_events'] as $key => $array){
				//$st .= $array['event_name']."<br />";
				$st .= '<li>'.anchor($this->config->site_url().'forums/cp/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>', array('title' => $array['event_name'])).'</li>';
				if($count == 1){
					break;
				}
				$count++;
			}	
		}else{
			$st .= '<li>We are working hard to bring our OpenFloor Events to your town!</li>';
		}
		
		$st .= '</ul><h3 class="subheader">'.$this->cms->get_cms_text('', "forums_past_title").'</h3><ul>';
		$count = 0;
		foreach ($return_array['past_events'] as $key => $array){
			$st .= '<li>'.anchor($this->config->site_url().'forums/cp/'.url_title($array['event_name']),'<strong>'.$array['event_name'].'</strong>', array('title' => $array['event_name'])).'</li>';
			
			if($count == 1){
				break;
			}
			$count++;
		}
		$st .= '</ul>';
		// Return json data
		echo($st);
	}
	
	public function finish_event_ajax($event_id)
	{
		echo $this->event->set_event_to_finished($event_id);
	}
	public function change_event_status_ajax($event_id, $status){
		switch ($status) {
			case "stream":
		    	echo $this->event->UpdateField($event_id, "streaming", "1");
			    break;
			case "no_stream":
		    	echo $this->event->UpdateField($event_id, "streaming", "0");
			    break;
			case "finish":
		    	echo $this->event->UpdateField($event_id, "event_finished", "1");
			    break;
			case "no_finish":
				echo $this->event->UpdateField($event_id, "event_finished", "0");
				break;
		}
	}
	// ===========================================================================
	// = ControlPanel - Displays a tab structured admin panel for event admins =
	// ===========================================================================
	public function admin_panel($event_id, $tab=""){
		// Check for permissions
		
		// set default tab
		$tab = ($tab)?$tab:"one";
		// Show page
		$data['event_id'] = $event_id;
		$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', $data['page_title']  => "");
		if($tab == 'two'){
			$data['event_id'] = $event_id;
			$data['candidates'] = $this->candidate->cansInEvent($event_id);
			for($i = 0; $i < count($data['candidates']); $i++){
				$data['candidates'][$i] = $this->candidate->getCandidate( $data['candidates'][$i]['fk_can_id'] );
			}
		}elseif($tab == 'four'){
			
		}else{
			$data = $this->event->get_event($event_id);
		}
		$data['tab'] = $tab;
		$this->load->view('event/admin_panel',$data);
	}
	// =======================================================================================
	// = ControlPanelTabAjax - Used for ajax calls to populate the tabs in the Admin Panel =
	// =======================================================================================
	public function admin_panel_tab_ajax($event_id, $tab){
		// Check for permissions
		
		// return info
		if($tab == 'two'){
			$data['event_id'] = $event_id;
			$data['candidates'] = $this->candidate->cansInEvent($event_id);
			for($i = 0; $i < count($data['candidates']); $i++){
				$data['candidates'][$i] = $this->candidate->getCandidate( $data['candidates'][$i]['fk_can_id'] );
			}
		}elseif($tab == 'four'){
			
		}else{
			$data = $this->event->get_event($event_id);
		}
		$this->load->view('event/admin_panel_tab_'.$tab ,$data);
	}
}