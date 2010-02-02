<?php

?>

<div id="login" style="display:none;text-align:left;">
    <?/*<img id="close" src="images/close.gif" onclick="hideBox('login')" alt="Close" 
         title="Close this window" />*/?>
         
	<h2>Log in</h2>
	<p id="userloginlink">Don't have a login? <?=anchor('/user/createAccount', 'Create an account')?>.</p>
	<div id="userloginprompt"><p>You must have cookies enabled to log in to OpenFloor</p></div>
	
	<?= form_open('user/login'); ?>
	<?= form_format("Username: ",form_input('user_name','','class="txt" id="username"') ); ?>
	<?= form_format("Password: ",form_password('user_password','','class="txt"') ); ?>
	<?= form_hidden('redirect',$this->uri->uri_string()); ?>
	<br /><br /><?= form_submit('','Login','class="button"'); ?>
	<br /><br /><?= anchor('/user/password_reset','Forgot your username or password?','class="link"'); ?>
	<?= form_close(); ?>
	
	<br /><br />
	<a class="link" onClick="javascript:new Effect.toggle('open_id_login_div','blind', {queue: 'end'});"><strong>Click here to login with Open ID.</strong</strong></a>
	<div id="open_id_login_div" style="display: none;">
		<?= form_open('user/loginOpenID'); ?>
		<?= form_format("<img src='images/openid-icon-small.gif'> OpenID Login: ",form_input('openid_url','','class="txt"') ); ?>
		<?= form_hidden('openid_action','login'); ?>
		<?= form_hidden('redirect',$this->uri->uri_string()); ?>
		<?= form_hidden('openid_action','login'); ?>
		<br />
		<div>
			<small>To login with your OpenID please make sure you register your<br /> OpenID with us first by <?=anchor('user/createAccount','Creating an Account');?>.</small>
		</div>
		<br /><?= form_submit('','Login','class="button"'); ?>
		<?= form_close(); ?>
	</div>

	
         
</div>
