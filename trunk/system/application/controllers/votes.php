<?php

class Votes extends Controller
{
	function __construct()
	{
		parent::Controller();
		$this->load->model('question_model');
		$this->load->model('vote_model');
		$this->load->library('time_lib');
	}
	
	public function who($question_id)
	{
		// retrieve question information
		$this->question_model->question_id = $question_id;
		$results = $this->question_model->questionQueue();
		$data = $results[0];
		//set user avatar
		$image_array = unserialize($data['user_avatar']);
		if ($image_array) $data['avatar_path'] = "./avatars/".$image_array['file_name'];
		else $data['avatar_path'] = "./images/image01.jpg";
		//get time diff
		$time_diff = $this->time_lib->getDecay($data['date']);
		//set event type
		$data['event_type'] = 'question';
		//get voted
		if ($this->userauth->isUser()) {
			$this->vote->type='question';
			$score = $this->vote_model->votedScore($data['question_id'],$this->session->userdata('user_id'));
			if ($score > 0) $data['voted'] = 'up';
			else if ($score < 0) $data['voted'] = 'down';
			else $data['voted'] = false;
		} else $data['voted'] = false;
			
		// retrieve votes information
		$votes = $this->vote_model->getVotesByQuestion($question_id);
		
		$voteHtml = '';
		foreach ($votes as $vote) {
			$vote_value = ($vote['vote_value'] > 0) ? 'voted <img src="./images/thumbsUp.png"> in favor' : 'voted <img src="./images/thumbsDown.png"> against' ;
			$voteHtml .= '<div class="votes_head">'.anchor("user/profile/".$vote['user_name'],$vote['user_name']) . ' ' . $vote_value . ' ' .$time_diff.' ago </div><br />';
		}
		$data['votedHtml'] = $voteHtml;
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$data['event_name']))=>"conventionnext/queue/event/".url_title($data['event_name']));
		$data['rightpods'] = array('dynamic'=>array('event_description'=>$data['event_desc'],'event_location'=>$data['location']));
		$this->load->view('view_question_votes', $data);
	}
}

?>