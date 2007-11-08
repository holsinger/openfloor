<?php
class Forums extends Controller 
{
	private $ajax = false;
	private $global = false;
	
	function __construct()
	{
		parent::Controller();
		// models
		$this->load->model('candidate_model', 'candidate');
		$this->load->model('event_model','event');
		$this->load->model('flag_model','flag');
		$this->load->model('question_model','question');
		$this->load->model('tag_model', 'tag');
		$this->load->model('video_model', 'video');
		$this->load->model('vote_model','vote');
		$this->load->model('reaction_model','reaction');
		
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
	
	function index () 
	{
		redirect('event/');
		ob_clean();
		exit();
	}
	
	public function liveQueue($event = 'presidential_debate', $ajax=null)
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
						$votes = ($question['votes'] == 1) ? 'vote ' : 'votes' ;
						echo "<div class='queue-question'><span class=\"votes\"><p>{$question['votes']} $votes<p></span>";
						echo "<span class=\"question\">{$question['question_name']}</span></div><br />";
				}
				break;
			default:
				break;
			}
		} else { // if no AJAX request is being made, load the view
			$this->load->view('view_live_queue', $data);
		}
	}
	
	public function watch_answer($id)
	{
		$this->question->question_id = $id;
		echo $this->question->get('question_answer');		
	}
	
	public function cp($event = 'presidential_debate', $ajax = null, $can_id = null)
	{
		#TODO Handle no candidates assigned?
		
		// ========
		// = init =
		// ========
		$this->userauth->check();
		$data['event'] = $event;
		
		
		$data['event_id'] = $this->event->get_id_from_url($event);
		if(!$data['event_id']) exit();

		$this->event->id = $data['event_id'];
		$data['stream_high'] = $this->event->streaming() ? $this->event->get('stream_high') : '<p><b>This event is not live yet.</p><b>You will need to refresh your browser when<br/>the event starts for the feed to activate.</b></p>';
		
		$this->question->event_id = $data['event_id'];
		// ==========
		// = output =
		// ==========
		if(isset($ajax)) // AJAX
		{
			switch($ajax)
			{
			case 'current_question':
				$this->_currentQuestion($data);
				$this->load->view('user/cp_current_question.php', $data);
				break;
			case 'upcoming_questions':
				if(isset($can_id)) $data['sort'] = $can_id;
				$this->_upcomingQuestions($data);
				$this->load->view('user/cp_upcoming_questions.php', $data);
				break;
			case 'reaction':
				$this->_currentQuestion($data);
				$this->_allReactions($data);
				$this->load->view('user/_cp_js_update', $data);
				break;
			case 'your_reaction':
				$this->_currentQuestion($data);
				$data['can_id'] = $can_id;
				$this->_yourReaction($data);
				$this->load->view('user/_userReactSlider.php', $data);
				break;
			case 'overall_reaction':
				$this->_currentQuestion($data);
				$data['can_id'] = $can_id;
				$this->_overallReaction($data);
				$this->load->view('user/_overallReaction.php', $data);
				break;
			default:
				break;
			}
		} else { // NO AJAX
			$this->_upcomingQuestions($data);		
			$this->_currentQuestion($data);
			$this->_allReactions($data);
			$this->_submitQuestion($data);
			
			#TODO This solution for no candidates assigned to event is not ideal
			if(empty($data['candidates'])) redirect();
			$this->load->view('user/cp', $data);
		}		
	}
	
	public function overall_reaction($event = 'presidential_debate', $ajax = null, $can_id = null)
	{
		// ========
		// = init =
		// ========
		$this->userauth->check();
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
			$data['can_id'] = $can_id;
			$this->_overallReaction($data);
			$this->load->view('user/_overallReaction.php', $data);				
		} else { // NO AJAX
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

		$data['breadcrumb'] = $this->global ? array('Home' => $this->config->site_url()) : array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$uri_array['event']))=>'');
		
		// Load the question queue from the model
		$data['results'] = $this->question2->questionQueue();
		
		if(empty($data['results'])) {
			$event = $this->event->get_event($event_id);
			// $data['rightpods'] = array(	'dynamic'	=>	array(	'event_description'	=>	$event['event_desc'],
			// 													'event_location'	=>	$event['location']));

			$data['rightpods'] = "suppress";

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
	
	public function videoQueue ($uri_array,$event_id) 
	{
		if($this->ajax) $data['ajax'] = true;
		$data['event_type'] = 'video';
		
		$this->load->model('Video_model','video2');
		//event
		$this->video2->event_id = $event_id;		
		$data['event_name'] = $uri_array['event'];
		//video
		if (isset($uri_array['video'])) {
			if (is_numeric($uri_array['video'])) // change all is_numeric, is_string groups to if, elseif logic
				$this->video2->video_id = $uri_array['video'];
			elseif (is_string($uri_array['video']))
				$this->video2->video_id = $this->video->get_id_from_url($uri_array['video']);
				
			$data['video_view'] = true;
		}
		
		//user
		if (isset($uri_array['user']) && is_numeric($uri_array['user'])) 
			$this->video2->user_id = $uri_array['user'];
		if (isset($uri_array['user']) && is_string($uri_array['user'])) 
			$this->video2->user_id = $this->user->get_id_from_name($uri_array['user']); 
			
		//tag
		if (isset($uri_array['tag']) && is_numeric($uri_array['tag'])) $this->video2->tag_id = $uri_array['tag'];
		if (isset($uri_array['tag']) && is_string($uri_array['tag'])) {
			$this->video2->tag_id = $this->tag->get_id_from_tag($uri_array['tag']);
			$data['tag'] = $uri_array['tag'];
		}
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
				$this->video2->order_by = 'date';
				$sort_active = 'newest';
				$queue_title = 'Newest '.$type.'s';
			}
			//limit to asked videos
			if ( $uri_array['sort'] == 'asked')
			{
				$this->video2->video_status = 'asked';
				$sort_active = 'asked';
				$queue_title = 'Asked '.$type.'s';
			}
			//limit to current video
			if ( $uri_array['sort'] == 'current')
			{
				$this->video2->video_status = 'current';
				$sort_active = 'current';
				$queue_title = 'Current '.$type;
			}
		}
		$data['sort'] = $sort_active;
		
		$data['event_url'] = $this->uri->assoc_to_uri(array('event'=>$uri_array['event']));			
		//set a sorting array
		$sort_array = array('<strong>Sort '.$data['event_type'].'s by:</strong>');		
		($sort_active == 'upcoming') ? array_push($sort_array,'Score'):array_push( $sort_array,anchor("forums/queue/{$data['event_url']}",'Score') );
		($sort_active == 'newest') ? array_push($sort_array,'Newest'):array_push( $sort_array,anchor("forums/queue/{$data['event_url']}/sort/newest",'Newest') ); 
		
		$data['sort_array'] = $sort_array;
		//var_dump($sort_array);

		if ( isset($uri_array['sort']) ) $data['event_url'] = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
		$data['queue_title'] = $queue_title;
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$uri_array['event']))=>"forums/queue/{$data['event_url']}");
		
		// pagination
		if(isset($event_id))
		{		
			$segment_array = $this->uri->segment_array();
			if(is_numeric($segment_array[$this->uri->total_segments()]))
				array_pop($segment_array);				
			$base_url = implode('/', $segment_array);				

			$pagination_per_page = '5';			
			// $this->video2->limit = $pagination_per_page;
			// 			
			// 				if(is_numeric($this->uri->segment($this->uri->total_segments())))
			// 					$this->video2->offset = $this->uri->segment($this->uri->total_segments());
			$offset = (is_numeric($this->uri->segment($this->uri->total_segments())))?$this->uri->segment($this->uri->total_segments()):0;
		
			$data['results'] = $this->video2->videoQueue();
			$total_rows = count($data['results']);
			$data['results'] = array_splice($data['results'], $offset, $pagination_per_page);
		
			$this->load->library('pagination');
			$config['base_url'] = site_url($base_url);
			$config['total_rows'] = $total_rows;
			$config['per_page'] = $pagination_per_page;
			$config['uri_segment'] = $this->uri->total_segments();//add some style
			$config['first_link'] = '';
			$config['last_link'] = '';
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
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
			$data['offset'] = $this->uri->segment($this->uri->total_segments());
			if(!is_numeric($data['offset'])) $data['offset'] = 0;
		}
		
		//set user score			
		foreach ($data['results'] as $key => $row) {
			if ($this->userauth->isUser()) {
				$this->vote->type='video';
				$score = $this->vote->votedScore($row['video_id'],$this->userauth->user_id);
				if ($score > 0) $data['results'][$key]['voted'] = 'up';
				else if ($score < 0) $data['results'][$key]['voted'] = 'down';
				else $data['results'][$key]['voted'] = false;
			} else $data['results'][$key]['voted'] = false;
		}
		
		// tag cloud - this section might need a little tweaking
		if (isset($event_id) && !empty($data['results'])) {
			$this->load->model('tag_model');
			$this->load->library('wordcloud');
			$this->tag_model->type = 'video';
			$words = $this->tag_model->getAllReferencedTags($event_id);
			if(!empty($words)) {
				$cloud = new wordCloud($words);
				$cloud_array = $cloud->showCloud('array');
				$this->load->library('tag_lib');
				$data['cloud'] = $this->tag_lib->createTagLink($cloud_array);
				// create tag links for all tags in queue
				foreach($data['results'] as $k1=>$question) 
					foreach($question['tags'] as $k2=>$tag) 
						$data['results'][$k1]['tags'][$k2]=$this->tag_lib->createTagLink($tag);		
			}
		}
		
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
	
	public function candidate_dashboard($event_name =  'salt_lake_city_mayoral_forum', $ajax = null)
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
	
	public function stream_high($event) 
	{
		$this->videoFeed($event, 'high');
	}
	
	public function stream_low($event)
	{
		$this->videoFeed($event, 'low');
	}
	
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
		$data['rightpods'] = "suppress";
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
		$config['last_link'] = '';
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
	private function _currentQuestion(&$data)
	{
		$this->question->question_status = 'current';
		$data['current_question'] = $this->question->questionQueue();
		foreach ($data['current_question'] as $key => $row) {
			if ($this->userauth->isUser()) {
				$this->vote->type='question';
				$data['current_question'][$key]['voted'] = $this->vote->votedScore($row['question_id'],$this->userauth->user_id);
			} else { 
				$data['current_question'][$key]['voted'] = 0; 
			}
		}
	}
	
	private function _upcomingQuestions(&$data)
	{
		if(isset($data['sort'])) {
			if($data['sort'] == 'newest') $this->question->order_by = 'date';
			else $this->question->question_status = $data['sort'];
		}	
		$this->question->limit = 10;
		$data['questions'] = $this->question->questionQueue();
		foreach ($data['questions'] as $key => $row) {
			if ($this->userauth->isUser()) {
				$this->vote->type='question';
				$data['questions'][$key]['voted'] = $this->vote->votedScore($row['question_id'],$this->userauth->user_id);
			} else { 
				$data['questions'][$key]['voted'] = 0; 
			}
		}
	}
	
	private function _allReactions(&$data)
	{
		if(empty($data['current_question'])) $data['candidates'] = array();
		else{
			$this->reaction->question_id 	= $data['current_question'][0]['question_id'];
			$this->reaction->user_id		= $this->userauth->user_id;
		}
		$data['candidates'] = $this->event->getCansInEvent($data['event_id'], true);
		foreach($data['candidates'] as $k => $v) {
			$data['candidates'][$k]['user_reaction'] = $this->reaction->canUserReaction($v['can_id']);
			$data['candidates'][$k]['overall_reaction'] = round(($this->reaction->overallReaction($v['can_id'])/10)*100, 0) . '%';
			$data['candidates'][$k]['link_to_profile'] = $this->candidate->linkToProfile($v['can_id'], false, true);
			$data['candidates'][$k]['avatar'] = '<a href="' . $this->candidate->linkToProfile($v['can_id'], true) . '"><img src="./avatars/shrink.php?img='.$this->candidate->canAvatar($v['can_id']).'&w=16&h=16"/></a>';
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
		if(empty($data['current_question'])) $data['candidates'] = array();
		else{
			$this->reaction->question_id 	= $data['current_question'][0]['question_id'];
			$this->reaction->user_id		= $this->userauth->user_id;
		}
		$data['candidates'] = $this->event->getCansInEvent($data['event_id'], true);
		foreach($data['candidates'] as $k => $v) {
			$data['candidates'][$k]['overall_reaction'] = round(($this->reaction->overallReaction($v['can_id'])/10)*100, 0) . '%';
		}
	}
	
	private function _overallReaction(&$data)
	{
		$this->reaction->question_id 	= $data['current_question'][0]['question_id'];
		$this->reaction->user_id		= $this->userauth->user_id;		
		$data['overall_reaction'] = round(($this->reaction->overallReaction($data['can_id'])/10)*100, 0) . '%';
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