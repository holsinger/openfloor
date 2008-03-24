<?php

?>

<div id="login" style="display:none;text-align:left;">
         
	<h2>Log in</h2>
	<div id="userloginprompt"><p>You must have cookies enabled to log in to OpenFloor</p></div>
	
	<?= form_open('user/create_demo_user'); ?>
	<?= form_hidden('redirect',$this->uri->uri_string()); ?>
	<?= form_format("Username: ",form_input('user_name','','class="txt" id="username"') ); ?><br/>
	<?= form_submit('','Use a Demo Account','class="button"'); ?>
	<?= form_close(); ?>
	
	<?= form_open('user/login'); ?>
	<?= form_format("Username: ",form_input('user_name','','class="txt" id="username"') ); ?>
	<?= form_format("Password: ",form_password('user_password','','class="txt"') ); ?>
	<?= form_hidden('redirect',$this->uri->uri_string()); ?>
	<br /><br /><?= form_submit('','Login','class="button"'); ?>
	<br /><br /><?= anchor('/user/password_reset','Forgot your username or password?','class="link"'); ?>
	<?= form_close(); ?>
	
	<br /><br />
	
         
</div>
