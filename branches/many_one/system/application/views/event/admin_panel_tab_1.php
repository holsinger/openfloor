<? if($avatar_image_path): ?>
	<img src="<?=$avatar_image_path?>" border="0" />
	<br /><br />
<? endif; ?>
<strong>Event Name:</strong><br/>
<span class="field_display"><?=$event_name?></span>
<br /><br />
<strong>Event Description Brief:</strong><br/>
<span class="field_display"><?=$event_desc_brief?></span>
<br /><br />
<strong>Event Description:</strong><br/>
<span class="field_display"><?=$event_desc?></span>
<br /><br />
<strong>Event Date:</strong><br/>
<span class="field_display"><?=date("F j, Y, g:i a", strtotime($event_date));?></span>
<br /><br />
<strong>Event Location:</strong><br/>
<span class="field_display"><?=$location?></span>
<br /><br /><br />
<input type="button" class="button" onclick="window.location=site_url+'event/create_event/<?=$event_id?>/edit';" value="Edit Information" />
<input type="button" name="back_but" value="Back to Event" id="back_but" onclick="window.location=site_url+'forums/cp/<?=$event_url_name?>';" class="button">