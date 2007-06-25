<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h2>Edit Event </h2>	
  	<div class='errorArea'><?=$error;?></div>
	<div id="account_form">
	<?= form_open('event/edit_event_action/' . $event_id); ?>
	
	<?= form_format("Event Name: *",form_input('event_name',$this->validation->event_name,'class="txt"') ); ?>
	<?= form_format("Event Description: *",form_input('event_desc',$this->validation->event_desc,'class="txt"') ); ?>
	<?= form_format("Event Avatar: *",form_input('event_avatar',$this->validation->event_avatar,'class="txt"') ); ?>
	<?= form_format("Sunlight ID: *",form_input('sunlight_id',$this->validation->sunlight_id,'class="txt"') ); ?>
	<?= form_format("Event Date: *",form_input('event_date',$this->validation->event_date,'class="txt"') ); ?>
	<?= form_format("Event Location: *",form_input('location',$this->validation->location,'class="txt"') ); ?>

	<br /><br />
	<br /><br />
	<?= form_submit('','Edit Event','class="button"'); ?>
	<br /><br />
	<small>* required fields</small>
	<?= form_close(); ?>
	</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>