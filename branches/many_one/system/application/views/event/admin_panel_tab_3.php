<strong>Access Type:</strong><br/>
<span class="field_display"><?=$access_type?></span>
<br /><br />
<?if($access_type == "private"):?>
	<?if($password_protect):?>
		<strong>Password Protect:</strong><br/>
		<span class="field_display">**********</span>
		<br /><br />
	<?endif;?>
	<?if($domain_limit):?>
		<strong>Domain Limit Name:</strong><br/>
		<span class="field_display"><?=$domain_limit_name?></span>
		<br /><br />
	<?endif;?>
<?endif;?>
<br />
<input type="button" class="button" onclick="window.location=site_url+'event/create_event_three/<?=$event_id?>/edit';" value="Edit Information" />
<input type="button" name="back_but" value="Back to Event" id="back_but" onclick="window.location=site_url+'forums/cp/<?=$event_url_name?>';" class="button">