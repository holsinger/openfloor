{config_load file=$messaging_lang_conf}
{* note: currently the "new" count only appears on index because thats the only page that checks to see if there are new messages *}
{* so it will have to be re-worked *}
{* {if $msg_new_count gt 0}({$msg_new_count} {#PLIGG_MESSAGING_New#}){/if}  *}

<li>
	<a href="{$URL_user_inbox}" class="main">
		<span>{#PLIGG_MESSAGING_Inbox#}</span>
	</a>
</li>

{* this is a temporary fix. When you load a new config file the existing config gets dropped. *}
{config_load file="/libs/lang.conf"}