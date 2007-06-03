{config_load file=$messaging_lang_conf}

<p>
<h2 style="border-bottom:#ccc;">{#PLIGG_MESSAGING_SendAMessageTo#}{$msgToName}</h2>
<br />
<form method="post" action="user.php" class="f-wrap-1">
<b><span class="req">*</span>{#PLIGG_MESSAGING_Subject#}:</b><br />
<input id="msg_subject" name="msg_subject" type="text" class="f-name" tabindex="1" required="yes"><br />

<br /><br />
<b><span class="req">*</span>{#PLIGG_MESSAGING_Message#}:</b><br />
<textarea id="msg_body" name="msg_body" class="f-name" tabindex="2" rows="6" cols="30" requied="yes" /></textarea><br />


	<input type = "button" class="log2" value="{#PLIGG_MESSAGING_Send#}" tabindex="3" onclick="messaging_ajax_send();">
	<input type = "hidden" name="msg_to" id="msg_to" value="{$msgToName}">
	<input type = "hidden" name="view" id="view" value="sendmessage_send">
</form>

<br /><br />
<center><a href="#" onclick="{$js_close}">{#PLIGG_MESSAGING_Close#}</a> <a href="#" onclick="{$js_close}"><img src="{$messaging_path}images/cross.png" align="absmiddle" /></a></center>
</p>
