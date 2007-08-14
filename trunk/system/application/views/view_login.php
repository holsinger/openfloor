<? $data['red_head'] = 'Welcome'; ?>
<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
  <h2>Login</h2>	
  	<div class='errorArea'><?=$error;?></div>
  	<br />
	<div id="login_form">
	<?= form_open('user/login'); ?>
	<?= form_format("Username: ",form_input('user_name',(isset($this->validation->user_name)) ? $this->validation->user_name:'','class="txt"') ); ?>
	<?= form_format("Password: ",form_password('user_password','','class="txt"') ); ?>
	<?= isset($location) ? form_hidden('redirect', $location) : '' ?>
	<br /><br /><?= form_submit('','Login','class="button"'); ?>
	<!-- <small><?=anchor('user/password_reset', 'Forgot your password?')?></small> -->
	<?= form_close(); ?>
	</div>
	<br /><br />
	<?= form_open('user/loginOpenID'); ?>
	<?= form_format("<img src='images/openid-icon-small.gif'> OpenID Login: ",form_input('openid_url','','class="txt"') ); ?>
	<?= form_hidden('openid_action','login'); ?>
	<br />
	<div>
		<small>To login with your OpenID please make sure you register your<br /> OpenID with us first by <?=anchor('user/createAccount','Creating an Account');?>.</small>
	</div>
	<br /><?= form_submit('','Login','class="button"'); ?>
	<?= form_close(); ?>
	
</div>
<? $this->load->view('view_includes/footer.php'); ?>  				