<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<? $this->load->view('view_layout/header.php',$data); ?>

<div id="content_div">
	<h3>Password Reset Successful</h3>	
	Your password was successfully reset, <?=anchor('user/login', 'Click here to login')?>.
</div>

<?$this->load->view('view_layout/footer.php');?>