<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h2>Manage Events</h2>	
  	<div id="account_form">

	<p><?=anchor('/event/create_event','Create an event')?>

	<?=$this->table->generate($events)?>
	
	</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>