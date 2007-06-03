{config_load file=$messaging_lang_conf}
<p>
	{#PLIGG_MESSAGING_DeleteAreYouSure#}{$msg_array.sender_name}?<br />
	<font color="#999999"> {#PLIGG_MESSAGING_Subject#}:</font> <b>{$msg_array.title}</b><br />
	
	<br />
	<center>
		<a href="javascript://" onclick="{$js_yes}">{#PLIGG_MESSAGING_Yes#}</a> <a href="javascript://" onclick="{$js_yes}"><img src="{$messaging_path}images/yes.png" align="absmiddle" /></a> | 
		<a href="#" onclick="{$js_close}">{#PLIGG_MESSAGING_No#}</a> <a href="#" onclick="{$js_close}"><img src="{$messaging_path}images/delete.png" align="absmiddle" /></a> | 
		<a href="#" onclick="{$js_close}">{#PLIGG_MESSAGING_Close#}</a> <a href="#" onclick="{$js_close}"><img src="{$messaging_path}images/cross.png" align="absmiddle" /></a>
	</center>
</p>
