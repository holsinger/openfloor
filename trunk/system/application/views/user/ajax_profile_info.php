<strong>Display Name:</strong><br/>
<span class="field_display"><?=$display_name?></span>
<br /><br />
<strong>User Email:</strong><br/>
<span class="field_display"><?=$user_email?></span>
<br /><br />
<strong>Bio:</strong><br/>
<span class="field_display"><?=$bio?></span>
<br /><br /><br />
<? if($edit_permission): ?>
	<input type="button" class="button" onclick="window.location=site_url+'user/edit_user/<?=$user_id?>';" value="Edit Information" />
<? endif; ?>
