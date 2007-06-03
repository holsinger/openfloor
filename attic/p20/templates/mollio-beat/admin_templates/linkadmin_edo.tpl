<fieldset><legend>Change link status</legend><br />
<strong>What is the reason?</strong><br /><br />
<form method="post">
	<input type="hidden" name = "id" value="{$link_id}">
	<input type="hidden" name = "action" value="edodiscard">
	<input type="radio" name="reason" value="spam">This is spam.<br />
	<input type="radio" name="reason" value="other">Other: <input type="text" name="otherreason" size="75">
	<br /><br /><input type = "submit" name = "submit" value = "submit" class="log2">
</form>