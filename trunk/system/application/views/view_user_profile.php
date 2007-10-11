<?
//echo '<pre>'; print_r($data); echo '</pre>';
$data['red_head'] = 'Welcome';
?>
<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
  <h2><?= ($candidate) ? 'Candidate' : 'User' ?> Profile</h2>	
  	<div class='errorArea'><?=$error?></div>
	<?
	echo "<br /><p style='float:right;margin-right:25px;'><img src='{$avatar_image_path}'></p>";
	echo '<br /><strong>' . ($candidate ? 'Name:' : 'Username:') . '</strong> '.$display_name;
	echo "<br /><strong> Email: </strong> ".$user_email;
	if($candidate) echo "<p><strong>Bio:</strong> $bio</p>";
	//echo "<br /><strong> OpenID: </strong> ".$user_openid;
	//echo isset($avatar_image_name)?"<br /><strong> Avatar: </strong> <img src='./avatars/{$avatar_image_name}'>":'';
	?>
	<? if(!empty($votes)): ?>
	<h3>Last 10 votes</h3><?= anchor("user/all/votes/$user_name", 'See all') ?>
	<table class="user-profile">
	<tr><th>Voted</th><th>Event</th><th>Question</th></tr>
	<? $rowClass = 'normal'; foreach($votes as $k => $v): $vote_value = ($v['vote_value'] > 0) ? '<img src="./images/thumbsUp.png">' : '<img src="./images/thumbsDown.png">'; ?>
	<tr class="<?=$rowClass?>"><td><?=$vote_value?></td><td><?=$v['event_name']?></td><td><?=$v['question_name']?></td></tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ; endforeach; ?>
	</table>
	<? endif; ?>
	<? if(!empty($questions)): ?>
	<h3>Last 10 questions</h3><?= anchor("user/all/questions/$user_name", 'See all') ?>
	<table class="user-profile">
	<tr><th>Event</th><th>Question</th></tr>
	<? $rowClass = 'normal'; foreach($questions as $k => $v): ?>
	<tr class="<?=$rowClass?>"><td><?=$v['event_name']?></td><td><?=$v['question_name']?></td></tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ; endforeach; ?>
	</table>
	<? endif; ?>
	<? if ($owner) { ?>
	<h2>Edit Profile</h2>
	<? if($candidate) echo anchor("forums/edit/candidate/$user_name", 'Edit Candidate Details') ?>
	<div id="user_form">
	<?= form_open_multipart("user/updateProfile/$user_name"); ?>
	
	<?= form_format("Username: ",$user_name); ?>
	<?= form_format("Email: ",form_input('user_email',$user_email,'class="txt"') ); ?>
	<?= form_format("OpenID: ",form_input('user_openid',$user_openid,'class="txt"') ); ?>
	<?= isset($avatar_image_name)?"<br /><img src=\"./avatars/<?=$avatar_image_name;/>\"":'' ?>
	<?= form_format("Avatar: ",form_upload('userfile',$user_avatar,'class="txt"'),'must be less then 1024 kb & 1024px768px (image will be resized)' ); ?>
	<?= isset($avatar_image_name)?form_hidden('old_avatar','./avatars/'.$avatar_image_name):'';?>
	<br /><br />
	<?= form_submit('','Update Profile','class="button"'); ?>
	<?= form_close(); ?>
	</div>
	<? } ?>
</div>
<? $this->load->view('view_includes/footer.php'); ?>  				