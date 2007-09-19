<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_library
{
	public $type;
	private $name;
	private $event_name;
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
		$dateSort = ($this->sort == 'date') ? 'Date' : anchor("question/view/{$result['event_url_name']}/" . url_title($result['question_name']), 'Date');
		$votesSort = ($this->sort == 'votes') ? 'Votes' : anchor("question/view/{$result['event_url_name']}/" . url_title($result['question_name']) . '/votes', 'Votes');
		$commentHtml = "<div class=\"comments-sort\">Sort comments by: $dateSort | $votesSort</div>";
		
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
		if ($image_array) $avatar_path = $image_array['file_name'];
		else $avatar_path = "image01.jpg";
		
		//get time diff
		$time_array = explode(', ', timespan(strtotime($info['date'])));
		$time_diff = $this->CI->time_lib->getDecay($info['date']);
		$pod = 
		'<div class="sc_container">
			<div class="c_content">
				<div class="'.$comment_class.'">
					<div class="info">
						<img class="sc_image" src="./avatars/shrink.php?img='.$avatar_path.'&w=16&h=16">&nbsp;&nbsp;by '
						.anchor('user/profile/'.$info['user_name'],$user_name).
						' ('.$time_diff.' ago)'.'
					</div>	
					<div class="thumb_block">';
					if ($voted < 0) {
						$pod .= anchor("/comment/voteUp/{$info['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/thumbsUp.png' border='0'>");
						$pod .= " <img src='./images/votedCheckBox.png' border='0'>";
					} else if ($voted > 0) {
						$pod .= " <img src='./images/votedCheckBox.png' border='0'>";
						$pod .= " ".anchor("/comment/voteDown/{$info['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/thumbsDown.png' border='0'>");
					} else {
						$pod .= anchor("/comment/voteUp/{$info['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/thumbsUp.png' border='0'>");
						$pod .= " ".anchor("/comment/voteDown/{$info['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/thumbsDown.png' border='0'>");
					}				
		$pod .=			
					'</div>
					<div class="num_votes">
						<span class="sc_votes">'.$votes.' VOTES</span>
					</div>		
				</div>
				<p>'.$info['comment'].'</p>
			</div>
		</div>';
		
		// subcommenting form
		$submit = ($this->CI->userauth->isUser()) ? 
		'<input type="submit" value="Comment" class="button"/>' : 
		'<input type=\'button\' onclick="showBox(\'login\');" value=\'Login to comment\' class=\'button\'/>';
		$pod .= "<p><a class=\"link\" onclick=\"javascript:new Effect.toggle('subcomment_pod_{$info['comment_id']}','blind', {queue: 'end'});\">Reply to {$user_name}'s comment:</a></p> "
		.'<div id="subcomment_pod_'.$info['comment_id'].'" style="display:none;">'
		.form_open('comment/addCommentAction')
		.form_textarea(array('class' => 'txt', 'rows' => 3, 'name' => 'comment', 'style' => 'width:98%'))
		.form_hidden('parent_id', $info['comment_id'])
		.form_hidden('event_name', $this->event_name)
		.form_hidden('name', $this->name)
		.form_hidden('event_type', $this->type)		
		.$submit
		.form_close()
		."<br />"
		."</div>";
				
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
						<img src="./images/P20_Comment_SubcommentArrow.png"/>
					</div>
					<div class="sc_content">
						<div class="sc_header">
							<div class="info">
								<img class="sc_image" src="./avatars/shrink.php?img='.$avatar_path.'&w=16&h=16">&nbsp;&nbsp;by '
								.anchor('user/profile/'.$subcomment['user_name'],$user_name).
								' ('.$time_diff.' ago)'.'
							</div>	
							<div class="thumb_block">';
							if ($voted < 0) {
								$pod .= anchor("/comment/voteUp/{$subcomment['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/thumbsUp.png' border='0'>");
								$pod .= " <img src='./images/votedCheckBox.png' border='0'>";
							} else if ($voted > 0) {
								$pod .= " <img src='./images/votedCheckBox.png' border='0'>";
								$pod .= " ".anchor("/comment/voteDown/{$subcomment['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/thumbsDown.png' border='0'>");
							} else {
								$pod .= anchor("/comment/voteUp/{$subcomment['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/thumbsUp.png' border='0'>");
								$pod .= " ".anchor("/comment/voteDown/{$subcomment['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}/{$this->sort}", "<img src='./images/thumbsDown.png' border='0'>");
							}				
				$pod .=			
							'</div>
							<div class="num_votes">
								<span class="sc_votes">'.$votes.' VOTES</span>
							</div>		
						</div>
						<p>'.$subcomment['comment'].'</p>
					</div>
				</div>';
			}
		}
		
		return $pod;
	}
}
