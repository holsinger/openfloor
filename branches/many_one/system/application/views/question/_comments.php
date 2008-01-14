<? if(isset($ajax)): ?>
	<div class="change_sort" style="float:left;">Sort comments by: 
		<a class="link" onclick="cpUpdater.change_comments_sort(<?= $question_id ?>, '<?= url_title($event_name) ?>', '<?= url_title($question_name) ?>', 'date')">date</a>, 
		<a class="link" onclick="cpUpdater.change_comments_sort(<?= $question_id ?>, '<?= url_title($event_name) ?>', '<?= url_title($question_name) ?>', 'votes')">votes</a>
	</div>
	<div class="close">
		<a onClick="cpUpdater.view_tab_section('comments', <?=$question_id?>);">
			<img src="./images/many_one/button_close_x.png" border="0" />
		</a>
	</div>
<? endif; ?>
<br/>
<br/>
<div id="comments">
	<?=isset($comments_body)?$comments_body.'<br/>':''?>
</div>
<?
$attributes = array('class' => 'txt', 'name' => 'comment', 'rows' => 3, 'cols' => 48, 'style' => 'width:97%');

// Submit button used below
if(isset($ajax)) {
	$submit = '<input type="button" class="button" value="Comment" onClick="javascript:cpUpdater.submitComment(' . $question_id . ', \'' . url_title($event_name) . '\', \'' . url_title($question_name) . '\', 0)" style="cursor:pointer;"/>';
} else {
	$submit = ($this->userauth->isUser()) ? 
	'<input type="submit" value="Comment" class="button"/>' : 
	'<input type=\'button\' onclick="showBox(\'login\');" value=\'Login to comment\' class=\'button\'/>';
}

if($this->userauth->isUser()) {
	$comments = '
	<div id="comment_add">
		<div class="comment_head">
			<strong>
			<img src="./avatars/shrink.php?img='.$this->userauth->user_avatar.'&w=16&h=16">&nbsp;&nbsp;'.anchor("user/profile/{$this->userauth->user_name}",$this->userauth->display_name).'
			why not add to the discussion?
			</strong>
		</div>
		<br />'.
		form_open('comment/addCommentAction', array('id' => 'commenting_form_' . $question_id)).
		form_textarea($attributes).
		form_hidden('fk_question_id', $question_id).
		form_hidden('event_name', url_title($event_name)).
		form_hidden('name', $question_name).
		form_hidden('event_type', 'question')."
		<br /><br />
		$submit".
		form_close().'
		<br /><br />
	</div>';
} else {
	echo '&nbsp;<a class="link" onclick="showBox(\'login\')">Login to comment.</a>';
}
echo $comments; ?>
<? if(isset($ajax)): ?>
	<div class="close">
		<a class="link" onClick="cpUpdater.view_tab_section('comments', <?=$question_id?>);">
			<img src="./images/many_one/button_close_x.png" border="0" />
		</a>
	</div>
	<br /><br /><br />
<? endif; ?>