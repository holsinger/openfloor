{config_load file=$messaging_lang_conf}
<center>
	<span class="success" style="border:solid 1px #269900; padding: 6px 6px 6px 6px">
		<img src="{$messaging_path}images/yes.png" align="absmiddle"> 
			{#PLIGG_MESSAGING_SentSuccess#}
	</span>
	<br /><br />
	<a href="#" onclick="{$js_close}">{#PLIGG_MESSAGING_Close#}</a> <a href="#" onclick="{$js_close}"><img src="{$messaging_path}images/cross.png" align="absmiddle" /></a>
</center>