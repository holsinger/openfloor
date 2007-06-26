<?php
class Question extends Controller 
{
	function __construct()
	{
		parent::Controller();
		$this->load->model('Tag_model','tag');
		$this->load->model('Question_model','question');
		$this->load->model('Event_model','event');
		$this->load->library('validation');
		$this->load->helper('url');//for redirect
	}
	
	function index()
	{				
		$data['error'] = '';
		#FORM VALIDATE
		if (isset($_POST['event']) && $_POST['event']=='0') $data['error'] .= 'Please select an Event.<br />';

		$rules['event'] = "required";
		$rules['question'] = "trim|required|min_length[10]|max_length[150]|xss_clean";
		$rules['desc'] = "trim|required|max_length[250]|xss_clean";
		$rules['tags'] = "trim|strtolower|xss_clean";
		
		$this->validation->set_rules($rules);
				
		if ($this->validation->run() == FALSE) {
			$data['error'] .= $this->validation->error_string;
		} else {
			$questionID = $this->addQuestion();
			if( is_numeric($questionID) ) {
				//redirect to question view page
				redirect('question/queue');
				ob_clean();
				exit();
			} else {
				$data['error'] = 'Error Adding Question';
			}
		}
		
		//this makes the info sticky 
		$fields['event']	= ( isset($_POST['event']) ) ? $_POST['event']:"";
		$fields['question']	= ( isset($_POST['question']) ) ? $_POST['question']:"";
		$fields['desc']	= ( isset($_POST['desc']) ) ? $_POST['desc']:"";
		$fields['tags']	= ( isset($_POST['tags']) ) ? $_POST['tags']:"";
		$this->validation->set_fields($fields);
		
		$data['events'] = $this->populateEventsSelect();
		$this->load->view('view_submit_question', $data);
	}

	function addQuestion()
	{
		$eventID = $_POST['event'];
		$userID = $this->session->userdata('user_id');
		$questionName = $_POST['question'];
		$questionDesc = $_POST['desc'];
		$tags = $_POST['tags'];		
		
		/* deal with tags first */
		$tags = str_replace(array(' ', "\t"), '', $tags);
		//make sure we have some tags
		if (!empty($tags)) {
			$tagsExist = true;
			$a = explode(',',$tags);
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
		$questionID = $this->question->insertQuestion($questionName, $questionDesc, $userID, $eventID);
			
		/* insert proper associations */
		if(isset($tagsExist)) if(isset($questionID)) foreach($newKs as $v) $this->tag->insertTagAssociation($questionID, $v, $userID);
	
		return $questionID;
	}

	function populateEventsSelect()
	{
		$events = $this->event->getEvents();
		
		$output='';
		foreach($events as $v) $output .= "<option value=\"{$v['event_id']}\" ". $this->validation->set_select('event', $v['event_id']) .">{$v['event_name']}</option>";
		return $output;
	}
	
	function view () {
		echo $this->uri->segment(3);
	}
	
	function queue()
	{
		$this->load->model('Question_model','question2');
		//set restrictions
		$data['results'] = $this->question2->questionQue();
		$this->load->view('view_queue',$data);
	}
	
	function voteup()
	{
		#TODO validation and trending need to be considered
		#TODO move db to a voting controller
		$id = $this->uri->segment(3);
		$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_question_id) VALUES (10, 1, $id)");
		$this->queue();
	}
	
	function votedown()
	{
		#TODO validation and trending need to be considered
		#TODO move db to a voting controller
		$id = $this->uri->segment(3);
		$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_question_id) VALUES (-10, 1, $id)");
		$this->queue();
	}
}
?>