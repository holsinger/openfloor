<fieldset><legend>Change link status</legend>
<b>Link Title:</b> {$link_title} <br /><br />
<b>Link URL:</b> {$link_url} <a href = "manage_banned_domains.php?id={$link_id}&add={$banned_domain_url}">Ban this URL</a><br /><br />
<b>Link Content:</b> {$link_content}<br /><br />
<b>Link Status:</b> {$link_status|capitalize}<br /><br />
<b>Link Submitted by:</b> {$user_login} <a href ="admin_users.php?mode=disable&user={$user_login}">Disable this user</a><br />

<hr />
				
<a href = "{$admin_discard_url}">Set to "discard"</a> - A "discard" link will disappear and will not be shown unless directly opened.<br /><br />
<a href = "{$admin_queued_url}">Set to "queued"</a> - A "queued" link is one that has not yet made it to the front page.<br /><br />
<a href = "{$admin_published_url}">Set to "published"</a> - A "published" link is one that has made it to the front page.<br /><br /></fieldset>

