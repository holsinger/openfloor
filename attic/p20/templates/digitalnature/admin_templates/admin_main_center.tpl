{if $isAdmin eq 1}
  
  <fieldset><legend>Admin Panel</legend>
	<table style="border:none" cellspacing="5">
		<tr><td><a href="{$URL_admin_users}">User Management</a></td></tr>
		{if $amIgod eq 1}
		<tr><td><a href="{$URL_admin_categories}">Category Management</a></td></tr>
		{checkActionsTpl location="tpl_header_admin_main_links"}
		<tr><td><a href="{$URL_admin_backup}">File and MySQL Backup</a></td></tr>
		<tr><td><a href="{$URL_admin_modules}">{#PLIGG_Visual_Header_AdminPanel_6#}</a></td></tr>		
		<tr><td><a href="{$URL_admin_config}">Configure {#PLIGG_Visual_Name#}</a></td></tr>
		<tr><td><a href="{$URL_admin_rss}" target="_blank">RSS Importer</a></td></tr>
		{/if}
	</table>
</fieldset>	

{else}
	{#PLIGG_Visual_Header_AdminPanel_NoAccess#}
{/if}
