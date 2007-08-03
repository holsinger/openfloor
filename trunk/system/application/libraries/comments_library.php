<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comments_library
{
	public $type;
	private $name;
	private $event_name;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('comments_model');
		$this->CI->load->model('event_model');
		$this->CI->load->model('vote_model','vote');		
	}
	
	public function createComments($result)
	{
		$_id_ = ($this->type == 'question') ? 'question_id' : 'video_id' ;
		$_name_ = ($this->type == 'question') ? 'question_name' : 'video_title' ;
		
		$commentHtml = '';
		$id = $result[$_id_];
		$this->name = url_title($result[$_name_]);
		$this->event_name = url_title($result['event_name']);
		
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
		$votes = ($info['votes'] == null) ? 0 : $info['votes'] ;
		#see if user voted
		$this->CI->vote->type = 'comment';
		$voted = ($this->CI->session->userdata('user_id')>0) ? $this->CI->vote->alreadyVoted($info['comment_id'],$this->CI->session->userdata('user_id')):0;
		
		#resize image
		$image_array = unserialize($info['user_avatar']);
		if ($image_array) $avatar_path = "./avatars/".$image_array['file_name'];
		else $avatar_path = "./images/image01.jpg";
		
		
		//get time diff
		$time_diff = timespan(strtotime($info['date']));
		
		$pod = '<div class="comment_head">';
		//$pod .= '<img src="./images/shrink.php?imgpath='.$avatar_path.'&qt=70&width=16&height=16">';
		$pod .= 'by '.anchor('user/profile/'.$info['user_name'],$info['user_name']);
		$pod .= " ({$time_diff} ago)";
		$pod .= "<span class='comment_voting'>";
		if ($voted < 0) {
			$pod .= "<img src='./images/thumbsUp.png' border='0'>";
			$pod .= " <img src='./images/votedCheckBox.png' border='0'>";
		} else if ($voted > 0) {
			$pod .= " <img src='./images/votedCheckBox.png' border='0'>";
			$pod .= " <img src='./images/thumbsDown.png' border='0'>";
		} else {
			$pod .= anchor("/comment/voteUp/{$info['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}", "<img src='./images/thumbsUp.png' border='0'>");
			$pod .= " ".anchor("/comment/voteDown/{$info['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}", "<img src='./images/thumbsDown.png' border='0'>");
		}
		$pod .= "</span>";
		$pod .= "<span class='comment_vote'>{$votes} VOTES</span>"; 
		$pod .= '</div>';
		$pod .= "<p>{$info['comment']}</p>";
		// add subcomments
		if ($subcomments) {
			foreach($subcomments as $subcomment)
				$pod .= "<p>--> {$subcomment['comment']}</p>";
		}
		return $pod;
	}
}