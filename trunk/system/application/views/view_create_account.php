<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h2>Create Account</h2>	
  	<div class='errorArea'><?=$error;?></div>
	<div id="account_form">
	<?= form_open('user/create'); ?>
	
	<?= form_format("Username: *",form_input('user_name',$this->validation->user_name,'class="txt"') ); ?>
	<?= form_format("Password: *",form_password('user_password','','class="txt"') ); ?>
	<?= form_format("Password Confirm: *",form_password('password_confirm','','class="txt"') ); ?>
	<?= form_format("Email: *",form_input('user_email',$this->validation->user_email,'class="txt"') ); ?>
	
	
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