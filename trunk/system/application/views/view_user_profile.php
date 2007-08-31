<?
//echo '<pre>'; print_r($data); echo '</pre>';
$data['red_head'] = 'Welcome';
?>
<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
  <h2>User Profile</h2>	
  	<div class='errorArea'><?=$error?></div>
	<?
	echo "<br /><p style='float:right;margin-right:25px;'><img src='{$avatar_image_path}'></p>";
	echo "<br /><strong> Username: </strong> ".$user_name;
	echo "<br /><strong> Email: </strong> ".$user_email;
	echo "<br /><strong> Display Name: </strong> ".$user_display_name;
	//echo "<br /><strong> OpenID: </strong> ".$user_openid;
	//echo isset($avatar_image_name)?"<br /><strong> Avatar: </strong> <img src='./avatars/{$avatar_image_name}'>":'';
	?>
	<h3>Last 10 votes</h3>
	<table>
	<tr><th>Voted</th><th>Event</th><th>Question</th></tr>
	<? $rowClass = 'normal'; foreach($votes as $k => $v): $vote_value = ($v['vote_value'] > 0) ? '<img src="./images/thumbsUp.png">' : '<img src="./images/thumbsDown.png">'; ?>
	<tr class="<?=$rowClass?>"><td><?=$vote_value?></td><td><?=$v['event_name']?></td><td><?=$v['question_name']?></td></tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ; endforeach; ?>
	</table>
	<h3>Last 10 questions</h3>
	<table>
	<tr><th>Event</th><th>Question</th></tr>
	<? $rowClass = 'normal'; foreach($questions as $k => $v): ?>
	<tr class="<?=$rowClass?>"><td><?=$v['event_name']?></td><td><?=$v['question_name']?></td></tr>
	<? $rowClass = $rowClass == 'normal' ? 'alternate' : 'normal' ; endforeach; ?>
	</table>	
	<? if ($owner) { ?>
	<h2>Edit Profile</h2>	
	<div id="user_form">
	<?= form_open_multipart("user/updateProfile/$user_name"); ?>
	
	<?= form_format("Username: ",$user_name); ?>
	<?= form_format("Email: ",form_input('user_email',$user_email,'class="txt"') ); ?>
	<?= form_format("Display Name: ",form_input('user_display_name',$user_display_name,'class="txt"') ); ?>
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