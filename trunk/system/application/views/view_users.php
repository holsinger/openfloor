<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h2>Manage Users</h2>	
  	<div id="account_form">

	<p><?=anchor('/user/createAccount','Create a new user account')?>

	<?=$this->table->generate($users)?>
	
	</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>