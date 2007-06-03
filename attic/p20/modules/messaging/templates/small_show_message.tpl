{config_load file=$messaging_lang_conf}

{literal}
	<style type="text/css">
		table td { background:none }
	</style>
{/literal}

<p>
	<table style="border:none;" cellspacing="5">
		<tr>
			<td align="right" style="color:#999999">{#PLIGG_MESSAGING_From#}:</td><td><b> {$msg_array.sender_name}</b></td>
		</tr>

		<tr>
			<td align="right" style="color:#999999">{#PLIGG_MESSAGING_Sent#}:</td><td><b>{$msg_array.date}</b></td>
		</tr>
		
		<tr>
			<td align="right" style="color:#999999">{#PLIGG_MESSAGING_Subject#}:</td><td><b> {$msg_array.title}</b></td>
		</tr>
		
		<tr>
			<td align="right" style="color:#999999">{#PLIGG_MESSAGING_Message#}:</td><td><b> {$msg_array.body}</b></td>
		</tr>
	</table>
	
	<br /><br />

	<hr />
	<br />
	<center>
		<a href="javascript://" onclick="{$js_reply}">{#PLIGG_MESSAGING_Reply#}</a> <a href="javascript://" onclick="{$js_reply}"><img src="{$messaging_path}images/reply.png" align="absmiddle" /></a> | 
		<a href="javascript://" onclick="{$js_delete}">{#PLIGG_MESSAGING_Delete#}</a> <a href="javascript://" onclick="{$js_delete}"><img src="{$messaging_path}images/delete.png" align="absmiddle" /></a> | 
		<a href="#" onclick="{$js_close}">{#PLIGG_MESSAGING_Close#}</a> <a href="#" onclick="{$js_close}"><img src="{$messaging_path}images/cross.png" align="absmiddle" /></a>
	</center>
</p>