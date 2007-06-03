{config_load file=$messaging_lang_conf}
{include file=$messaging_tpl_path."messaging_lightbox.tpl"}
{if $page_name eq "inbox"}
	<br>
	
	{* table to display messages *}
	<table class="listing">
		<tr><th>{#PLIGG_MESSAGING_From#}</th><th>{#PLIGG_MESSAGING_Subject#}</th><th>{#PLIGG_MESSAGING_Sent#}</th></tr>
		
		{if $msg_array neq ""}
		
		{section name=themessage loop=$msg_array}
			<tr id="msg_row_{$msg_array[themessage].id}">
				<td>{$msg_array[themessage].sender_name}</td>
				<td>
					{if $msg_array[themessage].readed eq 0}<b> <img src="{$messaging_path}images/new.png" align="absmiddle" /> </b>&nbsp;{/if}
					<a href="#view_message" rel="{$rel_viewmsg}{$msg_array[themessage].id}" class="lbOn">
						{$msg_array[themessage].title}
					</a>
				</td>
				<td>{$msg_array[themessage].date}</td>
			</tr>
		{/section}
		
		{else}
		
		<tr><td colspan="3"><center><b>{#PLIGG_MESSAGING_No_Messages#}</b></center></td></tr>
		
		{/if}
		
	</table>
{/if}

{* this is a temporary fix. When you load a new config file the existing config gets dropped. *}
{config_load file="/libs/lang.conf"}