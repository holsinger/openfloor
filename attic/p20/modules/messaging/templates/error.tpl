{config_load file=$messaging_lang_conf}
<p>
	{#PLIGG_MESSAGING_Error#}
	<br />
	{$message}
	<a href="#" onclick="{$js_close}">{#PLIGG_MESSAGING_Close#}</a> <a href="#" onclick="{$js_close}"><img src="{$messaging_path}images/cross.png" align="absmiddle" /></a>
</p>