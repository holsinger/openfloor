<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h2>Login</h2>	
  	<div class='errorArea'><?=$error;?></div>
  	<br />
	<div id="login_form">
	<?= form_open('user/login'); ?>
	<?= form_format("Username: ",form_input('user_name',$this->validation->user_name,'class="txt"') ); ?>
	<?= form_format("Password: ",form_password('user_password','','class="txt"') ); ?>
	<br /><br /><?= form_submit('','Login','class="button"'); ?>
	<?= form_close(); ?>
	</div>
	<br /><br />
	<?= form_open('user/loginOpenID'); ?>
	<?= form_format("OpenID Login: ",form_input('openid_url','','class="txt"') ); ?>
	<?= form_hidden('openid_action','login'); ?>
	<br />
	<div><a href="http://www.myopenid.com/" class="link" target='_top'>Get an OpenID</a></div>
	<br /><?= form_submit('','Login','class="button"'); ?>
	<?= form_close(); ?>
	
</div>
<? $this->load->view('view_includes/footer.php'); ?>  				