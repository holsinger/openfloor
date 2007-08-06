<?php
class Question extends Controller 
{
	function __construct()
	{
		parent::Controller();
		$this->load->model('Tag_model','tag');
		$this->load->model('Question_model','question');
		$this->load->model('Event_model','event');
		$this->load->model('Vote_model','vote');
		$this->load->library('validation');
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
		if (isset($uri_array['event'])) 
		{
			$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$uri_array['event']))=>"question/queue/{$data['event_url']}");
			$uri_array = $this->event->get_event(0,$uri_array['event']);
			$data['event_id'] = $uri_array['event_id'];
			$data['event_name'] = $uri_array['event_name'];
			$data['event_type'] = $uri_array['event_type'];  
		}
		else
		{
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
				//redirect to question view page
				redirect('conventionnext/queue/'.$_POST['event_url']);
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
		
		#$data['events'] = $this->populateEventsSelect();
		
		$this->load->view('view_submit_question', $data);
	}

	function addQuestion()
	{
		#check that user is allowed
		$this->userauth->check();
		
		$eventID = $_POST['event'];
		$userID = $this->session->userdata('user_id');
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
	
	function edit () 
	{
		$data['error'] = "";
		if (isset($_POST['question_id'])) 
		{
			$changed = $this->question->updateQuestion($_POST['question_id'],$_POST);
			if ($changed > 0)
			{
				$data['error'] = "{$changed} record(s) updated.";
			}
		}
		$question_id = $this->uri->segment(3);
		$question_data = $this->question->get_question ($question_id);
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
	
	function view ($event, $question) 
	{
		
		$question_id = $this->question->get_id_from_url($question);
		$this->question->question_id = $question_id;
		$result = $this->question->questionQueue();
		$data = $result[0];
		$data['event_type'] = 'question';
		$image_array = unserialize($data['user_avatar']);
		if ($image_array) $data['avatar_path'] = "./avatars/".$image_array['file_name'];
		else $data['avatar_path'] = "./images/image01.jpg";
		//exit(var_dump($data));	
		//get time diff
		$time_array = explode(', ', timespan(strtotime($data['date'])));
		$data['time_diff'] = $time_array[0];
		//get voted
		if ($this->session->userdata('user_id')>0) {
			$this->vote->type='question';
			$score = $this->vote->votedScore($data['question_id'],$this->session->userdata('user_id'));
			if ($score > 0) $data['voted'] = 'up';
			else if ($score < 0) $data['voted'] = 'down';
			else $data['voted'] = false;
		} else $data['voted'] = false;
		$this->load->library('comments_library');
		$comments_library = new Comments_library();
		$comments_library->type = $data['event_type'];
		$data['comments_body'] = $comments_library->createComments($result[0]);
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$data['event_name']))=>"conventionnext/queue/event/".url_title($data['event_name']));
		$data['rightpods'] = array('dynamic'=>array('event_description'=>$data['event_desc'],'event_location'=>$data['location']));
		$this->load->view('question/question_view.php', $data);
	}
	
	function queue()
	{
		
		//get data from url
		$uri_array = $this->uri->uri_to_assoc(3);
		if (!is_array($uri_array))
		{
			redirect('event/');
			ob_clean();
			exit();
		} 
		else 
		{
			$this->load->model('Question_model','question2');
			//set restrictions
			
			//event
			if (isset($uri_array['event']) && is_numeric($uri_array['event'])) // if an event id was passed
			{
				$this->question2->event_id = $uri_array['event'];
				$data['event_type'] = $this->event->get_event_type($uri_array['event']);
			}
			if (isset($uri_array['event']) && is_string($uri_array['event'])) // if an event name was passed 
			{
				$event_id = $this->question2->event_id = $this->event->get_id_from_url($uri_array['event']);
				$data['event_type'] = $this->event->get_event_type($event_id);
			}
			
			//question
			if (isset($uri_array['question'])) {
				if (is_numeric($uri_array['question'])) // change all is_numeric, is_string groups to if, elseif logic
					$this->question2->question_id = $uri_array['question'];
				elseif (is_string($uri_array['question']))
					$this->question2->question_id = $this->question->get_id_from_url($uri_array['question']);
					
				$data['question_view'] = true;
			}
			
			//user
			if (isset($uri_array['user']) && is_numeric($uri_array['user'])) 
				$this->question2->user_id = $uri_array['user'];
			if (isset($uri_array['user']) && is_string($uri_array['user'])) $
				$this->question2->user_id = $this->user->get_id_from_name($uri_array['user']); 
				
			//tag
			if (isset($uri_array['tag']) && is_numeric($uri_array['tag'])) $this->question2->tag_id = $uri_array['tag'];
			if (isset($uri_array['tag']) && is_string($uri_array['tag'])) $this->question2->tag_id = $this->tag->get_id_from_tag($uri_array['tag']);
			
			//set default sort link
			$type = ucfirst($data['event_type']);
			$sort_active = 'upcoming';
			$queue_title = 'Upcoming '.$type.'s';
			
			//create sorting options
			if (isset($uri_array['sort']) )
			{
				//order by date
				if ( $uri_array['sort'] == 'newest')
				{
					$this->question2->order_by = 'date';
					$sort_active = 'newest';
					$queue_title = 'Newest '.$type.'s';
				}
				//limit to asked questions
				if ( $uri_array['sort'] == 'asked')
				{
					$this->question2->question_status = 'asked';
					$sort_active = 'asked';
					$queue_title = 'Asked '.$type.'s';
				}
				//limit to current question
				if ( $uri_array['sort'] == 'current')
				{
					$this->question2->question_status = 'current';
					$sort_active = 'current';
					$queue_title = 'Current '.$type;
				}
			}
			
			$data['event_url'] = $this->uri->assoc_to_uri(array('event'=>$uri_array['event']));
			// retrieve the event_id so we can pull the right tags for the tag cloud
			// $event_id = $this->event->get_id_from_url($data['event_url']);
			//set a sorting array
			$sort_array = array('<strong>Sort '.$data['event_type'].'s by:</strong>');
			if ($data['event_type'] == 'video')
			{
				($sort_active == 'upcoming') ? array_push($sort_array,'Score'):array_push( $sort_array,anchor("question/queue/{$data['event_url']}",'Score') );
				($sort_active == 'newest') ? array_push($sort_array,'Newest'):array_push( $sort_array,anchor("question/queue/{$data['event_url']}/sort/newest",'Newest') );
			}
			else 
			{
				($sort_active == 'upcoming') ? array_push($sort_array,'Upcoming'):array_push( $sort_array,anchor("question/queue/{$data['event_url']}",'Upcoming') );
				($sort_active == 'newest') ? array_push($sort_array,'Newest'):array_push( $sort_array,anchor("question/queue/{$data['event_url']}/sort/newest",'Newest') );
				($sort_active == 'asked') ? array_push($sort_array,'Asked'):array_push( $sort_array,anchor("question/queue/{$data['event_url']}/sort/asked",'Asked') );
				($sort_active == 'current') ? array_push($sort_array,'Current'):array_push( $sort_array,anchor("question/queue/{$data['event_url']}/sort/current",'Current') );
			} 
			$data['sort_array'] = $sort_array;
			//var_dump($sort_array);

			if ( isset($uri_array['sort']) ) $data['event_url'] = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
			$data['queue_title'] = $queue_title;
			$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$uri_array['event']))=>"question/queue/{$data['event_url']}");
			
			// pagination
			if(isset($event_id))
			{		
				$segment_array = $this->uri->segment_array();
				if(is_numeric($segment_array[$this->uri->total_segments()]))
					array_pop($segment_array);				
				$base_url = implode('/', $segment_array);				

				$pagination_per_page = '10';			
				// $this->question2->limit = $pagination_per_page;
				// 			
				// 				if(is_numeric($this->uri->segment($this->uri->total_segments())))
				// 					$this->question2->offset = $this->uri->segment($this->uri->total_segments());
				$offset = (is_numeric($this->uri->segment($this->uri->total_segments())))?$this->uri->segment($this->uri->total_segments()):0;
				

				$data['results'] = $this->question2->questionQueue();
				$total_rows = count($data['results']);
				$data['results'] = array_splice($data['results'], $offset, $pagination_per_page);
				
				

			
				$this->load->library('pagination');
				$config['base_url'] = site_url($base_url);
				$config['total_rows'] = $total_rows;//$this->question2->numQuestions($event_id);
				$config['per_page'] = $pagination_per_page;
				$config['uri_segment'] = $this->uri->total_segments();
				$this->pagination->initialize($config);
				
			}
			
			//set user score			
			foreach ($data['results'] as $key => $row) {
				if ($this->userauth->isUser()) {
					$score = $this->vote->votedScore($row['question_id'],$this->session->userdata('user_id'));
					if ($score > 0) $data['results'][$key]['voted'] = 'up';
					else if ($score < 0) $data['results'][$key]['voted'] = 'down';
				} else $data['results'][$key]['voted'] = false;
			}
			
			// tag cloud - this section might need a little tweaking
			if (isset($event_id) && !empty($data['results'])) {
				$this->load->model('tag_model');
				$this->load->library('wordcloud');
				$words = $this->tag_model->getAllReferencedTags($event_id);

				$cloud = new wordCloud($words);
				$cloud_array = $cloud->showCloud('array');
				
				$segment_array = $this->uri->segment_array();
				if(is_numeric($segment_array[count($segment_array)]))
					array_pop($segment_array);
				$class = array_shift($segment_array);
				$function = array_shift($segment_array);
				if ($segment_array[0] == 'tag')
					array_splice($segment_array, 0, 2);
				$args = '/'.implode('/', $segment_array);
				
				$cloud_string = '';
				foreach ($cloud_array as $value)
			    	$cloud_string .= " <a href=\"index.php/$class/$function/tag/{$value['word']}$args\" class=\"size{$value['sizeRange']}\">{$value['word']}</a> &nbsp;";
				$data['cloud'] = $cloud_string;
			}			
			log_message('debug', 'Question::queue complete, now loading view_queue');
			$this->load->view('view_queue',$data);	
		}		
		
	}
	
	function voteup($question_id = 0)
	{
		$this->userauth->check();
		//get question id
		$uri_array = $this->uri->uri_to_assoc(3);
		if (isset($uri_array['question']) && is_numeric($uri_array['question'])) $id = $uri_array['question'];
		if (isset($uri_array['question']) && is_string($uri_array['question'])) $id = $this->question->get_id_from_url($uri_array['question']);	
		$id = ($question_id > 0) ? $question_id:$id;

		
		$event_url = $this->uri->assoc_to_uri(array('event'=>$uri_array['event']));
		if (isset($uri_array['sort'])) $event_url = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
		#check that has not voted
		if($this->vote->alreadyVoted($id, $this->session->userdata('user_id'))) {
			redirect('conventionnext/queue/'.$event_url);
		 	ob_clean();
		 	exit();
		}
		
		#TODO validation and trending need to be considered		
		$this->vote->voteup($this->session->userdata('user_id'), $id);
		//$this->queue();
		
		// redirect('question/queue/'.$event_url);
		// 		ob_clean();
		// 		exit();
	}
	
	function votedown($question_id = 0)
	{
		$this->userauth->check();
		//get question id
		$uri_array = $this->uri->uri_to_assoc(3);
		echo '<pre>'; print_r($uri_array); echo '</pre>';
		if (isset($uri_array['question']) && is_numeric($uri_array['question'])) $id = $uri_array['question'];
		if (isset($uri_array['question']) && is_string($uri_array['question'])) $id = $this->question->get_id_from_url($uri_array['question']);
			
		$id = ($question_id > 0) ? $question_id:$id;
		
		$event_url = $this->uri->assoc_to_uri(array('event'=>$uri_array['event']));
		if (isset($uri_array['sort'])) $event_url = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
		
		#check that user has not voted
		if(!$this->userauth->check() || $this->vote->alreadyVoted($id, $this->session->userdata('user_id'))) {
			redirect('conventionnext/queue/'.$event_url);
			ob_clean();
			exit();
		}
		
		#TODO validation and trending need to be considered
		$this->vote->votedown($this->session->userdata('user_id'), $id);
		//$this->queue();
		// redirect('question/queue/'.$event_url);
		// 		ob_clean();
		// 		exit();
	}
}
?>