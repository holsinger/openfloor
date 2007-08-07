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
		$this->CI->load->library('time_lib');
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
		if ($image_array) $avatar_path = $image_array['file_name'];
		else $avatar_path = "image01.jpg";
		
		
		//get time diff
		$time_array = explode(', ', timespan(strtotime($info['date'])));
		$time_diff = $this->CI->time_lib->getDecay($info['date']);
		
		$pod = '<div class="comment_head">';
		$pod .= '<img src="./avatars/shrink.php?img='.$avatar_path.'&w=16&h=16">&nbsp;&nbsp;';
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
		
		// subcommenting form
		$pod .= "<p><a class=\"link\" onclick=\"javascript:new Effect.toggle('subcomment_pod_{$info['comment_id']}','blind', {queue: 'end'});\">Reply to {$info['user_name']}'s comment:</a></p> ";
		$pod .= '<div id="subcomment_pod_'.$info['comment_id'].'" style="display:none;">';
		$pod .= form_open('comment/addCommentAction');
		$pod .= form_input(array('class' => 'txt', 'size' => 36, 'name' => 'comment'));
		$pod .= form_hidden('parent_id', $info['comment_id']);
		$pod .= form_hidden('event_name', $this->event_name);
		$pod .= form_hidden('name', $this->name);
		$pod .= form_hidden('event_type', $this->type);
		$pod .= "<input type=\"submit\" value=\"Comment\" class=\"button\" />";
		$pod .= form_close();
		$pod .= "<br />";
		$pod .= "</div>";
				
		// add subcomments
		if ($subcomments) {
			foreach($subcomments as $subcomment) { 
				$votes = ($subcomment['votes'] == null) ? 0 : $subcomment['votes'] ;
				#see if user voted
				$this->CI->vote->type = 'comment';
				$voted = ($this->CI->session->userdata('user_id')>0) ? $this->CI->vote->alreadyVoted($subcomment['comment_id'],$this->CI->session->userdata('user_id')):0;

				#resize image
				$image_array = unserialize($subcomment['user_avatar']);
				if ($image_array) $avatar_path = $image_array['file_name'];
				else $avatar_path = "image01.jpg";

				//get time diff
				$time_array = explode(', ', timespan(strtotime($subcomment['date'])));
				$time_diff = $this->CI->time_lib->getDecay($subcomment['date']);
				
				//$pod .= "<p>--> {$subcomment['comment']}</p>";
				//$pod .= '<img src="./images/P20_Comment_SubcommentArrow.png"/>';
				$pod .= '<div class="comment_head">';
				$pod  .= '<span class="subcomment_arrow"><img src="./images/P20_Comment_SubcommentArrow.png"/></span>';
				$pod .= '<img src="./avatars/shrink.php?img='.$avatar_path.'&w=16&h=16">&nbsp;&nbsp;';
				$pod .= 'by '.anchor('user/profile/'.$subcomment['user_name'],$subcomment['user_name']);
				$pod .= " ({$time_diff} ago)";
				$pod .= "<span class='comment_voting'>";
				if ($voted < 0) {
					$pod .= "<img src='./images/thumbsUp.png' border='0'>";
					$pod .= " <img src='./images/votedCheckBox.png' border='0'>";
				} else if ($voted > 0) {
					$pod .= " <img src='./images/votedCheckBox.png' border='0'>";
					$pod .= " <img src='./images/thumbsDown.png' border='0'>";
				} else {
					$pod .= anchor("/comment/voteUp/{$subcomment['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}", "<img src='./images/thumbsUp.png' border='0'>");
					$pod .= " ".anchor("/comment/voteDown/{$subcomment['comment_id']}/{$this->name}/{$this->event_name}/{$this->type}", "<img src='./images/thumbsDown.png' border='0'>");
				}
				$pod .= "</span>";
				$pod .= "<span class='comment_vote'>{$votes} VOTES</span>"; 
				$pod .= '</div>';
				$pod .= "<p>{$subcomment['comment']}</p>";
			}
		}
		
		return $pod;
	}
}