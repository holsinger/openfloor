{if $isAdmin eq 1}
 <fieldset><legend>{#PLIGG_Visual_Header_AdminPanel_Main#}</legend>
	<table style="border:none">
		<tr><td><a href="{$my_pligg_base}/admin_users.php">{#PLIGG_Visual_Header_AdminPanel_1#}</a></td></tr>
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/admin_categories.php">{#PLIGG_Visual_Header_AdminPanel_2#}</a></td></tr>{/if}
		{checkActionsTpl location="tpl_header_admin_main_links"}
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/admin_backup.php">{#PLIGG_Visual_Header_AdminPanel_4#}</a></td></tr>{/if}
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/modules/modules_manage.php">{#PLIGG_Visual_Header_AdminPanel_6#}</a></td></tr>{/if}
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/admin_config.php">{#PLIGG_Visual_Header_AdminPanel_5#} {#PLIGG_Visual_Name#}</a></td></tr>{/if}
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/rss/rss_main.php" target="_blank">{#PLIGG_Visual_Header_AdminPanel_RSSImport#}</a></td></tr>{/if}
	</table>
</fieldset>	
{else}
	{#PLIGG_Visual_Header_AdminPanel_NoAccess#}
{/if}
