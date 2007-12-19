<? 
$data['sub_title'] = "Resume Event";
$this->load->view('view_includes/header.php', $data);
?>
<div id="content_div">
	<div id="account_form">
		<?= form_open("event/event_resume/", array('name'=>'unfinished_event_form', 'id'=>'unfinished_event_form')); ?>
		
			<label>Unfinished Events: *</label>
			<small>Select an unfinished event to continue creating it.</small><br />
			<?
			foreach($unfinished_events as $unfinished_event){
				$drop_array[$unfinished_event['event_id']] = $unfinished_event['event_name'];
			}
			?>
			<?=form_dropdown("unfinished_event", $drop_array)?>
			<br /><br />
			<input type="submit" class="button" value="Resume Selected Event">
			<input type="button" class="button" value="Create New Event" onclick="window.location=site_url+'event/create_event/none/ignore';">
			<br /><br />
			<small>* required fields</small>
		<?= form_close(); ?>
	</div>
</div>
<? $this->load->view('view_includes/footer.php'); ?>