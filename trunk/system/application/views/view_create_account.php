<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h2>Create Account</h2>	
  	<div class='errorArea'><?=$error;?></div>
	<div id="account_form">
	

	<? if ( isset($openID) ) { ?>
		<br />
		<?= form_open('user/create'); ?>
		<strong><img src='images/openid-icon-small.gif'> OpenID:</strong> 
		<?=$openID;?>
		<br />
		<?= form_hidden('user_openid',$openID); ?>
	<? } else { ?>
		<?= form_open('user/createOpenID'); ?>
		<?= form_format("<img src='images/openid-icon-small.gif'> OpenID: ",form_input('openid_url','','class="txt"') ); ?>
		<?= form_hidden('openid_action','create'); ?>
		<br />
		<div>
			<a href="http://www.myopenid.com/" class="link" target='_top'>Get an OpenID</a>
		</div>
		<br /><?= form_submit('','Validate','class="button"'); ?>
		<?= form_close(); ?>
		<br /><br />
		<?= form_open('user/create'); ?>
	<? } ?>
	
	
	<?= form_format("Username: *",form_input('user_name',(isset($this->validation->user_name))?$this->validation->user_name:'','class="txt"') ); ?>
	<? if ( !isset($openID) ) echo form_format("Password: *",form_password('user_password','','class="txt"') ); ?>
	<? if ( !isset($openID) ) echo form_format("Password Confirm: *",form_password('password_confirm','','class="txt"') ); ?>
	
	<?
	if (isset($openID_email)) $email = $openID_email;
	else if (isset($this->validation->user_email)) $email = $this->validation->user_email;
	else $email= '';
	?>
	<?= form_format("Email: *",form_input('user_email',$email,'class="txt"') ); ?>
	
	
	<br /><br />
	<?		
	echo $capimage;
	echo '<br />';
	echo '<label>Enter the above characters: *</label>';
	echo form_input('captcha','','class="txt"')
	?>
	<br /><br />
	<?= form_submit('','Create Account','class="button"'); ?>
	<br /><br />
	<small>* required fields</small>
	<?= form_close(); ?>
	</div>
	
</div>
<? $this->load->view('view_includes/footer.php'); ?>  				