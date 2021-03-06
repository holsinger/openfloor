<?php

class Votes extends Controller
{
	function __construct()
	{
		parent::Controller();
		$this->load->library('tag_lib');
		$this->load->model('tag_model', 'tag');
		$this->load->library('wordcloud');
		$this->load->model('question_model');
		$this->load->model('vote_model');
		$this->load->model('user_model');
		$this->load->library('time_lib');
		$this->load->library('flag_lib');
		$this->load->model('flag_model', 'flag');
	}
	
	public function who($question_id)
	{
		// retrieve question information
		$this->question_model->question_id = $question_id;
		$this->question_model->question_status = null;
		$results = $this->question_model->questionQueue();
		$data = $results[0];
		$data['display_name'] = $this->user->displayName($data['user_name']);
		//set user avatar
		$image_array = unserialize($data['user_avatar']);
		if ($image_array) 
			$data['avatar_path'] = "./avatars/".$image_array['file_name'];
		else 
			$data['avatar_path'] = "./images/image01.jpg";
		//get time diff
		$data['time_diff'] = $this->time_lib->getDecay($data['date']);
		
		// tags		
		if(!empty($data['tags'])) foreach($data['tags'] as $k1=>$tag) $data['tags'][$k1] = anchor("forums/queue/event/".url_title($data['event_name'])."/tag/".$tag,$tag);
		
		//set event type
		$data['event_type'] = 'question';
		//get voted
		if ($this->userauth->isUser()) {
			$this->vote->type='question';
			$score = $this->vote_model->votedScore($data['question_id'],$this->userauth->user_id);
			if ($score > 0) $data['voted'] = 'up';
			else if ($score < 0) $data['voted'] = 'down';
			else $data['voted'] = false;
		} else $data['voted'] = false;
			
		// retrieve votes information
		/*
			TODO THis should be in a view - CTE 1/14/2008
		*/
		$votes = $this->vote_model->getVotesByQuestion($question_id);
			if(isset($_POST['ajax'])) {	// top close
				$voteHTML .= "
				<div style=\"height: 5px\"></div>
				<div class=\"close\" style=\"position:relative;top:-5px;\"><a onClick=\"cpUpdater.view_tab_section('votes', $question_id);\"><img src=\"./images/many_one/button_close_x.png\" border=\"0\" /></a></div>
				<div>&nbsp;</div>
				<br />";	// This "br" is added because of IE 
			}
			foreach ($votes as $vote) {			
				#resize image
				$vote_image_array = unserialize($vote['user_avatar']);
				if ($vote_image_array) $vote_avatar_path = $vote_image_array['file_name'];
				else $vote_avatar_path = "image01.jpg";
			
				$vote_time = $this->time_lib->getDecay($vote['timestamp']);
				$vote_value = ($vote['vote_value'] > 0) ? 'voted <img src="./images/'.$this->config->item("custom_theme").'/thumbsUp.png"> in favor' : 'voted <img src="./images/'.$this->config->item("custom_theme").'/thumbsDown.png"> against' ;
				$voteHTML .= '<div class="votes_head">'.'<img class="sc_image" src="./avatars/shrink.php?img='.$vote_avatar_path.'&w=16&h=16">&nbsp;&nbsp;
				<a href="javascript:showUrl(\'/user/profile/'.$vote['user_name'].'/true\');">'.$vote['user_name'].'</a>
				' . $vote_value . ' ' .$vote_time.' ago </div>';
			}
			if(isset($_POST['ajax'])){
				$voteHTML .= "<div class=\"close\" style=\"position:relative;top:-5px;\"><a class=\"link\" onClick=\"cpUpdater.view_tab_section('votes', $question_id);\"><img src=\"./images/many_one/button_close_x.png\" border=\"0\" /></a></div>";
			}
		$voteHTML.='
		<br /><br />';
		
				
		$data['voteHTML'] = $voteHTML;
		if(isset($_POST['ajax'])) { echo $data['voteHTML']; exit(); }
		$data['breadcrumb'] = array('Home'=>$this->config->site_url(),'Events'=>'event/',ucwords(str_replace('_',' ',$data['event_name']))=>"forums/queue/event/".url_title($data['event_name']));
		$data['rightpods'] = array('dynamic'=>array('event_description'=>$data['event_desc'],'event_location'=>$data['location']));
		
		$data['view_name'] = 'votes_view';
		$this->load->view('view_question_votes', $data);
	}
}

?>