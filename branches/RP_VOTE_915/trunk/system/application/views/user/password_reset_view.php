<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
	<h3>Reset Password</h3>	
	<div class='errorArea'><?=$error;?></div>
	<?=form_open('user/password_reset_form')?>
	<?=form_format('Your e-mail address: ', form_input(array('name' => 'user_email', 'class' => 'txt')))?>
	<?=form_submit(array('class' => 'button', 'value' => 'Reset Password'))?>
	<?=form_close()?>
</div>

<?$this->load->view('view_includes/footer.php');?>