<?php

?>	
	<div id="login1" style="display:none;text-align:left;">
	<p>Please enter a username below or Log in to get started: </p>     
	
	<?= form_open('user/create_demo_user'); ?>
	<?= form_hidden('redirect',$this->uri->uri_string()); ?>
	<?= form_format("Username: ",form_input('user_name','','class="txt_user" id="username"') ); ?><br/>
	<?= form_submit('','Get a One Time Account','class="button"'); ?>
	<?= form_close(); ?>
	<br/>	<h2>Log in</h2>
	<?= form_open('user/login'); ?>
	<?= form_format("Username: ",form_input('user_name','','class="txt_user" id="username"') ); ?>
	<?= form_format("Password: ",form_password('user_password','','class="txt_user"') ); ?>
	<?= form_hidden('redirect',$this->uri->uri_string()); ?>
	<br /><br /><?= form_submit('','Login','class="button"'); ?>
	<div id="userloginprompt"><small>You must have cookies enabled to log in to OpenFloor</small></div>
		<?= form_close(); ?>
	<? /*<br /><?= anchor('/user/password_reset','Forgot your username or password?','class="link"'); ?>*/?>

	<br /><br />
	
         
</div>
