<?php
// fckeditor
include("./fckeditor/fckeditor.php");

function richField($name, $value)
{
	$oFCKeditor 			= new FCKeditor($name) ;
	$sBasePath 				= 'fckeditor/';
	$oFCKeditor->BasePath 	= $sBasePath ;
	$oFCKeditor->ToolbarSet = 'Basic';
	$oFCKeditor->Height 	= '100';
	$oFCKeditor->Width 		= '367';
	$oFCKeditor->Value 		= $value;
	return $oFCKeditor->CreateHtml();
}

?>
	
<? $this->load->view('view_includes/header.php'); ?>

<div id="content_div">
  <h2>Edit Event </h2>	
  	<div class='errorArea'><?=$error;?></div>
	<div id="account_form">
	<?= form_open_multipart('event/edit_event_action/' . $event_id, array('name'=>'my_form')); ?>
	<label>Event Type:</label>
	<?= $this->validation->event_type;?>
	<?= form_format("Event Name: *",form_input('event_name',$this->validation->event_name,'class="txt"') ); ?>
	<?
	echo form_format("Event Description Brief: *", richField('event_desc_brief', $this->validation->event_desc_brief), 'Write a brief description of the event. (will be displayed on the events page)');
	echo form_format("Event Description: *", richField('event_desc', $this->validation->event_desc), 'Write a description of the event.');
	?>
	<?= isset($avatar_image_name)?"<br /><img src=\"./avatars/<?=$avatar_image_name;/>\"":'' ?>
	<? // echo form_format("Event Avatar:",form_input('event_avatar',$this->validation->event_avatar,'class="txt"') ); ?>
	<?= form_format("Event Avatar: ",form_upload('userfile','$this->validation->event_avatar','class="txt"'),'must be less then 1024 kb & 1024px768px (image will be resized)' ); ?>
	
	<label>Event Date:</label>
	<?php echo js_calendar_write('event_date', time(), true); ?>
	<input type="text" name="event_date" value="<?=/*substr(*/$this->validation->event_date/*, 0, 10)*/?>" onblur="update_calendar(this.name, this.value);" class="txt"/>
	<p><a href="javascript:void(0);" onClick="set_to_time('event_date', '<?php echo time(); ?>')" >Today</a></p>
	
	<?//echo form_format("Sunlight ID:",form_input('sunlight_id','','class="txt"') ); ?>
	<?//echo form_format("Event Date: *",form_input('event_date','','class="txt"') ); ?>
	
	<?
	echo form_format("Event Location: *", richField('location', $this->validation->location), 'Write a description of the event location, directions etc.');
	
	echo form_format("Moderator Info: ", richField('moderator_info', $this->validation->moderator_info));
	 
	echo form_format("Agenda: ", richField('agenda', $this->validation->agenda));
	
	echo form_format("Rules: ", richField('rules', $this->validation->rules));
	
	echo form_format("Other Instructions: ", richField('other_instructions', $this->validation->other_instructions));
	
	$format = array(
			'name'	=>	'stream_high',
			'value'	=>	$this->validation->stream_high,
			'rows'	=>	'5',
			'cols'	=>	'48',
			'class'	=>	'txt',
		);
	echo form_format("High Stream Code: ", form_textarea($format));
	$format = array(
			'name'	=>	'stream_low',
			'value'	=>	$this->validation->stream_low,
			'rows'	=>	'5',
			'cols'	=>	'48',
			'class'	=>	'txt',
		);
	echo form_format("Low Stream Code: ", form_textarea($format));
	$format = array(
			'name'	=>	'blocked_ips',
			'value'	=>	$this->validation->blocked_ips,
			'rows'	=>	'5',
			'cols'	=>	'48',
			'class'	=>	'txt',
		);
	echo form_format("Blocked IPs: ", form_textarea($format));
	$format = array(
	                  '0'  => 'no',
	                  '1' => 'yes',
	                );

	echo form_format("Streaming:", form_dropdown('streaming', $format, $this->validation->streaming));
	?>
	
	<br /><br />
	<br /><br />
	<?= (isset($avatar_image_name) && !empty($avatar_image_name))?form_hidden('old_avatar','./avatars/'.$avatar_image_name):'';?>
	<?= form_submit('','Edit Event','class="button"'); ?>
	<br /><br />
	<small>* required fields</small>
	<?= form_close(); ?>
	</div>

</div>

<? $this->load->view('view_includes/footer.php'); ?>