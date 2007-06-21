<?php
class Question extends Controller 
{
	function __construct()
	{
		parent::Controller();
		$this->load->model('CN_Model','question');
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
				redirect('question/view/'.$questionID);
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
		$userID = 1;
		$questionName = $_POST['question'];
		$questionDesc = $_POST['desc'];
		$tags = $_POST['tags'];		
		
		/* deal with tags first */
		$tags = str_replace(array(' ', "\t"), '', $tags);
		$a = explode(',',$tags);
		$tags = array();
		foreach($a as $v) if(!empty($v)) $tags[] = $v;
		
		$query = $this->question->getTagsInSet($tags);
		
		$existingKs = array();
		$existingVs = array();
		foreach($query->result_array() as $row)
		{
			$existingKs[] = $row['tag_id'];
			$existingVs[] = $row['value'];
		}
		
		$diff = array_diff($tags, $existingVs);
		
		$newKs = array();
		if(!empty($diff)) foreach($diff as $v) if($k=$this->question->insertTag($v)) $newKs[] = $k;
		
		$newKs = array_merge($newKs, $existingKs);
		
		/* insert the question*/
		$questionID = $this->question->insertQuestion($questionName, $questionDesc, $userID, $eventID);
			
		/* insert proper associations */
		if(isset($questionID)) foreach($newKs as $v) $this->question->insertTagAssociation($questionID, $v, $userID);
	
		return $questionID;
	}

	function populateEventsSelect()
	{
		$events = $this->question->getEvents();
		
		$output='';
		foreach($events as $v) $output .= "<option value=\"{$v['event_id']}\" ". $this->validation->set_select('event', $v['event_id']) .">{$v['event_name']}</option>";
		return $output;
	}
	
	function view () {
		echo $this->uri->segment(3);
	}
	
	function queue()
	{
		$query = $this->db->query('SELECT question_id, (SELECT format(sum(vote_value)/10,0) AS number FROM cn_votes WHERE fk_question_id=question_id GROUP BY fk_question_id) as votes, question_name, question_desc, user_name, event_name FROM cn_questions, cn_events, cn_users WHERE fk_user_id=user_id AND fk_event_id=event_id ORDER BY votes DESC');
		$data['results'] = $query->result_array();
		$this->load->view('queue_view',$data);
	}
	
	function voteup()
	{
		$id = $this->uri->segment(3);
		$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_question_id) VALUES (10, 1, $id)");
		$this->queue();
	}
	
	function votedown()
	{
		$id = $this->uri->segment(3);
		$this->db->query("INSERT INTO cn_votes (vote_value, fk_user_id, fk_question_id) VALUES (-10, 1, $id)");
		$this->queue();
	}
}
?>