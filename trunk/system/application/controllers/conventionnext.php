<?php
class Conventionnext extends Controller 
{
	private $ajax = false;
	
	function __construct()
	{
		parent::Controller();
		$this->load->model('Question_model','question');
		$this->load->model('Video_model', 'video');
		$this->load->model('Vote_model','vote');
		$this->load->model('Event_model','event');
		$this->load->library('validation');
		$this->load->helper('url');//for redirect
		$this->load->helper('form');
		$this->load->model('tag_model', 'tag');

		$this->load->scaffolding('cn_questions');
	}
	
	function index () {
		redirect('event/');
		ob_clean();
		exit();
	}
	
	public function ajQueueUpdater($event_name, $sort, $offset, $tag='')
	{
		if(!empty($tag)) $tag = "tag/$tag/";
		redirect("/conventionnext/queue/{$tag}event/$event_name/sort/$sort/ajax/true/$offset");
	}
	
	function queue() // passing $this->ajax through still needs to be implemented
	{		
		//get data from url
		$uri_array = $this->uri->uri_to_assoc(3);
		if (isset($uri_array['ajax'])) $this->ajax = true;
		if (!isset($uri_array['event'])) $this->index();

		//find event type 
		if (isset($uri_array['event']) && is_numeric($uri_array['event'])) // if an event id was passed
		{
			if ( $this->event->get_event_type($uri_array['event']) == 'question') $this->questionQueue($uri_array,$uri_array['event']);
			if ( $this->event->get_event_type($uri_array['event']) == 'video') $this->videoQueue($uri_array,$uri_array['event']);			
			
		}
		if (isset($uri_array['event']) && is_string($uri_array['event'])) // if an event name was passed 
		{
			$event_id = $this->event->get_id_from_url($uri_array['event']);
			if ( $this->event->get_event_type($event_id) == 'question') $this->questionQueue($uri_array,$event_id);
			if ( $this->event->get_event_type($event_id) == 'video') $this->videoQueue($uri_array,$event_id); 
		}			
	}
	
	public function video($event, $video)
	{
		$video_id = $this->video->get_id_from_url($video);
		$this->video->video_id = $video_id;
		$data['results'] = $this->video->videoQueue();

		$this->load->view('video/video_view.php', $data);
	}
		
	function questionQueue ($uri_array,$event_id) 
	{
		if($this->ajax) $data['ajax'] = true;
		$data['event_type'] = 'question';
		
		$this->load->model('Question_model','question2');
		//event
		$this->question2->event_id = $event_id; 
		$data['event_name'] = $uri_array['event'];
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
		if (isset($uri_array['tag']) && is_string($uri_array['tag'])) {
			$this->question2->tag_id = $this->tag->get_id_from_tag($uri_array['tag']);
			$data['tag'] = $uri_array['tag'];
		}
		//set default sort link
		$type = ucfirst($data['event_type']);
		$sort_active = 'upcoming';
		$queue_title = 'Upcoming '. $type . 's';
		
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
		$data['sort'] = $sort_active;
		
		$data['event_url'] = $this->uri->assoc_to_uri(array('event'=>$uri_array['event']));			
		//set a sorting array
		$sort_array = array('<strong>Sort '.$data['event_type'].'s by:</strong>');
		($sort_active == 'upcoming') ? array_push($sort_array,'Upcoming'):array_push( $sort_array,anchor("conventionnext/queue/{$data['event_url']}",'Upcoming') );
		($sort_active == 'newest') ? array_push($sort_array,'Newest'):array_push( $sort_array,anchor("conventionnext/queue/{$data['event_url']}/sort/newest",'Newest') );
		($sort_active == 'asked') ? array_push($sort_array,'Asked'):array_push( $sort_array,anchor("conventionnext/queue/{$data['event_url']}/sort/asked",'Asked') );
		($sort_active == 'current') ? array_push($sort_array,'Current'):array_push( $sort_array,anchor("conventionnext/queue/{$data['event_url']}/sort/current",'Current') );
		
		$data['sort_array'] = $sort_array;
		//var_dump($sort_array);
		
		if ( isset($uri_array['sort']) ) $data['event_url'] = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
		$data['queue_title'] = $queue_title;
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$uri_array['event']))=>"conventionnext/queue/{$data['event_url']}");
		
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
			//add some style
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
				$this->vote->type='question';
				$score = $this->vote->votedScore($row['question_id'],$this->session->userdata('user_id'));
				if ($score > 0) $data['results'][$key]['voted'] = 'up';
				else if ($score < 0) $data['results'][$key]['voted'] = 'down';
				else $data['results'][$key]['voted'] = false;
			} else $data['results'][$key]['voted'] = false;
			//set user avatar
			$image_array = unserialize($data['results'][$key]['user_avatar']);
			if ($image_array) $data['results'][$key]['avatar_path'] = "./avatars/".$image_array['file_name'];
			else $data['results'][$key]['avatar_path'] = "./images/image01.jpg";	
			//get time diff
			$data['results'][$key]['time_diff'] = timespan(strtotime($data['results'][$key]['date']));
		}
		//echo '<pre>'; print_r($data); echo '</pre>';
		//get event details
		if (!isset($uri_array['tag'])) {
			$data['rightpods'] = array('dynamic'=>array('event_description'=>$data['results'][0]['event_desc'],'event_location'=>$data['results'][0]['location']));
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

		$this->load->view('view_queue',$data);	
	}		
	
	function videoQueue ($uri_array,$event_id) 
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
		if (isset($uri_array['user']) && is_string($uri_array['user'])) $
			$this->video2->user_id = $this->user->get_id_from_name($uri_array['user']); 
			
		//tag
		if (isset($uri_array['tag']) && is_numeric($uri_array['tag'])) $this->video2->tag_id = $uri_array['tag'];
		if (isset($uri_array['tag']) && is_string($uri_array['tag'])) $this->video2->tag_id = $this->tag->get_id_from_tag($uri_array['tag']);
		
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
		($sort_active == 'upcoming') ? array_push($sort_array,'Score'):array_push( $sort_array,anchor("conventionnext/queue/{$data['event_url']}",'Score') );
		($sort_active == 'newest') ? array_push($sort_array,'Newest'):array_push( $sort_array,anchor("conventionnext/queue/{$data['event_url']}/sort/newest",'Newest') ); 
		
		$data['sort_array'] = $sort_array;
		//var_dump($sort_array);

		if ( isset($uri_array['sort']) ) $data['event_url'] = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
		$data['queue_title'] = $queue_title;
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$uri_array['event']))=>"conventionnext/queue/{$data['event_url']}");
		
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
		}
		
		//set user score			
		foreach ($data['results'] as $key => $row) {
			if ($this->userauth->isUser()) {
				$this->vote->type='video';
				$score = $this->vote->votedScore($row['video_id'],$this->session->userdata('user_id'));
				if ($score > 0) $data['results'][$key]['voted'] = 'up';
				else if ($score < 0) $data['results'][$key]['voted'] = 'down';
				else $data['results'][$key]['voted'] = false;
			} else $data['results'][$key]['voted'] = false;
		}
		
		// tag cloud - this section might need a little tweaking
		/*if (isset($event_id) && !empty($data['results'])) {
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
				}	*/
				$data['cloud'] = '';
		//exit(var_dump($data['results']));

		$this->load->view('view_queue',$data);	
	}
}
?>