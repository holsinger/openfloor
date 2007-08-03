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
		$format = array(
              'name'        => 'event_desc_brief',
              'id'          => 'event_desc_brief',
              'value'       => $this->validation->event_desc_brief,
              'rows'        => '2',
              'cols'        => '48',
              'class'       => 'txt'
            );
		echo form_format("Event Description Brief: *",form_textarea($format),'Write a brief description of the event. (will be displayed on the events page)' ); 
		?>
	<?
		$format = array(
              'name'        => 'event_desc',
              'id'          => 'event_desc',
              'value'       => $this->validation->event_desc,
              'rows'        => '3',
              'cols'        => '75',
              'class'       => 'txt'
            );
		echo form_format("Event Description: *",form_textarea($format),'Write a description of the event.' ); 
		?>
	<?= isset($avatar_image_name)?"<br /><img src=\"./avatars/<?=$avatar_image_name;/>\"":'' ?>
	<? // echo form_format("Event Avatar:",form_input('event_avatar',$this->validation->event_avatar,'class="txt"') ); ?>
	<?= form_format("Event Avatar: ",form_upload('userfile','$this->validation->event_avatar','class="txt"'),'must be less then 1024 kb & 1024px768px (image will be resized)' ); ?>
	
	
	<label>Politician:</label>
	<?= form_dropdown('sunlight_id', $politicians, $this->validation->sunlight_id, 'class="txt"')?>
	<?//echo form_format("Sunlight ID:",form_input('sunlight_id',$this->validation->sunlight_id,'class="txt"') ); ?>
	
	<label>Event Date:</label>
	<?php echo js_calendar_write('event_date', time(), true); ?>
	<input type="text" name="event_date" value="<?=substr($this->validation->event_date, 0, 10)?>" onblur="update_calendar(this.name, this.value);" class="txt"/>
	<p><a href="javascript:void(0);" onClick="set_to_time('event_date', '<?php echo time(); ?>')" >Today</a></p>
	
	<?//echo form_format("Sunlight ID:",form_input('sunlight_id','','class="txt"') ); ?>
	<?//echo form_format("Event Date: *",form_input('event_date','','class="txt"') ); ?>
	
	<?
		$format = array(
              'name'        => 'location',
              'id'          => 'location',
              'value'       => $this->validation->location,
              'rows'        => '3',
              'cols'        => '75',
              'class'       => 'txt'
            );
		echo form_format("Event Location: *",form_textarea($format),'Write a description of the event location, directions etc.' ); 
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