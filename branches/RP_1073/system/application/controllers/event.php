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
				$events[$k]['edit'] = anchor("event/edit_event/{$v['event_id']}", 'Edit')." | ".
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
		
		$data['rightpods'] = array('accordion' => array(), 'dynamic'=>array());
		$data['breadcrumb'] = array('Home'=>"");	
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
	
	public function create_event($error='')
	{
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);
		
		// $data['politicians'] = $this->apidata->getAllNames();		
		$data['politicians'] = $this->candidate->getCandidates();		
		$data['error'] = str_replace('_',' ',$error);
		
		$_POST['event_date'] = '0000-00-00 00:00:00';		
		
		$fields['event_name']	= ( isset($_POST['event_name']) ) ? $_POST['event_name']:"";
		$fields['event_type']	= ( isset($_POST['event_type']) ) ? $_POST['event_type']:"";
		$fields['event_desc']	= ( isset($_POST['event_desc']) ) ? $_POST['event_desc']:"";
		$fields['event_desc_brief']	= ( isset($_POST['event_desc_brief']) ) ? $_POST['event_desc_brief']:"";
		$fields['event_avatar']	= ( isset($_POST['event_avatar']) ) ? $_POST['event_avatar']:"";		
		$fields['sunlight_id']	= ( isset($_POST['sunlight_id']) ) ? $_POST['sunlight_id']:"";
		$fields['event_date']	= ( isset($_POST['event_date']) ) ? $_POST['event_date']:"";
		$fields['location']	= ( isset($_POST['location']) ) ? $_POST['location']:"";	
		$this->validation->set_fields($fields);
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/');
		
		$this->load->view('view_manage_events',$data);
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
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(), 'Events' => 'event/', 'Event Details' => '');
		$this->load->view('event/view',$data);
	}
	
	public function GetEventsForSidebar()
	{
		$events = $this->event->getEventsByDate();
		$massaged_data = Array();  // for the sake of readability.
		// Massage the information
		foreach ($events as $key => $array){
			error_log($array['event_name']." - ".strtotime($array['event_date'])." ".strtotime(date('Y-m-d')));
			if (strtotime($array['event_date']) >= strtotime(date('Y-m-d')) ){
				error_log("Counted upcoming");
				$return_array['upcoming_events'][] = $array;
			}elseif (strtotime($array['event_date']) < strtotime(date('Y-m-d'))){
				error_log('Counted Past');
				$return_array['past_events'][] = $array;
			}
		}
		
		// Since this is used by ajax, we need to return viewable material
		$st = '<h3 class="subheader">Future Events</h3><ul>';
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
		
		$st .= '</ul><h3 class="subheader">Past Events</h3><ul>';
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
}