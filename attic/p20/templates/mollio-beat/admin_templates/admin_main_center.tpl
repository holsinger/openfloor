{if $isAdmin eq 1}
 <fieldset><legend>Admin Panel</legend>
	<table style="border:none">
		<tr><td><a href="{$my_pligg_base}/admin_users.php">User Management</a></td></tr>
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/admin_categories.php">Category Management</a></td></tr>{/if}
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/admin_modifylanguage.php">Modify Language</a></td></tr>{/if}
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/admin_backup.php">File and MySQL Backup</a></td></tr>{/if}
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/modules/modules_manage.php">{#PLIGG_Visual_Header_AdminPanel_6#}</a></td></tr>{/if}
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/admin_config.php">Configure {#PLIGG_Visual_Name#}</a></td></tr>{/if}
		{if $amIgod eq 1}<tr><td><a href="{$my_pligg_base}/rss/rss_main.php" target="_blank">RSS Importer</a></td></tr>{/if}
	</table>
</fieldset>	
{else}
	{#PLIGG_Visual_Header_AdminPanel_NoAccess#}
{/if}
