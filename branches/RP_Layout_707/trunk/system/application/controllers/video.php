<?php
class Video extends Controller 
{
	function __construct()
	{
		parent::Controller();
		$this->load->model('tag_model','tag');
		$this->load->model('Video_model','video');
		$this->load->model('Event_model','event');
		$this->load->model('Vote_model','vote');
		$this->load->library('validation');
		$this->load->library('time_lib');
		$this->load->helper('url');//for redirect
		$this->load->helper('form');

		$this->load->scaffolding('cn_videos');
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
			$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$uri_array['event']))=>"conventionnext/queue/{$data['event_url']}");
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
		$rules['video'] = "trim|required|min_length[10]|max_length[150]|xss_clean";
		$rules['desc'] = "trim|max_length[250]|xss_clean";
		$rules['tags'] = "trim|strtolower|xss_clean";
		$rules['youtube'] = "trim|xss_clean";
		$rules['thumbnail'] = "trim|xss_clean";
		
		$this->validation->set_rules($rules);
				
		if ($this->validation->run() == FALSE) {
			$data['error'] .= $this->validation->error_string;
		} else {
			$videoID = $this->addVideo();
			if( is_numeric($videoID) ) {
				$this->voteup($videoID);
				//redirect to video view page
				redirect('conventionnext/queue/'.$_POST['event_url']);
				ob_clean();
				exit();
				
			} else {
				$data['error'] = 'Error Adding Video';
			}
		}
		
		//this makes the info sticky 
		$fields['event']	= ( isset($_POST['event']) ) ? $_POST['event']:"";
		$fields['video']	= ( isset($_POST['video']) ) ? $_POST['video']:"";
		$fields['desc']	= ( isset($_POST['desc']) ) ? $_POST['desc']:"";
		$fields['tags']	= ( isset($_POST['tags']) ) ? $_POST['tags']:"";
		$fields['thumbnail']	= ( isset($_POST['thumbnail']) ) ? $_POST['thumbnail']:"";
		$fields['youtube']	= ( isset($_POST['youtube']) ) ? $_POST['youtube']:"";
		$this->validation->set_fields($fields);
				
		$this->load->view('view_submit_video', $data);
	}

	function addVideo()
	{
		#check that user is allowed
		$this->userauth->check();
		
		$eventID = $_POST['event'];
		$userID = $this->userauth->user_id;
		$videoName = $_POST['video'];
		$videoDesc = $_POST['desc'];
		$tags = $_POST['tags'];		
		$youtubeID = $_POST['youtube'];
		$thumbnail = $_POST['thumbnail'];
		
		/* deal with tags first */
		$tags = str_replace(array(/*' ', */"\t"), '', $tags);
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
		
		
		/* insert the video*/
		$videoID = $this->video->insertVideo($videoName, $videoDesc, $userID, $eventID, $youtubeID, $thumbnail, url_title($videoName));
			
		/* insert proper associations */
		if(isset($tagsExist)) if(isset($videoID)) foreach($newKs as $v) $this->tag->insertTagAssociation(0,$videoID, $v, $userID);
	
		return $videoID;
	}
	
	function edit () 
	{		
		$data['error'] = "";
		if (isset($_POST['video_id'])) 
		{
			$changed = $this->video->updateVideo($_POST['video_id'],$_POST);
			if ($changed > 0)
			{
				$data['error'] = "{$changed} record(s) updated.";
			}
		}
		$video_id = $this->uri->segment(3);
		$video_data = $this->video->get_video ($video_id);
		$event_data = $this->event->get_event ($video_data['fk_event_id']);
		$data['event'] = $event_data;
		
		$options = array(
				'pending' => 'Pending',
				'current' => 'Current',
				'asked' => 'Asked',
				'deleted'  => 'Delete'
				);
		$data['dropdown'] = form_dropdown('video_status', $options, $video_data['video_status']);
		$data['video'] = $video_data;
		$this->load->view('view_edit_video',$data);		
	}
	
	function view ($event, $video) {
		$video_id = $this->video->get_id_from_url($video);
		$this->video->video_id = $video_id;
		$result = $this->video->videoQueue();
		$data = $result[0];
		$data['event_type'] = 'video';
		$image_array = unserialize($data['user_avatar']);
		if ($image_array) $data['avatar_path'] = "./avatars/".$image_array['file_name'];
		else $data['avatar_path'] = "./images/image01.jpg";
		//exit(var_dump($data));	
		//get time diff
		$data['time_diff'] = $this->time_lib->getDecay($data['date']);
		//get voted
		if ($this->userauth->isUser()) {
			$this->vote->type='video';
			$score = $this->vote->votedScore($data['video_id'],$this->userauth->user_id);
			if ($score > 0) $data['voted'] = 'up';
			else if ($score < 0) $data['voted'] = 'down';
			else $data['voted'] = false;
		} else $data['voted'] = false;
		$this->load->library('comments_library');
		$comments_library = new Comments_library();
		$comments_library->type = 'video';
		$data['comments_body'] = $comments_library->createComments($result[0]);
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$data['event_name']))=>"conventionnext/queue/event/".url_title($data['event_name']));
		$data['rightpods'] = array('dynamic'=>array('event_description'=>$data['event_desc'],'event_location'=>$data['location']));
		$this->load->view('video/video_view.php', $data);
	}
	
	function voteup($video_id = 0)
	{
		$this->userauth->check();
		//get video id
		$uri_array = $this->uri->uri_to_assoc(3);
		if (isset($uri_array['video']) && is_numeric($uri_array['video'])) $id = $uri_array['video'];
		if (isset($uri_array['video']) && is_string($uri_array['video'])) $id = $this->video->get_id_from_url($uri_array['video']);	
		$id = ($video_id > 0) ? $video_id:$id;

		
		$event_url = $this->uri->assoc_to_uri(array('event'=>$uri_array['event']));
		if (isset($uri_array['sort'])) $event_url = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
		#check that has not voted
		$this->vote->type = 'video';
		if($this->vote->alreadyVoted($id, $this->userauth->user_id)) {
			redirect('conventionnext/queue/'.$event_url);
			ob_clean();
			exit();
		}
		
		#TODO validation and trending need to be considered	
		$this->vote->voteup($this->userauth->user_id, $id);
		//$this->queue();
		
		// redirect('conventionnext/queue/'.$event_url);
		// 		ob_clean();
		// 		exit();
	}
	
	function votedown($video_id = 0)
	{
		$this->userauth->check();
		//get video id
		$uri_array = $this->uri->uri_to_assoc(3);
		if (isset($uri_array['video']) && is_numeric($uri_array['video'])) $id = $uri_array['video'];
		if (isset($uri_array['video']) && is_string($uri_array['video'])) $id = $this->video->get_id_from_url($uri_array['video']);	
		$id = ($video_id > 0) ? $video_id:$id;
		
		$event_url = $this->uri->assoc_to_uri(array('event'=>$uri_array['event']));
		if (isset($uri_array['sort'])) $event_url = $this->uri->assoc_to_uri(array('event'=>$uri_array['event'],'sort'=>$uri_array['sort']));
		
		#check that user has not voted
		$this->vote->type = 'video';
		if(!$this->userauth->check() || $this->vote->alreadyVoted($id, $this->userauth->user_id)) {
			redirect('conventionnext/queue/'.$event_url);
			ob_clean();
			exit();
		}
		
		#TODO validation and trending need to be considered
		$this->vote->votedown($this->userauth->user_id, $id);
		//$this->queue();
		// redirect('conventionnext/queue/'.$event_url);
		// 		ob_clean();
		// 		exit();
	}
	
	/**
	 * this function is for using ajax to get youtube video details
	 **/
	function youTubeAjax () {
		$this->load->library('YouTubeApi');
		$youtube_api = new YouTubeApi();
		$youtube_data = $youtube_api->getVideoDetailsArray($_POST['video_id']);	
		
		echo json_encode($youtube_data);
		
	}
	 
}
?>