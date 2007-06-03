{config_load file=$messaging_lang_conf}
{include file=$messaging_tpl_path."messaging_lightbox.tpl"}
	{if $messages neq 0}
	{if $pagename eq "index"}
		<div id="messages"><center>
			{#PLIGG_MESSAGING_YouHave#}<b>{$messages}</b>{#PLIGG_MESSAGING_NewMessages#}
			<img src="{$messaging_path}images/viewnow.png" alt="{#PLIGG_MESSAGING_ViewNow#}" align="absmiddle" /> <a href="#view_message" rel="{$rel_viewmsg}" class="lbOn">{#PLIGG_MESSAGING_ViewNow#}</a> | 
			<img src="{$messaging_path}images/gotoinbox.png" alt="{#PLIGG_MESSAGING_GoToMyInbox#}" align="absmiddle" /> <a href = "{$URL_user_inbox}">{#PLIGG_MESSAGING_GoToMyInbox#}</a>
			&nbsp;&nbsp;<a href="#" onclick="Effect.Fade('messages');"><img src="{$messaging_path}images/cross.png" class="{#PLIGG_MESSAGING_Close#}" alt="{#PLIGG_MESSAGING_Close#}" align="absmiddle" border="0" /></a>
		</center></div>
	{/if}
	{/if}


{* this is a temporary fix. When you load a new config file the existing config gets dropped. *}
{config_load file="/libs/lang.conf"}