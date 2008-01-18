<div style="height: 5px"></div>
<div class="close" style="position:relative; top:-5px;">
	<a onClick="cpUpdater.view_tab_section('info', '<?= $question_id ?>');">
		<img src="./images/many_one/button_close_x.png" border="0" />
	</a>
</div>
<a href="<?= $this->config->site_url();?>/user/profile/<?=$user_name;?>">
	<img class="sc_image" src="./avatars/<?=$avatar_path;?>"/>
</a>
<br />
<strong>Posted By: </strong><?= anchor('/user/profile/' . $user_info['user_name'], $user_info['user_name']) ?> (<?= $time_diff ?> ago)<br />
<?= empty($question['tags']) ? '' : '<b>Tags: </b>' . implode(', ', $tags) . '<br />' ?>
<strong>Description: </strong><?= $question_desc ?><br />
<? if($question['question_status'] == 'deleted'): ?>
	<strong>Deleted Reason: </strong><?= $flag_reason ?><br />
	<? if($question['flag_reason'] == 'other'): ?>
		<strong>Other Reason: </strong><?= $flag_reason_other ?><br />
	<? endif; ?>
<? endif; ?>
<div class="close" style="position:relative; top:-5px;">
	<a onClick="cpUpdater.view_tab_section('info', '<?= $question_id ?>');">
		<img src="./images/many_one/button_close_x.png" border="0" />
	</a>
</div>
<br />
<? // Added below TR for IE 6 ?>
<br />