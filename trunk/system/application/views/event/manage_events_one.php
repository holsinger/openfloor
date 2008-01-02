<? 
include("./fckeditor/fckeditor.php");
$data['sub_title'] = $page_title;
$this->load->view('view_layout/header.php', $data);
?>
<!--
	#dependency scal.js
	#dependency scal.css
	#dependency events.css
-->
<div id="content_div">
  	<div class='errorArea'><?=$this->validation->error_string;?></div>
	<div id="account_form">
		<?= form_open_multipart(($event_id)?"event/create_event/$event_id/$option":"event/create_event/", array('name'=>'my_form')); ?>
			<label>Event Name: *</label>
			<small>Write the name of the event.</small><br />
			<input name="event_name" value="<?=$event_name?>" size="45" class="txt" maxlength="100">
			<br /><br />
			<label>Event Description Brief: *</label>
			<small>Write a brief description of the event. (will be displayed on the events page).</small><br />
			<textarea name="event_desc_brief" rows="2" cols="48" class="txt"><?=$event_desc_brief?></textarea>
			<br /><br />
			<label>Event Description: *</label>
			<small>Write a description of the event.</small><br />
			<?
		     $oFCKeditor = new FCKeditor('event_desc') ;
		     $oFCKeditor->BasePath = 'fckeditor/' ;
		     $oFCKeditor->Height = '180';  $oFCKeditor->Width = '500';  $oFCKeditor->ToolbarSet = 'Basic';
			 $oFCKeditor->Value	 = $event_desc;
			 $oFCKeditor->Create() ;
			?>
			<br />
			<label>Event Avatar</label>
			<small>Must be less then 1024 kb & 1024px768px (image will be resized)</small><br />
			<?= form_upload('userfile','$event_avatar','class="txt"') ?>
			<br /><br />
			<label>Event Date:</label>
			<small>Select the data that the event will be taking place on.</small><br />
			<div id="samplecal" class="scal"></div>
			<input id="date_selected" name="date_selected" type="hidden" value="<?=$date_selected?>" />
			<br />
			<label>Event Time:</label>
			<small>The specific time the event will be taking place ([Hour]:[Minutes]).</small><br />
			<input type="text" name="event_time" value="<?=$event_time?>" class="txt" size="5"/>
			<?
			$drop_array = array(
				"am" => "AM",
				"pm" => "PM"
			);
			?>
			<?=form_dropdown("am_pm", $drop_array, $am_pm)?>
			<br /><br />
			<label>Event Location: *</label>
			<small>Write a description of the event location, directions etc.</small><br />
			<textarea name="location" rows="3" cols="48" class="txt"><?=$location?></textarea>
			<br /><br />
			<? if($option == 'edit'): ?>
				<input type="button" name="cancel_but" value="Cancel" id="cancel_but" onclick="window.location=site_url+'event/admin_panel/<?=$event_id?>';" class="button">
				<?= form_submit('','Update Information','class="button"'); ?>
			<? else: ?>
				<?= form_submit('','Next Step','class="button"'); ?>
			<? endif; ?>
			<br /><br />
			<small>* required fields</small>
		<?= form_close(); ?>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	var samplecal = new scal('samplecal', on_scal_update, {
		updateformat: 'yyyy-mm-dd',
		year: <?=substr($date_selected, 0, 4)?>,
		month:<?=substr($date_selected, 5, 2)?>,
		day: <?=substr($date_selected, 8, 2)?>
	});
	function on_scal_update(date){
		$('date_selected').value = date.format('yyyy-mm-dd');
	}
</script>
<? $this->load->view('view_layout/footer.php'); ?>