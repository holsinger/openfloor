<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h3>Create Account</h3>	
	<div id="account_form">
	<?= form_open('create_account/createUser'); ?>
	
	<?= form_format("Username: ",form_input('user_name','','class="txt"') ); ?>
	<?= form_format("Password: ",form_password('user_password','','class="txt"') ); ?>
	<?= form_format("Upload an Avatar: ",form_upload('user_avatar','','class="txt"') ); ?>
	<?= form_format("Display Name: ",form_input('user_display_name','','class="txt"') ); ?>
	<br /><br />
	<?= form_submit('','Create Account'); ?>
	<?= form_close(); ?>
	</div>
</div>
<? $this->load->view('view_includes/footer.php'); ?>  				