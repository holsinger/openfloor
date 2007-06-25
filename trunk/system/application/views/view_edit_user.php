<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h2>Edit User </h2>	
  	<div class='errorArea'><?=$error;?></div>
	<div id="account_form">
	<?= form_open('user/edit_user_action/' . $user_id); ?>
	
	<?= form_format("User Name: *",form_input('user_name',$this->validation->user_name,'class="txt"') ); ?>
	<?= form_format("Password: *",form_input('user_password',$this->validation->user_password,'class="txt"') ); ?>
	<?= form_format("Avatar: *",form_input('user_avatar',$this->validation->user_avatar,'class="txt"') ); ?>
	<?= form_format("Display Name: *",form_input('user_display_name',$this->validation->user_display_name,'class="txt"') ); ?>
	
	<br /><br />
	<br /><br />
	<?= form_submit('','Edit User','class="button"'); ?>
	<br /><br />
	<small>* required fields</small>
	<?= form_close(); ?>
	</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>