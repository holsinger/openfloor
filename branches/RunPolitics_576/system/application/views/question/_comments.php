<div id="comments">
	<?=isset($comments_body)?$comments_body.'<br/>':''?>
</div>
<?
$attributes = array('class' => 'txt', 'name' => 'comment', 'rows' => 3, 'cols' => 48, 'style' => 'width:97%');

if(isset($ajax)) $submit = '<a onClick="javascript:cpUpdater.submitComment(' . $question_id . ', \'' . url_title($event_name) . '\', \'' . url_title($question_name) . '\')">Submit Comment</a>';
else {
	$submit = ($this->userauth->isUser()) ? 
	'<input type="submit" value="Submit Comment" class="button"/>' : 
	'<input type=\'button\' onclick="showBox(\'login\');" value=\'Login to comment\' class=\'button\'/>';
}

$comments = '<div id="comment_add"><div class="comment_head"><strong>';
	if ($this->userauth->isUser()) $comments .= '<img src="./avatars/shrink.php?img='.$this->userauth->user_avatar.'&w=16&h=16">&nbsp;&nbsp;'.anchor("user/profile/{$this->userauth->user_name}",$this->userauth->display_name);
	$comments .= ' why not add to the discussion?</strong></div><br />'
	. form_open('comment/addCommentAction', array('id' => 'commenting_form_' . $question_id))
		. form_textarea($attributes)
		. form_hidden('fk_question_id', $question_id)
		. form_hidden('event_name', url_title($event_name))
		. form_hidden('name', $question_name)
		. form_hidden('event_type', 'question')
		. "<br /><br />{$submit}"
	. form_close()
. '<br /><br /></div>';
echo $comments; 
if(isset($ajax)) exit();
?>