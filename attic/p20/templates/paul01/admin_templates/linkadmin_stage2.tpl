<fieldset><legend>Change link status</legend>
<b>Link Title:</b> {$link_title} <br /><br />
<b>Link URL:</b> {$link_url} <a href = "manage_banned_domains.php?id={$link_id}&add={$banned_domain_url}">Ban this URL</a><br /><br />
<b>Link Content:</b> {$link_content}<br /><br />
<b>Link Status:</b> {$link_status|capitalize}<br /><br />
<b>Link Submitted by:</b> {$user_login} <a href ="admin_users.php?mode=disable&user={$user_login}">Disable this user</a><br /><br />
<hr />
Are you sure you want to set the status to {$action}?<br /><br />
<a href = "{$admin_modify_url}">No</a><br /><br />
{if $action neq "discard"}
<a href = "{$admin_modify_do_url}">Yes (will not notify submitter)</a><br /><br />
{else} 	 
<a href = "{$admin_modify_edo_url}">Yes (notify submitter)</a> 	 
{/if}
