<fieldset><legend>{#PLIGG_Visual_Change_Link_Status#}</legend>
<b>{#PLIGG_Visual_Change_Link_Title#}:</b> {$link_title} <br /><br />
<b>{#PLIGG_Visual_Change_Link_URL#}:</b> {$link_url} <a href = "{$my_base_url}{$my_pligg_base}/manage_banned_domains.php?id={$link_id}&add={$banned_domain_url}">{#PLIGG_Visual_Ban_This_URL#}</a><br /><br />
<b>{#PLIGG_Visual_Change_Link_Content#}:</b> {$link_content}<br /><br />
<b>{#PLIGG_Visual_Change_Link_Status2#}:</b> {$link_status|capitalize}<br /><br />
<b>{#PLIGG_Visual_Change_Link_Submitted_By#}:</b> {$user_login} <a href ="{$my_base_url}{$my_pligg_base}/admin_users.php?mode=disable&user={$user_login}">{#PLIGG_Visual_Disable_This_USer#}</a><br /><br />
<hr />
Are you sure you want to set the status to {$action}?<br /><br />
<a href = "{$admin_modify_url}">No</a><br /><br />
{if $action neq "discard"}<a href = "{$admin_modify_do_url}">Yes (will not notify submitter)</a><br /><br />
{else}<a href = "{$admin_modify_edo_url}">Yes (notify submitter)</a> 	 
{/if}
