<?php
/**
 * This controller has to do with events.  Right now it handles the viewing and editing of events only, and not the live event functionality (look to the forums controller for this)
 *
 * @author Clark Endrizzi, Rob Stef, James Klien
 * @version none
 * @copyright Run_Polictics, 19 December, 2007
 * @package default
 **/

/*
	TODO Could probably be combined with the forums controller.  The forums controller may be the better name too since events is too specific.
*/


class Event extends Controller
{
	public function __construct()
	{
		parent::Controller();
		$this->load->helper('url');
		
		$this->load->model('Event_model','event');
		$this->load->model('Cms_model','cms');
		$this->load->model('user_model', 'user');
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
	
	/**
	 * Default function.  This will call this just passes to view_events(below)
	 *
	 * @return void
	 * @author (????)
	 **/
	public function index()
	{
		// $this->create_event();
		$this->view_events();
	}
	
	/**
	 * This returns all the events when a user wants to see the full list	
	 *
	 * @return void
	 * @author Clark Endrizzi, Rob Stef
	 **/
	public function view_events($error=''){
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
		$data['users'] = $this->user->GetUsersInEvent($event_id);
		for($i = 0; $i < count($data['users']); $i++){
			$data['users'][$i] = $this->user->get_user( $data['users'][$i]['fk_user_id'] );
		}
		if(isset($_POST['did_submit'])){
			$show_form = false;
		}
		// If initial or validation fails, show form
		if ($show_form){
			// Page Setup Stuff
			$data['page_title'] = "Create ".$this->cms->get_cms_text('', "forums_navigation_title");
			$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', $data['page_title']  => "");
			$data['option'] = $option;
			$data['current_user_id'] = $this->CI->session->userdata('user_id');
			// Get 
			$this->load->view('event/manage_events_two',$data);
		}else{
			if($option == 'edit'){
				redirect("/event/admin_panel/$event_id/2", 'location');
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
				redirect("/event/admin_panel/$event_id/3", 'location');
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
	public function delete_speaker($user_id, $event_id, $option){
		error_log("Deleting");
		// Check that this can be done here
		
		// Delete
		$this->user->DeleteUserEventAssociation($user_id, $event_id);
		if($option == 'delete'){
			$this->user->DeleteUser($user_id);
		}
	}
	
	/**
	 * This is used to search a candidate upon entering an event.  This way we reduce the duplication that can happen so easily
	 *
	 * @return (depends)
	 * @author Clark Endrizzi
	 **/
	public function search_candidate($event_id, $add_user_id){
		#check that user is allowed
		$this->userauth->isUser();	
		
		$show_form = true;		// by default we show the form for step one, unless, it's a post and validation works out
		
		if($add_user_id){	
			$show_form = false;
		}
		
		// If initial or validation fails, show form
		if ($show_form){
			// Page Setup Stuff
			$data['page_title'] = "Add Speaker";

			$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', $data['page_title']  => "");
			
			$data['event_id'] = $event_id;
			$data['user_id'] = $user_id;
			$this->load->view('candidate/speaker_search',$data);
		}else{
			$last_can_id = $this->user->InsertUserEventAssociation($add_user_id, $event_id);
			// Show view
			redirect("/event/create_event_two/$event_id", 'location');
			
		}
	}
	
	/**
	 * Used in editing/creating a candidate (speaker) while editing/creating an event.	
	 *
	 * @return (view)
	 * @author Clark Endrizzi
	 **/
	public function manage_candidate($event_id, $user_id = false, $default_display_name = false){
		#check that user is allowed
		$this->userauth->check(SL_ADMIN);	
		
		$show_form = true;		// by default we show the form for step one, unless, it's a post and validation works out
		
		if($_POST){	
			// Setup the data to show on the form (used if validation is false)
			$data = $_POST;
			// Set validation rules
			$rules['display_name'] = "trim|required|max_length[100]|xss_clean";
			$rules['bio'] = "trim|required|max_length[65535]|xss_clean";
			$rules['user_email']	= "callback_validation_email_duplication_check";
			$this->validation->set_rules($rules);
			// Set the name of the fields for validation errors (if any)
			$fields['display_name']		= 	"Speaker Display Name"; 
			$fields['bio']		= 	"Speaker Biography";
			$fields['user_email']	= 	"Speaker Email";
			$this->validation->set_fields($fields);
			// Check validation
			if ($this->validation->run() && !$this->user->userExists(array('user_email' => $_POST['user_email'])) ){
				$show_form = false;
			}
		}else{
			// Inititial page load
			// If event_id is set it is an update, if not then it's new and we'll want to set the default values for a new form.
			if($user_id && $user_id != 'none'){				
				// pull from db
				$data = $this->user->get_user($user_id);
			}
			
		}
		
		// If initial or validation fails, show form
		if ($show_form){
			// Page Setup Stuff
			if($user_id && $user_id != 'none'){	
				$data['page_title'] = "Edit Speaker";
			}else{
				$data['page_title'] = "Create Speaker";
			}
			$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', $data['page_title']  => "");
			
			$data['event_id'] = $event_id;
			$data['user_id'] = $user_id;

			if($default_display_name){
				$data['display_name'] = $default_display_name;
			}
			
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
				$this->user->UpdateUser($user_id, $_POST);
			}else{
				$invite_speaker = $_POST['invite_speaker']; unset($_POST['invite_speaker']);
				$invitation_text = $_POST['invitation_text']; unset($_POST['invitation_text']);
				$_POST['creator_id'] = $this->CI->session->userdata('user_id');
				
				$last_id = $this->user->InsertUser($_POST);
				$last_can_id = $this->user->InsertUserEventAssociation($last_id, $event_id);
				// Email if options was selected
				if($invite_speaker == 'invite'){
					error_log("Trying to send email to {$_POST['user_email']}!");
					//send mail
					$this->load->library('email');
					$config['mailtype'] = 'html';
					$config['wordwrap'] = TRUE;				
					$this->email->initialize($config);
					$this->email->from('contact@runpolitics.com', 'RunPolitics.com Invitation');
					$this->email->to($_POST['user_email']);
					// vars
					$this->user->user_id = $last_id;
					$timestamp = $this->user->get('timestamp');
					$url = site_url('user/invite_accept/' . $_POST['user_password'] . '/' . base64_encode($timestamp));
					$message = 'You have been invited to participate in an event.  Please click on this link to activate your account: ' . $url;
					if($invitation_text){
						$message .= '<br /><br />Clark Endrizzi wrote the following:<br />'.$invitation_text;
					}
					// set subject
					$this->email->subject('Runpolictics.com  Invitation');
					$this->email->message($message);
					// send
					$this->email->send();
				}
			}
			
			// Show view
			redirect("/event/create_event_two/$event_id", 'location');
			
		}
		
	}

	/**
	 * A custom validation callback that is used for the validation of the email field.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function validation_email_duplication_check($str){
		if(!$str){
			$this->validation->set_message('validation_email_duplication_check', 'The field "Speaker Email Address" requires a value.');
			return FALSE;
		}elseif ( $this->user->userExists(array('user_email' => $str)) ){
			$this->validation->set_message('validation_email_duplication_check', 'The email address "'.$_POST['user_email'].'" is already in use.');
			return FALSE;
		}else{
			return TRUE;
		}
	}
		
	/**
	 * Using the provided search_string it searches the user db for like names.  This is used during the creation of an event, when the user adds new speakers.
	 *
	 * I broke a cardinal rule by adding html, but it was just so little html.  If desired, it can be changed to using a view.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function user_name_from_search_ajax(){
		$users = $this->user->FuzzySearch("display_name", $_POST['display_name']);
		$st = '<ul>';
		foreach($users as $user){
			$st .= '<li id="'.$user['user_id'].'">'.$user['display_name'].'</li>';
		}
		$st .= '</ul>';
		echo($st);
	}
		
	/**
	 * Gets the events for the ride sidebar and returns the HTML (TODO: this does not follow good MVC implementation patterns)
	 *
	 * @return (html)
	 * @author Clark Endrizzi
	 **/
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
	
	/**
	 * Changes the status of an event.  
	 *
	 *  There are three different event state modes.  These modes are controlled by two different fields for each event:  event_finished and streaming.
	 *  Before live: (streaming and event_finished are false)
	 *  Live: (streamins is true, event_finsished is false)
	 *  Finished (streamiing is hopefully false, event_finished is true)
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
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
	
	/**
	 * Used to display the admin panel.  This provides all pertinent administration functions for dealing with events (or whatever else they are named)
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function admin_panel($event_id, $tab="1"){
		// Check for permissions
		
		// Show page
		$data['event_id'] = $event_id;
		$data['breadcrumb'] = array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(),$this->cms->get_cms_text('', "forums_name")=>'event/', $data['page_title']  => "");
		if($tab == 2){
			$data['event_id'] = $event_id;
			$data['users'] = $this->user->GetUsersInEvent($event_id);
			for($i = 0; $i < count($data['users']); $i++){
				$data['users'][$i] = $this->user->get_user( $data['users'][$i]['fk_user_id'] );
			}
		}elseif($tab == 4){
			
		}else{
			$data = $this->event->get_event($event_id);
		}
		$data['tab'] = $tab;
		$this->load->view('event/admin_panel',$data);
	}
	
	/**
	 * Used in conjuction with the admin_panel function (above).  This provides the ajax support so that each section is dynamically loaded when a tab is clicked on
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function admin_panel_tab_ajax($event_id, $tab){
		// Check for permissions
		
		// return info
		if($tab == 2){
			$data['event_id'] = $event_id;
			$data['users'] = $this->user->GetUsersInEvent($event_id);
			for($i = 0; $i < count($data['users']); $i++){
				$data['users'][$i] = $this->user->get_user( $data['users'][$i]['fk_user_id'] );
			}
		}elseif($tab == 4){
			
		}else{
			$data = $this->event->get_event($event_id);
		}
		$this->load->view('event/admin_panel_tab_'.$tab ,$data);
	}
	
	/**
	 * Shows detailed information on a user (used when someone is adding a new user)
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function show_user_info_ajax($user_id){
		// return info
		$data = $this->user->get_user($user_id);
		$this->load->view('user/ajax_view_user_info', $data);
	}
}