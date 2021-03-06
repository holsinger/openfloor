<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_library
{
	public $type;
	public $ajax;
	public $custom_theme;
	private $name;
	private $event_name;
	private $question_name;
	private $question_id;
	public $sort = 'date';
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('comments_model');
		$this->CI->load->model('event_model');
		$this->CI->load->model('vote_model','vote');
		$this->CI->load->model('candidate_model','candidate');
		$this->CI->load->library('time_lib');
	}
	
	public function createComments($result)
	{
		$_id_ = ($this->type == 'question') ? 'question_id' : 'video_id' ;
		$_name_ = ($this->type == 'question') ? 'question_name' : 'video_title' ;
		
		// deal with sorting
		/*
		$dateSort = ($this->sort == 'date') ? 'Date' : anchor("question/view/{$result['event_url_name']}/" . url_title($result['question_name']), 'Date');
		$votesSort = ($this->sort == 'votes') ? 'Votes' : anchor("question/view/{$result['event_url_name']}/" . url_title($result['question_name']) . '/votes', 'Votes');
		$commentHtml = $this->ajax ? '' : "<div class=\"comments-sort\">Sort comments by: $dateSort | $votesSort</div>";
		*/
		
		$id = $result[$_id_];
		$this->name = url_title($result[$_name_]);
		$this->event_name = url_title($result['event_name']);
		
		$this->CI->comments_model->order_by = $this->sort;
		if($this->type == 'question') {
			if (!$comments = $this->CI->comments_model->getCommentsByQuestion($id)) 
				$commentHtml .= '<strong>There are no comments yet.</strong>';
		} else {
			if (!$comments = $this->CI->comments_model->getCommentsByVideo($id)) 
				$commentHtml .= '<strong>There are no comments yet.</strong>';
		}
		
		if(is_array($comments))
			foreach ($comments as $v) {
				$subcomments = $this->CI->comments_model->getChildrenByComment($v['comment_id']);
				$commentHtml .= $this->createCommentsPod($v, $id, $subcomments);
			}	
		
		return $commentHtml;
	}
	
	public function createCommentsPod($info, $id, $subcomments = false)
	{
		$user_name = isset($info['fk_can_id']) ? $this->CI->candidate->nameByUser($info['fk_can_id']) : $info['user_name'];
		$comment_class = isset($info['fk_can_id']) ? 'sc_header_can' : 'sc_header' ;
		$votes = ($info['votes'] == null) ? 0 : $info['votes'] ;
		#see if user voted
		$this->CI->vote->type = 'comment';
		// $voted = ($this->CI->session->userdata('user_id')>0) ? $this->CI->vote->alreadyVoted($info['comment_id'],$this->CI->session->userdata('user_id')):0;
		$voted = ($this->CI->session->userdata('user_id')>0) ? $this->CI->vote->votedScore($info['comment_id'],$this->CI->session->userdata('user_id')):0;
		
		#resize image
		$image_array = unserialize($info['user_avatar']);
		if ($image_array) 
			$avatar_path = $image_array['file_name'];
		else 
			$avatar_path = "image01.jpg";
		
		//get time diff
		$time_array = explode(', ', timespan(strtotime($info['date'])));
		$time_diff = $this->CI->time_lib->getDecay($info['date']);
		$pod = 
		'<div class="sc_container">
			<div class="c_content">
				<div class="'.$comment_class.'">
					<div class="cp_info_title">
						<img class="sc_image" src="./avatars/shrink.php?img='.$avatar_path.'&w=16&h=16">&nbsp;&nbsp;by 
						<a href="javascript:showUrl(\'/user/profile/'.$subcomment['user_name'].'/true\');">'.$subcomment['user_name'].'</a>
						('.$time_diff.' ago)'.'
					</div>	
					<div class="thumb_block">';
					$this->question_id = $info['fk_question_id'];
					$question =  $this->CI->question->get_question($this->question_id);
					$this->question_name = url_title($question['question_name']);
					$this->createVoteBox($pod, $voted, $info['comment_id'], $this->question_id, url_title($this->event_name), $this->question_name, $this->ajax,$this->custom_theme);				
					$pod .=			
					'</div>
					<div class="num_votes">
						<span class="sc_votes">'.$votes.' </span>
					</div>		
				</div>
				<p style="padding: 5px;">'.$info['comment'].'</p>
			</div>
		</div>';
		
		// subcommenting form
		if($this->ajax) {
			$submit = $submit = '<input type="button" class="button" value="Comment" onClick="javascript:cpUpdater.submitComment(' . $info['fk_question_id'] . ', \'' . url_title($this->event_name) . '\', \'' . $this->question_name . '\', ' . $info['comment_id'] . ')"/>';
		} else {
			$submit = ($this->CI->userauth->isUser()) ? 
			'<input type="submit" value="Comment" class="button"/>' : 
			'<input type=\'button\' onclick="showBox(\'login\');" value=\'Login to comment\' class=\'button\'/>';
		}
		
		$pod .= "<span style=\"margin: 0px 0px 10px 10px; display: block;\"><a class=\"link\" onclick=\"javascript:new Effect.toggle('subcomment_pod_{$info['comment_id']}','blind', {queue: 'end'});\">Reply to {$user_name}'s comment</a></span>".
		'<div id="subcomment_pod_'.$info['comment_id'].'" style="margin: 0px 0px 10px 10px; display:none;"><br />'
			.form_open('comment/addCommentAction', array('id' => 'subcommenting_form_' . $info['comment_id'])).
				form_textarea(array('class' => 'txt', 'rows' => 3, 'name' => 'comment', 'style' => 'width:90%'))
				.form_hidden('parent_id', $info['comment_id'])
				.form_hidden('event_name', $this->event_name)
				.form_hidden('name', $this->name)
				.form_hidden('event_type', $this->type)."<br />"	
				.$submit."&nbsp;&nbsp;".
				'<input type="button" value="Cancel" class="button" onclick="javascript:new Effect.toggle(\'subcomment_pod_'.$info['comment_id'].'\',\'blind\');"/>'
			.form_close().
		"</div>";
				
		// add subcomments
		if ($subcomments) {
			foreach($subcomments as $subcomment) { 
				$user_name = isset($subcomment['fk_can_id']) ? $this->CI->candidate->nameByUser($subcomment['fk_can_id']) : $subcomment['user_name'];
				$votes = ($subcomment['votes'] == null) ? 0 : $subcomment['votes'] ;
				#see if user voted
				$this->CI->vote->type = 'comment';
				// $voted = ($this->CI->session->userdata('user_id')>0) ? $this->CI->vote->alreadyVoted($subcomment['comment_id'],$this->CI->session->userdata('user_id')):0;
				$voted = ($this->CI->session->userdata('user_id')>0) ? $this->CI->vote->votedScore($subcomment['comment_id'],$this->CI->session->userdata('user_id')):0;
				
				#resize image
				$image_array = unserialize($subcomment['user_avatar']);
				if ($image_array) $avatar_path = $image_array['file_name'];
				else $avatar_path = "image01.jpg";

				//get time diff
				$time_array = explode(', ', timespan(strtotime($subcomment['date'])));
				$time_diff = $this->CI->time_lib->getDecay($subcomment['date']);
				
				$pod .= 
				'<div class="sc_container">
					<div class="sc_leftnav">
						<img src="./images/Comment_SubcommentArrow.gif"/>
					</div>
					<div class="sc_content">
						<div class="sc_header">
							<div class="cp_info_title">
								<img class="sc_image" src="./avatars/shrink.php?img='.$avatar_path.'&w=16&h=16"/>&nbsp;&nbsp;by 
								<a href="javascript:showUrl(\'/user/profile/'.$subcomment['user_name'].'/true\');">'.$subcomment['user_name'].'</a>
								 ('.$time_diff.' ago)'.'
							</div>	
							<div class="thumb_block">';
								$this->createVoteBox($pod, $voted, $subcomment['comment_id'], $this->question_id, url_title($this->event_name), $this->question_name, $this->ajax,$this->custom_theme);
								$pod .=			
							'</div>
							<div class="num_votes">
								<span class="sc_votes">'.$votes.' </span>
							</div>
									
						</div>
						<p style="padding: 5px;">'.$subcomment['comment'].'</p>
					</div>
				</div>';
			}
		}
		
		return $pod;
	}
	
	private function createVoteBox(&$pod, $voted, $id, $question_id = '', $event_name = '', $question_name = '', $ajax = false,$custom_theme='')
	{
		if($ajax)
		{
			$site_url = site_url();
			if(!$this->CI->userauth->isUser()) {
				$pod .= "<img onclick=\"showBox('login')\" src='./images/{$custom_theme}thumbsUp.png' class='link' border='0'>";
				$pod .= "<img onclick=\"showBox('login')\" src='./images/{$custom_theme}thumbsDown.png' class='link' border='0'>";
			} elseif ($voted < 0) {
				$pod .= "<img src=\"./images/{$custom_theme}thumbsUp.png\" onClick=\"cpUpdater.voteComment('{$site_url}comment/voteUp/$id/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}', '$question_id', '$event_name', '$question_name')\" class='link' />";
				$pod .= " <img src='./images/{$custom_theme}votedCheckBoxBGcom.png' border='0'>";
			} elseif ($voted > 0) {
				$pod .= " <img src='./images/{$custom_theme}votedCheckBoxBGcom.png' border='0'>";
				$pod .= "<img src=\"./images/{$custom_theme}thumbsDown.png\" onClick=\"cpUpdater.voteComment('{$site_url}comment/voteDown/$id/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}', '$question_id', '$event_name', '$question_name')\" class='link' />";
			} else {
				$pod .= "<img src=\"./images/{$custom_theme}thumbsUp.png\" onClick=\"cpUpdater.voteComment('{$site_url}comment/voteUp/$id/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}', '$question_id', '$event_name', '$question_name')\" class='link' />";
				$pod .= "<img src=\"./images/{$custom_theme}thumbsDown.png\" onClick=\"cpUpdater.voteComment('{$site_url}comment/voteDown/$id/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}', '$question_id', '$event_name', '$question_name')\" class='link' />";
			}
		} else {
			error_log('nonajax');
			if ($voted < 0) {
				$pod .= anchor("/comment/voteUp/$id/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/{$custom_theme}thumbsUp.png' class='link' border='0'>");
				$pod .= " <img src='./images/votedCheckBoxBGcom.png' border='0'>";
			} else if ($voted > 0) {
				$pod .= " <img src='./images/votedCheckBoxBGcom.png' border='0'>";
				$pod .= " ".anchor("/comment/voteDown/$id/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/{$custom_theme}thumbsDown.png' class='link' border='0'>");
			} else {
				$pod .= anchor("/comment/voteUp/$id/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/{$custom_theme}thumbsUp.png' class='link' border='0'>");
				$pod .= " ".anchor("/comment/voteDown/$id/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/{$custom_theme}thumbsDown.png' class='link' border='0'>");
			}
		}		
	}
}