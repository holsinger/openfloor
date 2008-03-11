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
	<div id="title">
		<div class="top"></div>
		<h1>Create Event</h1>
	</div>
	<div style="padding-left: 10px;">
		Events allow community participation.
		<br /><br />
	</div>
	<div class="header">
		<h3>Event Details</h3>
	</div>
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
			<?/*
			<label for="timezone">Time Zone</label>
			<small>Please select the time zone for your event.</small><br />
			<select id="timezone" name="timezone">
				<option value="Pacific/Apia">(GMT-11:00) Pacific: Apia</option>
				<option value="HST">(GMT-10:00) Pacific: Honolulu</option>
				<option value="US/Alaska">(GMT-9:00) US: Alaska</option>
				<option value="America/Los_Angeles">(GMT-8:00) America: Los Angeles</option>
				<option value="America/Phoenix">(GMT-7:00) America: Phoenix</option>

				<option value="America/Mazatlan">(GMT-7:00) America: Mazatlan</option>
				<option value="America/Denver" selected="selected" class="selected">(GMT-7:00) America: Denver</option>
				<option value="America/Belize">(GMT-6:00) America: Belize</option>
				<option value="America/Chicago">(GMT-6:00) America: Chicago</option>
				<option value="America/Mexico_City">(GMT-6:00) America: Mexico City</option>
				<option value="America/Regina">(GMT-6:00) America: Regina</option>

				<option value="America/Bogota">(GMT-5:00) America: Bogota</option>
				<option value="America/New_York">(GMT-5:00) America: New York</option>
				<option value="America/Indianapolis">(GMT-5:00) America: Indianapolis</option>
				<option value="America/Halifax">(GMT-4:00) America: Halifax</option>
				<option value="America/Caracas">(GMT-4:30) America: Caracas</option>
				<option value="America/Santiago">(GMT-3:00) America: Santiago</option>

				<option value="America/St_Johns">(GMT-3:30) America: St Johns</option>
				<option value="America/Sao_Paulo">(GMT-2:00) America: Sao Paulo</option>
				<option value="America/Buenos_Aires">(GMT-3:00) America: Buenos Aires</option>
				<option value="America/Godthab">(GMT-3:00) America: Godthab</option>
				<option value="Atlantic/South_Georgia">(GMT-2:00) Atlantic: South Georgia</option>
				<option value="Atlantic/Azores">(GMT-1:00) Atlantic: Azores</option>

				<option value="Atlantic/Cape_Verde">(GMT-1:00) Atlantic: Cape Verde</option>
				<option value="Africa/Casablanca">(GMT) Africa: Casablanca</option>
				<option value="Europe/Dublin">(GMT) Europe: Dublin</option>
				<option value="Europe/Berlin">(GMT+1:00) Europe: Berlin</option>
				<option value="Europe/Belgrade">(GMT+1:00) Europe: Belgrade</option>
				<option value="Europe/Paris">(GMT+1:00) Europe: Paris</option>

				<option value="Europe/Warsaw">(GMT+1:00) Europe: Warsaw</option>
				<option value="Europe/Athens">(GMT+2:00) Europe: Athens</option>
				<option value="Europe/Bucharest">(GMT+2:00) Europe: Bucharest</option>
				<option value="Africa/Cairo">(GMT+2:00) Africa: Cairo</option>
				<option value="Africa/Harare">(GMT+2:00) Africa: Harare</option>
				<option value="Europe/Helsinki">(GMT+2:00) Europe: Helsinki</option>

				<option value="Asia/Jerusalem">(GMT+2:00) Asia: Jerusalem</option>
				<option value="Asia/Baghdad">(GMT+3:00) Asia: Baghdad</option>
				<option value="Asia/Kuwait">(GMT+3:00) Asia: Kuwait</option>
				<option value="Europe/Moscow">(GMT+3:00) Europe: Moscow</option>
				<option value="Africa/Nairobi">(GMT+3:00) Africa: Nairobi</option>
				<option value="Asia/Tehran">(GMT+3:30) Asia: Tehran</option>

				<option value="Asia/Muscat">(GMT+4:00) Asia: Muscat</option>
				<option value="Asia/Baku">(GMT+4:00) Asia: Baku</option>
				<option value="Asia/Kabul">(GMT+4:30) Asia: Kabul</option>
				<option value="Asia/Yekaterinburg">(GMT+5:00) Asia: Yekaterinburg</option>
				<option value="Asia/Karachi">(GMT+5:00) Asia: Karachi</option>
				<option value="Asia/Calcutta">(GMT+5:30) Asia: Calcutta</option>

				<option value="Asia/Katmandu">(GMT+5:45) Asia: Katmandu</option>
				<option value="Asia/Almaty">(GMT+6:00) Asia: Almaty</option>
				<option value="Asia/Dhaka">(GMT+6:00) Asia: Dhaka</option>
				<option value="Asia/Colombo">(GMT+5:30) Asia: Colombo</option>
				<option value="Asia/Rangoon">(GMT+6:30) Asia: Rangoon</option>
				<option value="Asia/Bangkok">(GMT+7:00) Asia: Bangkok</option>

				<option value="Asia/Krasnoyarsk">(GMT+7:00) Asia: Krasnoyarsk</option>
				<option value="Asia/Hong_Kong">(GMT+8:00) Asia: Hong Kong</option>
				<option value="Asia/Irkutsk">(GMT+8:00) Asia: Irkutsk</option>
				<option value="Asia/Kuala_Lumpur">(GMT+8:00) Asia: Kuala Lumpur</option>
				<option value="Australia/Perth">(GMT+9:00) Australia: Perth</option>
				<option value="Asia/Taipei">(GMT+8:00) Asia: Taipei</option>

				<option value="Asia/Tokyo">(GMT+9:00) Asia: Tokyo</option>
				<option value="Asia/Seoul">(GMT+9:00) Asia: Seoul</option>
				<option value="Asia/Yakutsk">(GMT+9:00) Asia: Yakutsk</option>
				<option value="Australia/Adelaide">(GMT+10:30) Australia: Adelaide</option>
				<option value="Australia/Darwin">(GMT+9:30) Australia: Darwin</option>
				<option value="Australia/Brisbane">(GMT+10:00) Australia: Brisbane</option>

				<option value="Australia/Sydney">(GMT+11:00) Australia: Sydney</option>
				<option value="Pacific/Guam">(GMT+10:00) Pacific: Guam</option>
				<option value="Australia/Hobart">(GMT+11:00) Australia: Hobart</option>
				<option value="Asia/Vladivostok">(GMT+10:00) Asia: Vladivostok</option>
				<option value="Pacific/Noumea">(GMT+11:00) Pacific: Noumea</option>
				<option value="Pacific/Auckland">(GMT+13:00) Pacific: Auckland</option>

				<option value="Pacific/Fiji">(GMT+12:00) Pacific: Fiji</option>
				<option value="Pacific/Tongatapu">(GMT+13:00) Pacific: Tongatapu</option>
			</select>
			<br /><br />
			*/?>
			<label>Event Location:</label>
			<small>Write a description of the event location, directions etc.</small><br />
			<textarea name="location" rows="3" cols="48" class="txt"><?=$location?></textarea>
			<br /><br />
			<? if($option == 'edit'): ?>
				<input type="button" name="cancel_but" value="Cancel" id="cancel_but" onclick="window.location=site_url+'event/admin_panel/<?=$event_id?>';" class="button">
				
				<input type="button" name="back_but" value="Back to Event" id="back_but" onclick="window.location=site_url+'forums/cp/<?=$event_url_name?>';" class="button">
				<?= form_submit('','Update Information','class="button"'); ?>
			<? else: ?>
				<?= form_submit('','Next Step','class="button"'); ?>
			<? endif; ?>
			<br /><br />
			<small>* required fields</small>
		<?= form_close(); ?>
	</div>
	<div style="margin-top: 20px">
		<strong>
		POWERED BY OPENFLOOR TECHNOLOGY
		</strong>
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