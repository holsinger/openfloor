<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
	<h3>Reset Password</h3>	
	<div class='errorArea'><?=$error;?></div>
	<?=form_open('user/reset_password_form', '', array('user_id' => $user_id, 'auth' => $auth))?>
	<?=form_format('New password: ', form_password(array('name' => 'user_password', 'class' => 'txt')))?>
	<?=form_format('Confirm new password: ', form_password(array('name' => 'user_password_confirm', 'class' => 'txt')))?>
	<?=form_submit(array('class' => 'button', 'value' => 'Reset Password'))?>
	<?=form_close()?>
</div>

<?$this->load->view('view_includes/footer.php');?>