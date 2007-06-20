<?php
class Question extends Controller 
{
	function __construct()
	{
		parent::Controller();
		$this->load->model('CN_Model','question');
	}
	
	function index()
	{
		if(!empty($_POST['question']) && $_POST['event']!='0') 
		{			
			if($this->addQuestion()) $data['success'] = true;		
				
			$data['events'] = $this->populateEventsSelect();
			$this->load->view('view_submit_question', $data);
		} else {
			$data['events'] = $this->populateEventsSelect();
			$this->load->view('view_submit_question', $data);
		}
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
		
		$existingKs;
		$existingVs;
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
	
		return true;
	}

	function populateEventsSelect()
	{
		$events = $this->question->getEvents();
		
		$output='';
		foreach($events as $v) $output .= "<option value=\"{$v['event_id']}\">{$v['event_name']}</option>";
		return $output;
	}
}
?>