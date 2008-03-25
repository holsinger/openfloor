<?php
class Forums extends Controller 
{
	private $ajax = false;
	private $global = false;
	
	private $_cp_section_size = 10;
	
	function __construct()
	{
		parent::Controller();
		// models
		$this->load->model('candidate_model', 'candidate');
		$this->load->model('event_model','event');
		$this->load->model('comments_model','comments');
		$this->load->model('flag_model','flag');
		$this->load->model('question_model','question');
		$this->load->model('tag_model', 'tag');
		$this->load->model('video_model', 'video');
		$this->load->model('vote_model','vote');
		$this->load->model('reaction_model','reaction');
		$this->load->model('cms_model','cms');
		$this->load->model('participant_model','participant');
		
		// libraries
		$this->load->library('flag_lib');
		$this->load->library('pagination');
		$this->load->library('tag_lib');
		$this->load->library('time_lib');
		$this->load->library('validation');
		$this->load->library('wordcloud');
		
		// helpers
		$this->load->helper('form');
		$this->load->helper('url');
		
		$this->load->scaffolding('cn_questions');
	}
	
	/**
	 * Goes directly back to the view events page.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	function index () 
	{
		redirect('event/');
		ob_clean();
		exit();
	}
	

	public function liveQueue($event, $ajax=null)
	{
		$data['event'] = $event;
		
		$event_id = $this->event->get_id_from_url($event);
		if(!$event_id) exit();
		$this->question->event_id = $event_id;
		
		// get the list of upcoming (pending) questions
		$data['questions'] = $this->question->questionQueue();
		
		// get the current question, if any
		$this->question->question_status = 'current';
		$data['current_question'] = $this->question->questionQueue();
		
		// generate current question timer JavaScript
		$data['timerHTML'] = $this->createTimerHTML($event);
		
		// if an AJAX request is being made
		if(isset($ajax))
		{
			switch($ajax)
			{
			case 'current_question':
				if(!empty($data['current_question']))
					echo '<p>' . $data['current_question'][0]['question_name'] . '</p>';
				else
					echo 'There is no current question';
				break;
			case 'upcoming_questions':
				foreach($data['questions'] as $question) {
					//$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ;
					echo '
						<div class="queue-question">
							<span class="votes"><span class="inner_container">'.$question['votes'].'</span></span>
							<span class="question">'.$question['question_name'].'</span>
						</div>
						<br />';
				}
				break;
			default:
				break;
			}
		} else { // if no AJAX request is being made, load the view
			$this->load->view('event/live_queue', $data);
		}
	}
	
	/**
	 * This is the controller for the dashboard that candidates watch during an event
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function candidateQueue($event_name, $ajax = false){
		$data['event_name'] = $event_name;
		$event_id = $this->event->get_id_from_url($event_name);
		if(!$event_id) exit();
		
		// get questions, first upcoming and then current
		$this->question->event_id = $event_id;
		$data['questions'] = $this->question->questionQueue();
		$this->question->question_status = 'current';
		$data['current_question'] = $this->question->questionQueue();
		
		// Get the comments for the current question, build the html since it's used on intial display and ajax display.  Should be changed later to use views
		$comments = $this->comments->getCommentsByQuestion($data['current_question'][0]["question_id"]);
		$data['comment_html'].='<span class="comments_title">Comments</span>';
		foreach($comments AS $comment){
			$data['comment_html'].="<div class=\"comment\">{$comment['comment']} - {$comment['user_name']}</div>";
			$sub_comments = $this->comments->getChildrenByComment($comment['comment_id']);
			foreach($sub_comments AS $sub_comment){
				$data['comment_html'].="<div class=\"sub_comment\">{$sub_comment['comment']} - {$sub_comment['user_name']}</div>";
			}
		}
		
		// if an AJAX request is being made
		if($ajax){
			if($ajax == "current_question"){
				if($data['current_question'][0]['question_name']){
					echo '<p>'.$data['current_question'][0]['question_name']."</p>{$data['comment_html']}";
				}else{
					echo "<p>There is not a current question</p>";
				}
				
			}else{
				$count=1;
				foreach($data['questions'] as $question) {
					//$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ;
					echo '
					<div class="queue-question">
						<span class="question">'.$question['question_name'].'</span>
					</div>
					<br />';
					if($count <3){
						$count++;
					}else{
						break;
					}
				}
			}
			
		} else { // if no AJAX request is being made, load the view
			$this->load->view('event/CandidateQueue.php', $data);
		}		
	}
	
	// I think this function below is depricated - CTE
	public function watch_answer($id)
	{
		$close_button = "<div class=\"close_watch_window\" onClick=\"popup_instance_$id.destroy()\"></div>";
		$this->question->question_id = $id;
		echo $close_button . $this->question->get('question_answer');		
	}
	
	/**
	 * This is the most important function.  Shows the forums.
	 *
	 * @return void
	 * @author Clark Endrizzi, Rob S (started it, structure still follows it a bit)
	 **/
	public function cp($event, $ajax = null, $option_1 = null, $option_2 = null)
	{
		$data['rightpods'] = 'suppress';	// Make it so the right column won't show up
		
		//use url or id to get event data
		if (is_numeric($event)) {
			$data['event_id'] = $event;
			$data["event_data"] = $this->event->get_event($data['event_id']);
			$data['event'] = $data["event_data"]['event_url_name'];
		} else {
			$data['event'] = $event;
			$data['event_id'] = $this->event->get_id_from_url($event);
			$data["event_data"] = $this->event->get_event($data['event_id']);
		} 
		if(!$data['event_id']) exit();		
		
		
		// The respondent format and where we can figure out 
		$data['user_id'] = $this->userauth->user_id;
		$data['is_respondent'] = false;
		$temp_participants = $this->event->getCansInEvent($data['event_id']);
		$temp_count = 0;
		foreach($temp_participants as $v){
			$data['event_data']['participants'] .= $this->candidate->linkToProfile($v);
			if($temp_count < (count($temp_participants) - 1) ){
				$data['event_data']['participants'] .= ', ';
			}
			$temp_count++;
			// Check to see if this user is a respondent
			if($v == $data['user_id']){
				$data['is_respondent'] = true;
			}
		}

		$this->event->id = $data['event_id'];
		if($data['event_data']["event_finished"]){
			$data['post_event_stream_high'] = $data['event_data']['post_event_stream_high'] ? $data['event_data']['post_event_stream_high'] : '<p><b>The footage for this past event is not yet available.<br /><br />Please check back at a later time.</b></p>';
		}else{
			$data['stream_high'] = $this->event->streaming() ? $this->event->get('stream_high') : '<p><b>This event is not live yet.</p><b>You will need to refresh your browser when<br/>the event starts for the feed to activate.</b></p>';
		}
		
		$this->question->event_id = $data['event_id'];		
		// ==========
		// = output =
		// ==========
		if(isset($ajax)) // AJAX
		{
			switch($ajax)
			{
			case 'upcoming_questions':
				if(isset($option_1)) $data['sort'] = $option_1;
				if(isset($option_2)) $data['section'] = $option_2;
				$this->_upcomingQuestions($data);
				$this->load->view('user/_cp_question_pod.php', $data);
				break;
			case 'reaction':
				$this->_currentQuestion($data);
				$this->_allReactions($data);
				$this->load->view('user/_cp_js_update', $data);
				break;
			case 'your_reaction':
				$this->_currentQuestion($data);
				$data['user_id'] = $option_1;
				$this->_yourReaction($data);
				$this->load->view('user/_userReactSlider.php', $data);
				break;
			case 'upcoming_questions_count':
				if(isset($option_1)) $data['sort'] = $option_1;
				echo $this->_upcoming_questions_count($data);
				break;
			default:
				show_error('Invalid AJAX argument.');
				break;
			}
		} else { // NO AJAX
			$this->_currentQuestion($data);
			$this->_allReactions($data);
			$this->_submitQuestion($data);
			
			$data['breadcrumb'] = $this->global ? array($this->cms->get_cms_text('', "home_name") => $this->config->site_url()) : array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(), $this->cms->get_cms_text('', "forums_name")=>'event/',$data["event_data"]['event_name']=>'');
			$this->load->view('event/main', $data);
		}		
	}
	
	/**
	 * This is a widget version of the queue
	 * This is the most important function.  Shows the forums.
	 *
	 * @return void
	 * @author Clark Endrizzi, Rob S (started it, structure still follows it a bit) Widgetized by James Kleinschnitz
	 **/
	public function widget($event, $ajax = null, $option_1 = null, $option_2 = null)
	{
		$data['rightpods'] = 'suppress';	// Make it so the right column won't show up
		$data['event'] = $event;
		$data['event_id'] = $this->event->get_id_from_url($event);
		if(!$data['event_id']) exit();
		
		//get captcha for account creation
		$data['capimage'] = $this->createCaptcha();
		
		$data["event_data"] = $this->event->get_event($data['event_id']);
		
		// The respondent format and where we can figure out 
		$data['user_id'] = $this->userauth->user_id;
		$data['is_respondent'] = false;
		$temp_participants = $this->event->getCansInEvent($data['event_id']);
		$temp_count = 0;
		foreach($temp_participants as $v){
			$data['event_data']['participants'] .= $this->candidate->linkToProfile($v);
			if($temp_count < (count($temp_participants) - 1) ){
				$data['event_data']['participants'] .= ', ';
			}
			$temp_count++;
			// Check to see if this user is a respondent
			if($v == $data['user_id']){
				$data['is_respondent'] = true;
			}
		}

		$this->event->id = $data['event_id'];
		if($data['event_data']["event_finished"]){
			$data['post_event_stream_high'] = $data['event_data']['post_event_stream_high'] ? $data['event_data']['post_event_stream_high'] : '<p><b>The footage for this past event is not yet available.<br /><br />Please check back at a later time.</b></p>';
		}else{
			$data['stream_high'] = $this->event->streaming() ? $this->event->get('stream_high') : '<p><b>This event is not live yet.</p><b>You will need to refresh your browser when<br/>the event starts for the feed to activate.</b></p>';
		}
		
		$this->question->event_id = $data['event_id'];		
		// ==========
		// = output =
		// ==========
		if(isset($ajax)) // AJAX
		{
			switch($ajax)
			{
			case 'upcoming_questions':
				if(isset($option_1)) $data['sort'] = $option_1;
				if(isset($option_2)) $data['section'] = $option_2;
				$this->_upcomingQuestions($data);
				$this->load->view('user/_cp_question_pod.php', $data);
				break;
			case 'reaction':
				$this->_currentQuestion($data);
				$this->_allReactions($data);
				$this->load->view('user/_cp_js_update', $data);
				break;
			case 'your_reaction':
				$this->_currentQuestion($data);
				$data['user_id'] = $option_1;
				$this->_yourReaction($data);
				$this->load->view('user/_userReactSlider.php', $data);
				break;
			case 'upcoming_questions_count':
				if(isset($option_1)) $data['sort'] = $option_1;
				echo $this->_upcoming_questions_count($data);
				break;
			default:
				show_error('Invalid AJAX argument.');
				break;
			}
		} else { // NO AJAX
			$this->_currentQuestion($data);
			$this->_allReactions($data);
			$this->_submitQuestion($data);
			
			$data['breadcrumb'] = $this->global ? array($this->cms->get_cms_text('', "home_name") => $this->config->site_url()) : array($this->cms->get_cms_text('', "home_name")=>$this->config->site_url(), $this->cms->get_cms_text('', "forums_name")=>'event/',$data["event_data"]['event_name']=>'');
			$this->load->view('event/widget', $data);
		}		
	}
	
	function createCaptcha () {
		//build captch
		$this->load->plugin('captcha');
		$vals = array(
						'img_path'	 => './captcha/',
						'img_url'	 => 'captcha/'
					);
		
		$cap = create_captcha($vals);
	
		$image = array(
						'captcha_id'	=> '',
						'captcha_time'	=> $cap['time'],
						'ip_address'	=> $this->input->ip_address(),
						'word'			=> $cap['word']
					);
	
		$query = $this->db->insert_string('captcha', $image);
		$this->db->query($query);
	
		//add image to data
		return $cap['image'];
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
	public function ajax_change_event_status($event_id, $status){
		switch ($status) {
			case "stream":
		    	echo $this->event->UpdateField($event_id, "streaming", "1");
				// Move event status forward
				$respondent = $this->user->GetCurrentRespondentInEvent($event_id);
				if(!count($respondent)){
					$this->move_queue("forward", $event_id);
				}
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
	 * Gets information for a question to be viewed on the information tab of a question.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function get_question_info($question_id)
	{
		$data = $this->question->get_question($question_id);
		$image_array = unserialize($data['user_avatar']);
		$data['avatar_path'] = $image_array ? $image_array['file_name'] : 'image01.jpg';
		$data['time_diff'] = $this->time_lib->getDecay($data['timestamp']);
		$data['user_info'] = $this->user->get_user($data['fk_user_id']);
		$this->load->view('event/ajax_question_info', $data);
	}
	
	/**
	 * Returns the percentage for the overall reaction (aggregate reaction) to be used in the progress bar like indicator
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function ajax_get_respondent_info($event_name, $speaker_id)
	{
		$event_id = $this->event->get_id_from_url($event_name);
		$this->question->event_id = $event_id;
		
		$this->_currentQuestion($data);
		$data['speaker_id'] = $speaker_id;
		$this->_overallReaction($data);
		// Respondants
		$status = $this->user->GetRespondent($event_id, $speaker_id);
		$return_array['reaction'] = $data['overall_reaction'];
		$return_array['selected'] = $status[0]['current_responder'];
		$return_array['status'] = $status[0]['status'];
		
		echo(json_encode($return_array));
	}
	
	/**
	 * Used for getting the current question
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function ajax_get_current_question($event_name, $mode = "")
	{
		$event_id = $this->event->get_id_from_url($event_name);
		$this->question->event_id = $event_id;
		$this->_currentQuestion($data);
		
		if($mode == 'pod'){
			$data['current_question_flag'] = true;
			$data['event_id'] = $event_id;
			$this->load->view('user/_cp_question_pod.php', $data);
		}else{
			if(count($data['questions'])){
				echo($data['questions'][0]['question_id']);
			}else{
				echo('none');
			}
				
		}
	}

	/**
	 * Returns the percentage for the overall reaction (aggregate reaction) to be used in the progress bar like indicator
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function ajax_get_slider_info($event_name, $new_question_id)
	{		
		$event_id = $this->event->get_id_from_url($event_name);
		$this->reaction->question_id 	= $new_question_id;
		$this->reaction->user_id		= $this->userauth->user_id;
	
		$data['respondents'] = $this->event->getCansInEvent($event_id, true);
		$data['new_question_id'] = $new_question_id;
		$count = 0;
		foreach($data['respondents'] as $k => $v) {
			$data['respondents'][$count]['slider_value'] = $this->reaction->canUserReaction($v['user_id']);
			$count++;
		}
		$this->load->view('event/ajax_slider_update.php', $data);
	}
	
	/**
	 * Used when a user is participating.  It will ping the application to let us know they are still there.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function ajax_user_ping($event_id, $user_id)
	{
		$record = $this->participant->GetParticipantInEvent($user_id, $event_id);
		// Check if user record exists, if so then update, if not then create a new one (and update after)
		if(count($record) == 0){
			$record['fk_user_id'] = $user_id;
			$record['fk_event_id'] = $event_id;
			$record['timestamp'] = date('Y-m-d H:i:s');
			$this->participant->InsertParticipant($record);
		}else{
			$data['timestamp'] = date('Y-m-d H:i:s');
			$this->participant->UpdateParticipant($record[0]['id'], $data);
		}
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function ajax_question_answered_rating($event_id, $respondent_id)
	{
		$result_array = $this->participant->GetActiveParticipantsForEvent($event_id);
		echo($result_array[0]['count']);
	}
	
	/**
	 * This is used by the respondent to check when different respondent dialogs should be shown.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function ajax_respondent_status($event_id, $respondent_id, $view = false)
	{
		$return_array = $this->user->GetRespondent($event_id, $respondent_id);
		$this->question->event_id = $event_id;
		$this->_currentQuestion($data);
		if(!$view){
			$this->question->event_id = $event_id;
			$json_array['current_responder'] = $return_array[0]['current_responder'];
			$json_array['current_id'] = $data['questions'][0]['question_id'];
			if($return_array[0]['status'] == 'responding'){
				$json_array['unanswered_percent'] = (100 - ($this->vote->RespondentUnansweredCount($return_array[0]['id'], $data['questions'][0]['question_id']) / $this->participant->GetActiveParticipantsForEvent($event_id) * 100)); 
			}			
			echo json_encode($json_array);
		}else{
			$data['respondent'] = $return_array[0];
			$data['event_id'] = $event_id;
			$data['respondent_id'] = $respondent_id;
			$data['unanswered_percent'] = (100 - ($this->vote->RespondentUnansweredCount($return_array[0]['id'], $data['questions'][0]['question_id']) / $this->participant->GetActiveParticipantsForEvent($event_id) * 100));
			$this->load->view('event/ajax_respondent_status.php', $data);
		}
	}
	
	/**
	 * Called by the respondent to change their response.  IE, when they want to start responding to a question, etc.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function ajax_response_change($event_id, $user_id, $action)
	{
		$respondent = $this->user->GetRespondent($event_id, $user_id);
		if($action == 'start'){
			$data['status'] = 'responding';
			$this->user->UpdateUserEventAssociation($respondent[0]['id'], $data);
		}else{		// finish
			$data['status'] = '';
			$this->user->UpdateUserEventAssociation($respondent[0]['id'], $data);
			$this->move_queue("forward", $event_id);
		}
		
	}
	
	/**
	 * This is what gets called to provide the participant dialogs.  So to show the "Not Answered" Button, etc.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function ajax_participant($event_id)
	{
		$respondent = $this->user->GetCurrentRespondentInEvent($event_id);
		if(count($respondent)){
			$past_vote = $this->vote->ParticipantLastVote($this->userauth->user_id, $respondent[0]['id']);
			$data['past_vote'] = $past_vote->vote_value;
			$data['respondent'] = $respondent[0];
			$this->load->view('event/ajax_participant.php', $data);
		}
		
	}
	
	/**
	 * This function is what a participant uses to vote on a respondent (not answered)
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function ajax_participant_vote($event_id, $user_id, $type)
	{
		$this->vote->type = 'answer';
		$respondent = $this->user->GetCurrentRespondentInEvent($event_id);
		// Get Current Question
		$this->question->event_id = $event_id;
		$this->_currentQuestion($data);
		
		$this->vote->type = "answer";
		echo($data['questions'][0]['question_id']);
		if($type == "up"){
			$this->vote->voteup($user_id, $respondent[0]['id'], $data['questions'][0]['question_id']);
		}else{
			$this->vote->votedown($user_id, $respondent[0]['id'], $data['questions'][0]['question_id']);
		}
		
	}
	
	public function overall_reaction($event, $ajax = null, $speaker_id = null)
	{
		// ========
		// = init =
		// ========
		$data['event'] = $event;
		
		$data['event_id'] = $this->event->get_id_from_url($event);
		if(!$data['event_id']) exit();
		
		$this->event->id = $data['event_id'];
		$data['stream_high'] = $this->event->get('stream_high');
		
		$this->question->event_id = $data['event_id'];		
		
		// ==========
		// = output =
		// ==========
		if(isset($ajax)) // AJAX
		{
			$this->_currentQuestion($data);
			$data['speaker_id'] = $speaker_id;
			$this->_overallReaction($data);
			$this->load->view('user/_overallReaction.php', $data);				
		} else { // NO AJAX
			$this->userauth->check();
			$this->_currentQuestion($data);
			if(empty($data['current_question'])) exit('This event has no current question.');
			$this->_overallReactions($data);
			$this->load->view('admin/overall_reactions', $data);
		}		
	}
	
	public function react($value, $can_id, $question_id)
	{
		$this->reaction->react($value, $can_id, $question_id, $this->userauth->user_id);
	}
	
	public function ajQueueUpdater($event_name, $sort, $offset, $tag='')
	{
		if(!empty($tag)) $tag = "tag/$tag/";
		if($event_name == 'none')
			redirect("forums/queue/{$tag}ajax/true");
		else
			redirect("/forums/queue/{$tag}event/$event_name/sort/$sort/ajax/true/$offset");
	}
	
	public function queue()
	{
		//get data from url
		$uri_array = $this->uri->uri_to_assoc(3);
		if (isset($uri_array['ajax'])) $this->ajax = true;
		if (!isset($uri_array['event']) && isset($uri_array['tag'])) {
			$this->global = true;
			$this->questionQueue($uri_array, null);
			return;
		}
		elseif (!isset($uri_array['event'])) $this->index();

		$event_id = $this->event->get_id_from_url($uri_array['event']);
		if ( $this->event->get_event_type($event_id) == 'question') $this->questionQueue($uri_array,$event_id);
		if ( $this->event->get_event_type($event_id) == 'video') $this->videoQueue($uri_array,$event_id); 
	}
		
	public function questionQueue ($uri_array,$event_id) 
	{
		if(!isset($event_id) && !$this->global) redirect();
		if($this->ajax) $data['ajax'] = true;
		$data['event_type'] = 'question';
		$data['global'] = $this->global;
		
		$this->load->model('Question_model','question2'); // why are we loading it like this?
		$data['rss'] = array();
		
		// event information
		if(!$this->global) {
			$this->question2->event_id = $event_id; 
			$data['event_name'] = $uri_array['event'];
			$data['event_info'] = $this->event->get_event("", $data['event_name']);
		}
		
		// question information
		if (isset($uri_array['question'])) {
			$this->question2->question_id = $this->question->get_id_from_url($uri_array['question']);			
			// flag this request as question specific
			$data['question_view'] = true;			
		}
		
		// user information
		if (isset($uri_array['user']))
			$this->question2->user_id = $this->user->get_id_from_name($uri_array['user']); 
			
		// tag information
		if (isset($uri_array['tag'])) {
			$this->question2->tag_id = $this->tag->get_id_from_tag($uri_array['tag']);
			$data['tag'] = $uri_array['tag'];
			$data['rss'][] = array(	'title' => 'Questions Tagged With \'' . ucfirst($data['tag']) . '\'', 
									'href' => site_url("feed/tag/{$data['tag']}"));
		}
		
		// prepare sorting information
		$this->prepareSort($data);		

		$data['breadcrumb'] = $this->global ? array($this->cms->get_cms_text('', "home_name") => $this->config->site_url(), $this->cms->get_cms_text('', "forums_name") => 'event/') : array($this->cms->get_cms_text('', "home_name") => $this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$uri_array['event']))=>'');
		
		// Load the question queue from the model
		$data['results'] = $this->question2->questionQueue();
		
		if(empty($data['results'])) {
			$event = $this->event->get_event($event_id);

			$data['rightpods'] = $this->global ? array() : array(	'dynamic'=>array('event_details'=>$this->createDescriptionHTML($data) . $this->createParticipantsHTML($event_id), 
										'event_location'=>$data['results'][0]['location']));

			// set vars
			$data['view_name'] = 'view_queue';
			$data['offset'] = 0;
			$data['pagination'] = '';
			// load view and exit
			$this->load->view('view_queue',$data);
			return;													
		}		
		
		// prepare pagination data
		$this->preparePagination($data);
		
		// prepare queue data for display
		$this->prepareQueue($data);		
				
		// tag cloud
		$data['cloud'] = $this->tag_lib->createTagCloud($event_id);
		
		// question tags
		$this->tag_lib->createTagLinks($data['results']);
		
		// load the view
		$data['view_name'] = 'view_queue';
		$this->load->view('view_queue',$data);	
	}		
	
	public function create($what)
	{
		#TODO redirect to some kind of 'unauthorized' page
		if(!$this->userauth->isAdmin()) redirect();
		
		switch($what)
		{
		case 'candidate':
			$this->adminCandidate('create');
			break;
		default:
			exit();
			break;
		}
	}
	
	public function view($what, $name)
	{
		switch($what)
		{
		case 'candidate':
			$this->viewCandidate($name);
			break;
		default:
			exit();
			break;
		}
	}
	
	public function edit($what, $name)
	{
		switch($what)
		{
		case 'candidate':
			#TODO redirect to some kind of 'unauthorized' page
			$this->adminCandidate('edit', $name);
			//if($this->userauth->isAdmin() || ($this->userauth->user_name == $name)) $this->adminCandidate('edit', $name);
			//else redirect();
			break;
		case 'bio':
			$this->editCandidateBio($name);
			break;
		default:
			exit();
			break;
		}
	}
	
	/**
	 * Used through ajax for the ADMIN TAB.  This both shows and updates.  If $option is set to 
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function EditQuestion($question_id, $event_id, $option){
		// If update then it's called from ajax and needs not show anything
		if($option == 'update'){
			// Clear out the answer if it's pending
			if($_POST['question_status'] == 'pending'){
				$_POST['question_answer'] = '';
			}
			// If the question is changed to current then be sure to clear out existing current question and set to "asked"
			if($_POST['question_status'] == 'current'){
				$old_current_question = $this->question->singleCurrent($event_id, $question_id);
				if($old_current_question && $old_current_question != $question_id){
					$this->question->set_asked_time($old_current_question);
				}
			}
			// Update and return response based on whether it worked
			$changed = $this->question->updateQuestion($question_id, $_POST);
			if($changed > 0){
				$json['question_id'] = $question_id;
				$json['event_id'] = $event_id;
				echo(json_encode($json));
			}else{
				echo("0");
			}
		// Do this on intial page load
		}else{
			$data['question'] = $this->question->get_question($question_id);
			$data['event_id'] = $event_id;
			$data['alert'] = $alert;
			$this->load->view('question/edit_question',$data);
		}
		
	}
	
	/**
	* delete question via onClick tab
	*
	*@return void
	*@author James Kleinschnitz
	**/
	public function DeleteQuestion($question_id) {
		$delete_array = array();
		$delete_array['question_status']='deleted';
		$delete_array['flag_reason']='other';
		$delete_array['flag_reason_other']='admin deleted';
						
		$changed = $this->question->updateQuestion($question_id, $delete_array);
		if($changed > 0){
			$json['question_id'] = $question_id;
			$json['event_id'] = $event_id;
			echo(json_encode($json));
		}else{
			echo("0");
		}
	}
	
	/**
	 * Changes to the next question based on the votes
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function next_question($event_id)
	{
		// First get the next question
		$question_id = $this->question->get_next_question($event_id);
		// Then set the old current to asked
		$old_current_question = $this->question->singleCurrent($event_id, $question_id);
		$this->question->set_asked_time($old_current_question);
		// Update the next question to the current question
		$data_array['question_status'] = "current";
		$changed = $this->question->updateQuestion($question_id, $data_array);
		echo($changed);
	}

	/**
	 * Moves queue in desired direction.  This happens by moving through each respondent for each question, then changing to this next question and vise versa.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function move_queue($direction, $event_id)
	{
		if($direction == 'forward'){
			//Get Current question
			$respondents = $this->user->GetUsersInEvent($event_id);
			// This may be not as efficient as doing an array search, etc - CTE
			$no_current_respondent = true;
			for($i = 0; $i < count($respondents); $i++){
				
				if($respondents[$i]['current_responder']){
					$no_current_respondent = false;
					// Now we need to figure out if we just need to got to the next responder or switch questions
					if(($i + 1) == count($respondents)){	// Change questions
						// Get the next questions in the queue
						$next_question_id = $this->question->get_next_question($event_id);

						$old_current_question_id = $this->question->singleCurrent($event_id, $next_question_id);
						$this->question->set_asked_time($old_current_question_id);
						
						$data_array['question_status'] = "current";
						$changed = $this->question->updateQuestion($next_question_id, $data_array);
						// Select the first respondant since it resets upons getting a new question
						$data['current_responder'] = '0';
						$data['status'] = '';
						$this->user->UpdateUserEventAssociation($respondents[$i]['id'], $data);
						
						$data['current_responder'] = '1';
						$this->user->UpdateUserEventAssociation($respondents[0]['id'], $data);
					}else{										// Shift focus to next responder
						// Update current record
						$data['current_responder'] = '0';
						$data['status'] = '';
						$this->user->UpdateUserEventAssociation($respondents[$i]['id'], $data);
						// Update new selected record
						$data['current_responder'] = '1';
						$this->user->UpdateUserEventAssociation($respondents[($i + 1)]['id'], $data);
						
					}
				}
				
				
			}
			if($no_current_respondent){
				error_log("No current respondent");
				// Get the next questions in the queue
				$next_question_id = $this->question->get_next_question($event_id);
				$data_array['question_status'] = "current";
				$changed = $this->question->updateQuestion($next_question_id, $data_array);
				// Select the first respondant since it resets upons getting a new question
				$data['current_responder'] = '1';
				$this->user->UpdateUserEventAssociation($respondents[0]['id'], $data);
			}
		}else{  // backward
			
		}
	}

	/**
	 * Used through ajax to the ANSWER TAB.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function ShowAnswer($question_id){
		$q_data = $this->question->get_question($question_id);
		
		echo('
			<div id="video_container" style="margin: 10px">
				'.$q_data['question_answer'].'
			</div>
		');
	}	
	
	private function adminCandidate($action, $name = null)
	{
		$data['error'] = '';
		$data['action'] = $action;
		
		if(isset($_POST['submitted']))
		{
			//$rules['can_name'] = "trim|required|max_length[45]|xss_clean|valid_email";
			$rules['can_display_name'] = "trim|max_length[100]|required";
			if(!($action == 'edit' && empty($_POST['can_password']))) {
				$rules['can_password'] = "trim|required|matches[can_password_confirm]|md5|xss_clean";
				$rules['can_password_confirm'] = "trim|required|xss_clean";
			}
			$rules['can_bio'] = "trim|max_length[65535]|xss_clean";
			$rules['can_email'] = "trim|max_length[75]";
			$this->validation->set_rules($rules);
			
			if (!$this->validation->run()) $data['error'] = $this->validation->error_string;
			
			if(!$data['error'])
			{
				switch($action)
				{
				case 'create':
					if($can_id = $this->candidate->addCandidate()) {
						$name = $this->user->user_name($this->createCandidateUser($can_id));
						
						redirect("user/profile/$name");						
					}
					break;
				case 'edit':
					if($this->candidate->editCandidate())
						redirect("user/profile/$name");
					break;
				default:
					exit();
					break;
				}
			}
		}
		
		$field_names = array(	//'can_name', 
								'can_display_name', 
								'can_password', 
								'can_password_confirm', 
								'can_bio', 
								'can_email');
		
		if($action == 'edit')
		{
			$data['name'] = $name;
			$can_id = $this->user->can_id($name);
			
			if(!$can_id) redirect();
			$candidate = $this->candidate->getCandidate($can_id);
			$_POST['can_id'] = $can_id;
			foreach($candidate as $k => $v)
				if(!empty($v)) $_POST[$k] = $v;
		}
		
		foreach($field_names as $v)
			$fields[$v] = isset($_POST[$v]) ? $_POST[$v] : '';
		$this->validation->set_fields($fields);
		
		$this->load->view('candidate/admin.php', $data);
	}

	private function createCandidateUser($can_id)
	{
		#TODO decide for good what to do with email & password
		$_POST['user_email'] = $_POST['can_email'];
		$_POST['user_password'] = $_POST['can_password'];
		$_POST['user_name'] = '_'.url_title($_POST['user_email']);
		
		$display_name = $_POST['can_display_name'];
		unset($_POST['can_email'], $_POST['can_password'], $_POST['can_display_name'], $_POST['can_bio']);
		$_POST['can_display_name'] = $display_name;
		
		$user_id = $this->user->insert_user_form($can_id);
		
		return $user_id;
	}
	
	public function candidate_dashboard($event_name, $ajax = null)
	{
		$event_id = $this->event->get_id_from_url($event_name);
		if(!$event_id) redirect();
		$this->question->event_id = $event_id;
		$this->question->question_status = 'current';
		$data['questions'] = $this->question->questionQueue();
		$data['timerHTML'] = $this->createTimerHTML($data['event_name'] = $event_name);
		
		$currentQuestionId = $data['questions'][0]['question_id'];
		$data['totalVotes'] 		= $this->vote->countVotes($currentQuestionId);
		$data['totalPositiveVotes']	= $this->vote->countPositiveVotes($currentQuestionId);
		$data['totalNegativeVotes'] = $this->vote->countNegativeVotes($currentQuestionId);
		
		if(isset($ajax)) $this->load->view('candidate/dashboard_content.php', $data);
		else $this->load->view('candidate/dashboard.php', $data);
	}
	
	public function restart_question_timer($event_name)
	{
		if(!$this->userauth->isAdmin()) redirect();
		$event_id = $this->event->get_id_from_url($event_name);
		if(!$event_id) redirect();		
		$this->event->restart_question_timer($event_id);
		redirect("forums/candidate_dashboard/$event_name");
	}
	
	// Why does these exist - CTE?
	public function stream_high($event) 
	{
		$this->videoFeed($event, 'high');
	}
	
	// Why does this exist - CTE?
	public function stream_low($event)
	{
		$this->videoFeed($event, 'low');
	}
	
	// Might be deprecated - CTE
	private function videoFeed($event, $stream)
	{
		$event = $this->event->get_event(null, $event);
		$event['date'] = date('m/d/Y g:i A', strtotime($event['event_date']));	
		if($event['streaming']) {
			$event['stream_html']['high'] = $event['stream_high'];
			$event['stream_html']['low'] = $event['stream_low'];
		} else 
			$event['stream_html']['high'] = $event['stream_html']['low'] = "There is no live stream for this event at the moment";
		$event['stream'] = $stream;
		
		$event['ip'] = $this->_getIP();
		$event['blocked_ips'] = explode(',', str_replace(' ', '', $event['blocked_ips']));
		if(in_array($event['ip'], $event['blocked_ips'])) $event['blocked'] = true;
		else $event['blocked'] = false;
		
		$this->load->view('view_feed',$event);
	}
	
	private function _getIP() 
	{
		$ip; 
	
		if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP"); 
		else if(getenv("HTTP_X_FORWARDED_FOR")) $ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if(getenv("REMOTE_ADDR")) $ip = getenv("REMOTE_ADDR"); 
		else $ip = "UNKNOWN"; 
	
		return $ip; 
	}

	private function prepareQueue(&$data)
	{
		$event_id = $this->global ? 0 : $this->event->get_id_from_url(url_title($data['event_name']));
		
		foreach ($data['results'] as $key => $row) {
			// if user is registered, find out if and how they voted
			if ($this->userauth->isUser()) {
				$this->vote->type='question';
				$score = $this->vote->votedScore($row['question_id'],$this->userauth->user_id);
				if ($score > 0) $data['results'][$key]['voted'] = 'up';
				else if ($score < 0) $data['results'][$key]['voted'] = 'down';
				else $data['results'][$key]['voted'] = false;
			} else 
				$data['results'][$key]['voted'] = false;
			
			// set user avatar
			$image_array = unserialize($data['results'][$key]['user_avatar']);
			if ($image_array) $data['results'][$key]['avatar_path'] = "./avatars/".$image_array['file_name'];
			else $data['results'][$key]['avatar_path'] = "./images/image01.jpg"; // default avatar	
			
			// get time decay
			$data['results'][$key]['time_diff'] = $this->time_lib->getDecay($data['results'][$key]['date']);
			
			// set display name
			$data['results'][$key]['display_name'] = $this->user->displayName($data['results'][$key]['user_name']);
		}
		
		// right pods
		$data['rightpods'] = $this->global ? array() : array(	'dynamic'=>array('event_details'=>$this->createDescriptionHTML($data) . $this->createParticipantsHTML($event_id), 
									'event_location'=>$data['results'][0]['location']));
	}

	private function preparePagination(&$data)
	{
		$segment_array = $this->uri->segment_array();
		if(is_numeric($segment_array[$this->uri->total_segments()]))
			array_pop($segment_array);				
		$base_url = implode('/', $segment_array);				

		$pagination_per_page = '5';			
		$offset = (is_numeric($this->uri->segment($this->uri->total_segments()))) ? $this->uri->segment($this->uri->total_segments()) : 0 ;		
							
		$total_rows = count($data['results']);
		$data['results'] = array_splice($data['results'], $offset, $pagination_per_page);		
		
		// pagination config
		$config['base_url'] = site_url($base_url);
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $pagination_per_page;
		$config['uri_segment'] = $this->uri->total_segments();
		
		// pagination style
		$config['first_link'] = '';
		$config['first_tag_open'] = '<li class="first"><span>';
		$config['first_tag_close'] = '</span</li>';
		
		$config['last_link'] = '';
		$config['last_tag_open'] = '<li class="last"><span>';
		$config['last_tag_close'] = '</span></li>';
		
		$config['next_link'] = '&gt';
		$config['next_tag_open'] = '<li class="next"><span>';
		$config['next_tag_close'] = '</span></li>';	
				
		$config['prev_link'] = '&lt';
		
		$config['prev_tag_open'] = '<li class="prev"><span>';
		$config['prev_tag_close'] = '</span></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current">';
		$config['cur_tag_close'] = '</li>';
		
		// Create pagination object
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['offset'] = $this->uri->segment($this->uri->total_segments());
		if(!is_numeric($data['offset'])) $data['offset'] = 0;
	}

	private function prepareSort(&$data)
	{
		$uri_array = $this->uri->uri_to_assoc(3);
		$type = ucfirst($data['event_type']);
		// default sort
		$sort_active = 'upcoming';
		$queue_title = 'Upcoming '. $type . 's'; // this does not appear to be implemented
		
		// override default sort if sort is specified
		if (isset($uri_array['sort']) )
		{
			// order by date
			if ( $uri_array['sort'] == 'newest')
			{
				$this->question2->order_by = 'date';
				$sort_active = 'newest';
				$queue_title = 'Newest '.$type.'s';
			}
			// limit to asked questions
			if ( $uri_array['sort'] == 'asked')
			{
				$this->question2->question_status = 'asked';
				$sort_active = 'asked';
				$queue_title = 'Asked '.$type.'s';
			}
			// limit to current question
			if ( $uri_array['sort'] == 'current')
			{
				$this->question2->question_status = 'current';
				$sort_active = 'current';
				$queue_title = 'Current '.$type;
			}
		}
		
		// set the sort
		$data['sort'] = $sort_active;
		
		// build the event_url
		$data['event_url'] = $this->global ? 'event-url' : $this->uri->assoc_to_uri(array('event'=>$uri_array['event']));			
		
		// initialize sort array (used to build sorting HTML)
		$sort_array = array('<strong>Sort '.$data['event_type'].'s by:</strong>');
		
		$sort_array_template = array('upcoming' => 'Upcoming', 'newest' => 'Newest', 'asked' => 'Asked', 'current' => 'Current');
		foreach($sort_array_template as $k => $v)
			$sort_active == $k ? array_push($sort_array, $v) : array_push($sort_array, anchor("forums/queue/{$data['event_url']}/sort/$k", $v)) ;
		
		$data['sort_array'] = $sort_array;
		
		// rebuild the event_url if needed
		if(isset($uri_array['sort'])) $data['event_url'] = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
		$data['queue_title'] = $queue_title;
	}

	public function createDescriptionHTML(&$data)
	{
		return '<div class="rightpod-item"><div class="header">Description</div><div class="content">' . $data['results'][0]['event_desc'] . '</div></div>';
	}
	
	public function createParticipantsHTML($event_id)
	{
		$return = '<div class="rightpod-item"><div class="header">Participants</div>';
		$candidates = $this->event->getCansInEvent($event_id);
		$return .= '<div class="content">';
		
		foreach($candidates as $v) $return .= '<a href="' . $this->candidate->linkToProfile($v, true) . '"><img style="border-style:none;" src="./avatars/'.$this->candidate->canAvatar($v).'"/></a>';
		$return .= '<p>';
		for($i = 0; $i < count($candidates); $i++) 
			if($i == count($candidates) - 1) $return .= ' and ' . $this->candidate->linkToProfile($candidates[$i]);
			else $return .= $this->candidate->linkToProfile($candidates[$i]) . ', ';
		
		return "$return (l to r).</p></div></div>";
	}
	
	public function createTimerHTML($event_name)
	{
		$event_id = $this->event->get_id_from_url($event_name);
		$lastResponse = $this->event->last_response($event_id);
		return <<<EOT
		<script language="JavaScript">
		//TargetDate = "08/22/2007 5:00 AM";
		TargetDate = "$lastResponse";
		BackColor = "#f0faff";
		ForeColor = "#EC2834";
		CountActive = true;
		CountStepper = 1;
		LeadingZero = true;
		DisplayFormat = "%%M%%:%%S%%";
		</script>
		<script language="JavaScript" src="javascript/timer.js"></script>
EOT;
	}

	// cp helper functions
	public function _upcoming_questions_count(&$data)
	{
		$this->question->question_status = isset($data['sort']) && $data['sort'] == 'asked' ? 'asked' : 'pending';
		return $this->question->count_upcoming_questions($data['event_id']);
	}
	
	private function _currentQuestion(&$data)
	{
		$this->question->question_status = 'current';
		$data['current_question'] = $this->question->questionQueue();
		
		$this->_questions($data);
		
		// set question model property back to default
		$this->question->question_status = 'pending';
	}
	
	/**
	 * Gets the upcoming questions, used above by the cp function (do we need it as a separate function?)
	 *
	 * @return void
	 * @author Rob Stef, Clark Endrizzi (cleaned up)
	 **/
	private function _upcomingQuestions(&$data)
	{
		if(isset($data['sort'])) {
			if($data['sort'] == 'newest'){
				$this->question->order_by = 'date';
			} else{
				$this->question->question_status = $data['sort'];
			} 
		}
		
		// determine section for lazy loader		
		if(isset($data['section'])){
			$this->question->offset = $this->_cp_section_size * $data['section'];		
		}
		$this->question->limit = $this->_cp_section_size;
		
		$this->_questions($data);
	}
	
	private function _questions(&$data)
	{
		$data['questions'] = $this->question->questionQueue();

		foreach ($data['questions'] as $key => $row) {
			// determine how user voted on this question
			if ($this->userauth->isUser()) {
				$this->vote->type='question';
				$data['questions'][$key]['voted'] = $this->vote->votedScore($row['question_id'],$this->userauth->user_id);
			} else { 
				$data['questions'][$key]['voted'] = 0; 
			}
			
			// user avatar
			$image_array = unserialize($data['questions'][$key]['user_avatar']);
			$data['questions'][$key]['avatar_path'] = $image_array ? $image_array['file_name'] : 'image01.jpg';
			
			// time decay
			$data['questions'][$key]['time_diff'] = $this->time_lib->getDecay($data['questions'][$key]['date']);
		}
		
		// get tag links
		$this->tag_lib->createTagLinks($data['questions'], url_title($data['questions'][$key]['event_name']));
		
		// if we're dealing with the current question, we need to save it in a different spot
		if($this->question->question_status = 'current') $data['current_question'] = $data['questions'];
	}
	
	private function _allReactions(&$data)
	{
		if(empty($data['current_question'])){
			$data['candidates'] = array();
		}else{
			$this->reaction->question_id 	= $data['current_question'][0]['question_id'];
			$this->reaction->user_id		= $this->userauth->user_id;
		}
		$data['candidates'] = $this->event->getCansInEvent($data['event_id'], true);
		
		foreach($data['candidates'] as $k => $v) {
			$data['candidates'][$k]['user_reaction'] = $this->reaction->canUserReaction($v['user_id']);
			$data['candidates'][$k]['overall_reaction'] = round(($this->reaction->overallReaction($v['user_id'])/10)*100, 0) . '%';
			$data['candidates'][$k]['link_to_profile'] = $this->candidate->linkToProfile($v['user_id'], false, true);
			$data['candidates'][$k]['avatar'] = '<a href="' . $this->candidate->linkToProfile($v['user_id'], true,true) . '"><img src="./avatars/shrink.php?img='.$this->candidate->canAvatar($v['user_id']).'&w=16&h=16"/></a>';
		}
		
	}
	
	private function _yourReaction(&$data)
	{
		$this->reaction->question_id 	= $data['current_question'][0]['question_id'];
		$this->reaction->user_id		= $this->userauth->user_id;
		$data['user_reaction'] = $this->reaction->canUserReaction($data['can_id']);
	}
	
	private function _overallReactions(&$data)
	{
		if(empty($data['current_question'])){
			$data['candidates'] = array();
		}else{
			$this->reaction->question_id 	= $data['current_question'][0]['question_id'];
			$this->reaction->user_id		= $this->userauth->user_id;
		}
		
		$data['candidates'] = $this->event->getCansInEvent($data['event_id'], true);
		foreach($data['candidates'] as $k => $v) {
			$data['candidates'][$k]['overall_reaction'] = round(($this->reaction->overallReaction($v['user_id'])/10)*100, 0) . '%';
		}
	}
	
	private function _overallReaction(&$data)
	{
		$this->reaction->question_id 	= $data['current_question'][0]['question_id'];
		$this->reaction->user_id		= $this->userauth->user_id;		
		$data['overall_reaction'] 		= round(($this->reaction->overallReaction($data['speaker_id'])/10)*100, 0).'%';
	}
	
	private function _submitQuestion(&$data)
	{
		#TODO fix disclaimer box
		$data['ajax'] = true;
		$data['event_type'] = 'question';
		$data['event_url'] = "event/{$data['event']}";
		
		$fields['event']	= ( isset($_POST['event']) ) ? $_POST['event']:"";
		$fields['question']	= ( isset($_POST['question']) ) ? $_POST['question']:"";
		$fields['desc']	= ( isset($_POST['desc']) ) ? $_POST['desc']:"";
		$fields['tags']	= ( isset($_POST['tags']) ) ? $_POST['tags']:"";
		$this->validation->set_fields($fields);
	}
}
?>