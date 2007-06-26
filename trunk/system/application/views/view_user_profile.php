<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h2>User Profile</h2>	
  	<div class='errorArea'><?=$error;?></div>
	<?
	echo "<br /><strong> Username: </strong> ".$user_name;
	echo "<br /><strong> Email: </strong> ".$user_email;
	echo "<br /><strong> Display Name: </strong> ".$user_display_name;
	echo "<br /><strong> OpenID: </strong> ".$user_openid;
	echo "<br /><strong> Avatar: </strong> ".$user_avatar;	
	?>
	<? if ($owner) { ?>
	<h2>Edit Profile</h2>	
	<div id="user_form">
	<?= form_open_multipart('user/create'); ?>
	
	<?= form_format("Username: ",form_input('user_name',$user_name,'class="txt"') ); ?>
	<?= form_format("Email: ",form_input('user_email',$user_email,'class="txt"') ); ?>
	<?= form_format("Display Name: ",form_input('user_display_name',$user_display_name,'class="txt"') ); ?>
	<?= form_format("OpenID: ",form_input('user_openid',$user_openid,'class="txt"') ); ?>
	<?= form_format("Avatar: ",form_upload('user_avatar',$user_avatar,'class="txt"'),'must be less then 250 kb & 640x480px' ); ?>
	<br /><br />
	<?= form_submit('','Update Profile','class="button"'); ?>
	<?= form_close(); ?>
	</div>
	<? } else {//end if owner ?>
	show results
	<? } ?>
</div>
<? $this->load->view('view_includes/footer.php'); ?>  				