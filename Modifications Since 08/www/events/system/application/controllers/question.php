<?php
class Question extends Controller 
{
	function __construct()
	{
		parent::Controller();
		$this->load->model('Tag_model','tag');
		$this->load->library('wordcloud');
		$this->load->model('Question_model','question');
		$this->load->model('Event_model','event');
		$this->load->model('Vote_model','vote');
		$this->load->model('flag_model','flag');
		$this->load->library('validation');
		$this->load->library('time_lib');
		$this->load->library('tag_lib');
		$this->load->library('flag_lib');
		$this->load->helper('url');//for redirect
		$this->load->helper('form');

		$this->load->scaffolding('cn_questions');
	}
	
	function index () {
		$this->add();
	}
	
	function add()
	{
		#check that user is allowed
		$this->userauth->check();
		
		//make sure there is an event id
		//get the event id
		$uri_array = $this->uri->uri_to_assoc(3);		
		$data['event_url'] = $this->uri->assoc_to_uri(array('event'=>$uri_array['event']));
		if (isset($uri_array['sort'])) $data['event_url'] = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
		//event
		if (isset($uri_array['event'])) {
			$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$uri_array['event']))=>"forums/queue/{$data['event_url']}");
			$uri_array = $this->event->get_event(0,$uri_array['event']);
			$data['event_id'] = $uri_array['event_id'];
			$data['event_name'] = $uri_array['event_name'];
			$data['event_type'] = $uri_array['event_type'];  
		}else{
			$data['event_id'] = 0;
			$data['event_name'] = '';
		}

		$data['error'] = '';
		#FORM VALIDATE
		if (isset($_POST['event']) && $_POST['event']=='0') $data['error'] .= 'Please select an Event.<br />';

		$rules['event'] = "required";
		$rules['question'] = "trim|required|min_length[10]|max_length[150]|xss_clean";
		$rules['desc'] = "trim|max_length[255]|xss_clean";
		$rules['tags'] = "trim|strtolower|xss_clean";
		
		$this->validation->set_rules($rules);
				
		if ($this->validation->run() == FALSE) {
			$data['error'] .= $this->validation->error_string;
		} else {
			$questionID = $this->addQuestion();
			if( is_numeric($questionID) ) {
				$this->voteup($questionID);
				if(isset($_POST['ajax'])) {
					echo 'success'; exit();
				} else {
					//redirect to question view page
					redirect('forums/queue/'.$_POST['event_url']);
					ob_clean();
					exit();					
				}				
			} else {
				$data['error'] = 'Error Adding Question';
			}
		}
		
		//this makes the info sticky 
		$fields['event']	= ( isset($_POST['event']) ) ? $_POST['event']:"";
		$fields['question']	= ( isset($_POST['question']) ) ? $_POST['question']:"";
		$fields['desc']	= ( isset($_POST['desc']) ) ? $_POST['desc']:"";
		$fields['tags']	= ( isset($_POST['tags']) ) ? $_POST['tags']:"";
		if(isset($_POST['ajax'])) foreach($fields as $k => $v) $fields[$k] = '';
		$this->validation->set_fields($fields);
		
		#$data['events'] = $this->populateEventsSelect();
		if(isset($_POST['ajax'])) {
			$data['ajax'] = true;
			$this->load->view('question/_submit_question_form', $data);
		}
		else $this->load->view('question/submit_question', $data);
	}
	
	function addQuestion()
	{
		#check that user is allowed
		$this->userauth->check();
		
		$eventID = $_POST['event'];
		$userID = $this->userauth->user_id;
		$questionName = $_POST['question'];
		$questionDesc = $_POST['desc'];
		$tags = $_POST['tags'];		
		
		/* deal with tags first */
		$tags = str_replace(array(/*' ', */"\t", '.', ','), '', $tags);
		//make sure we have some tags
		if (!empty($tags)) {
			$tagsExist = true;
			$a = explode(' ',$tags);
			$tags = array();
			foreach($a as $v) if(!empty($v)) $tags[] = $v;

			$query = $this->tag->getTagsInSet($tags);

			$existingKs = array();
			$existingVs = array();
			foreach($query->result_array() as $row)
			{
				$existingKs[] = $row['tag_id'];
				$existingVs[] = $row['value'];
			}

			$diff = array_diff($tags, $existingVs);

			$newKs = array();
			if(!empty($diff)) foreach($diff as $v) if($k=$this->tag->insertTag($v)) $newKs[] = $k;

			$newKs = array_merge($newKs, $existingKs);
		}
		
		
		/* insert the question*/
		$questionID = $this->question->insertQuestion($questionName, $questionDesc, $userID, $eventID,url_title($questionName));
			
		/* insert proper associations */
		if(isset($tagsExist)) if(isset($questionID)) foreach($newKs as $v) $this->tag->insertTagAssociation($questionID,0, $v, $userID);
	
		return $questionID;
	}
	
	function edit() 
	{
		$data['error'] = "";
		$oldCurrent = 0;
		if (isset($_POST['question_id'])) 
		{
			// Change status, changed is returned how many rows were affected
			$changed = $this->question->updateQuestion($_POST['question_id'], $_POST);
			// If changed to current, we have to be sure that there are no other current questions.
			// if there is a current, then change to 'asked' since this question now replaces it
			if ($_POST['question_status'] == 'current') {
				$question_id =$_POST['question_id'];
				$event_id = $this->event->get_id_from_url($_POST['event_url_name']);
				$oldCurrent = $this->question->singleCurrent($event_id, $question_id);
			}
			if ($changed > 0)
			{
				$array = $this->question->get_question($_POST['question_id']);
				$data['error'] = "{$array['question_name']} changed to '{$_POST['question_status']}'";
			}
		}
		if($oldCurrent > 0 && $oldCurrent != $_POST['question_id']) {
			$question_id = $oldCurrent;
			$array = $this->question->get_question($question_id);
			$this->question->set_asked_time($question_id);
			$data['error'] .= "<br />{$array['question_name']} changed to 'Asked'";
		} else {
			$question_id = $this->uri->segment(3);
		}
		$question_data = $this->question->get_question($question_id);
		$event_data = $this->event->get_event ($question_data['fk_event_id']);
		$data['event'] = $event_data;
		
		$options = array(
				'pending' => 'Pending',
				'current' => 'Current',
				'asked' => 'Asked',
				'deleted'  => 'Delete'
				);
		$data['dropdown'] = form_dropdown('question_status', $options, $question_data['question_status']);
		$data['question'] = $question_data;
		$this->load->view('view_edit_question',$data);		
	}

	function populateEventsSelect()
	{
		$events = $this->event->getEvents();
		
		$output='';
		foreach($events as $v) $output .= "<option value=\"{$v['event_id']}\" ". $this->validation->set_select('event', $v['event_id']) .">{$v['event_name']}</option>";
		return $output;
	}
	
	function view ($event, $question, $sort = 'date') 
	{
		// how to sort comments
		switch ($sort) {
			case 'votes':
				$sort = 'votes';
				break;
			default:
				$sort = 'date';
				break;
		}
		$event_id = $this->event->get_id_from_url($event);
		if(!$event_id) redirect();
		$this->question->event_id = $event_id;
		
		$question_id = $this->question->get_id_from_url($question);
		$this->question->question_status = null;
		$this->question->question_id = $question_id;
		$result = $this->question->questionQueue();
		
		$data = $result[0];
		$data['event_type'] = 'question';
		
		$image_array = unserialize($data['user_avatar']);
		if ($image_array) $data['avatar_path'] = "./avatars/".$image_array['file_name'];
		else $data['avatar_path'] = "./images/image01.jpg";
		
		// set display name
		$data['display_name'] = $this->user->displayName($data['user_name']);
		
		//get time diff
		$data['time_diff'] = $this->time_lib->getDecay($data['date']);		
		
		//tags
		if(!empty($data['tags'])) foreach($data['tags'] as $k1=>$tag) $data['tags'][$k1] = anchor("forums/queue/event/".url_title($data['event_name'])."/tag/".$tag,$tag);
					
		//get voted
		if ($this->userauth->isUser()) {
			$this->vote->type='question';
			$score = $this->vote->votedScore($data['question_id'],$this->userauth->user_id);
			if ($score > 0) $data['voted'] = 'up';
			else if ($score < 0) $data['voted'] = 'down';
			else $data['voted'] = false;
		} else $data['voted'] = false;
		
		$this->load->library('comments_library');
		$comments_library = new Comments_library();
		$comments_library->ajax = isset($_POST['ajax']);
		$comments_library->sort = $sort;
		$comments_library->custom_theme = (strlen($this->config->item('custom_theme'))>1) ? $this->config->item('custom_theme').'/':'';
		$comments_library->type = $data['event_type'];
		$data['comments_body'] = $comments_library->createComments($result[0]);
		
		// If ajax then use different view, otherwise setup breadtrail and all
		if(isset($_POST['ajax'])) { 
			$data['ajax'] = true;
			$this->load->view('question/_comments', $data); 
		}else{
			$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$data['event_name']))=>"forums/queue/event/".url_title($data['event_name']));
			$data['rightpods'] = array('dynamic'=>array('event_description'=>$data['event_desc'],'event_location'=>$data['location']));

			$data['view_name'] = 'question_view';
			$this->load->view('question/question_view.php', $data);
		}
		
	}
	
	function voteup($question_id = 0)
	{
		$this->vote($question_id, true);
	}
	
	function votedown($question_id = 0)
	{
		$this->vote($question_id, false);
	}
	
	private function vote($question_id, $upOrDown)
	{
		$this->userauth->check();
		
		//get question id
		$uri_array = $this->uri->uri_to_assoc(3);
		
		// get event id
		$event_id = $this->event->get_id_from_url($uri_array['event']);
		if(!$event_id) return;
		$this->question->event_id = $event_id;
		
		if (isset($uri_array['question']) && is_numeric($uri_array['question'])) $id = $uri_array['question'];
		if (isset($uri_array['question']) && is_string($uri_array['question'])) $id = $this->question->get_id_from_url($uri_array['question']);
		$id = ($question_id > 0) ? $question_id:$id;
		
		$event_url = $this->uri->assoc_to_uri(array('event'=>$uri_array['event']));
		if (isset($uri_array['sort'])) $event_url = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
		
		#check that user has not voted
		// if(!$this->userauth->check() || $this->vote->alreadyVoted($id, $this->userauth->user_id))
		// 	$this->vote->deleteVote($id, $this->userauth->user_id);
		
		#TODO validation and trending need to be considered
		if($upOrDown) $this->vote->voteup($this->userauth->user_id, $id);
		else $this->vote->votedown($this->userauth->user_id, $id);
	}

	public function change_to_current($event_id, $question_id)
	{
		$this->question->change_to_current($event_id, $question_id);
	}
	
    public function answer_rate($question_id,$event_url_name){
		$answers = $this->question->get_answers($question_id);
//    	print_r($answers);
//    	die();
		
    	foreach ($_POST as $k => $rate){
    		foreach ($answers as $v => $answer){
    			if ('rate_' . $answer['fk_user_id'] == $k && !empty($rate)){
    				if (!$this->question->have_rated($this->userauth->user_id,$answer['answer_id']))
		    			$this->question->insert_answer_rate(array('fk_answer_id' => $answer['answer_id'], 'fk_user_id' => $this->userauth->user_id, 'rate' => $rate));
		    		else 
			    		$this->question->update_answer_rate(array('fk_answer_id' => $answer['answer_id'], 'fk_user_id' => $this->userauth->user_id, 'rate' => $rate));
    			}
    		}
    	}
    	$this->_calculate_answer_rate($answers);
    	redirect('forums/cp/' . $event_url_name);
    }
    
    private function _calculate_answer_rate($answers){
    	$rates = array();
    	foreach ($answers as $k => $answer)
    	{
	    	$rates = $this->question->get_rates($answer['answer_id']);
	    	$count = 0;
	    	$promoters = 0;
	    	$detractors = 0;
	    	foreach ($rates as $v => $rate)
	    	{
	    		$count++;
	    		if ($rate['rate'] >=0 && $rate['rate'] <= 6) $detractors++;
	    		elseif ($rate['rate'] >= 9) $promoters++;
	    	}
    		$feedback = (($promoters - $detractors) / $count) * 100;
    		$this->question->save_rate($answer['answer_id'], $feedback);  
    	}
    }
}
?>