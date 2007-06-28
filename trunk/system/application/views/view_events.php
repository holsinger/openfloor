<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h2>View Events</h2>	
  	<div id="account_form">

	<p><? if ($this->userauth->isAdmin()) echo anchor('/event/create_event','Create an event');?>

	<? //echo $this->table->generate($events)?>
	<? foreach ($events as $key => $array) {?>
		<div id='event<?=$array['event_id'];?>' class='event-summary'>
		<br /><strong><?=$array['event_name'];?></strong>
		<span style"float:right;"><?=$array['event_avatar'];?></span>
		<br /><b>When:</b> <?=$array['event_date'];?>
		<br /><b>Where:</b> <?=$array['location'];?>
		<br /><?=$array['event_desc'];?>
		<? if ($this->userauth->isAdmin()) echo "<br />".$array['edit'];?>
		</div>
	<? }?>
	</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>