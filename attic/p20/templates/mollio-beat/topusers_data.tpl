{* load language file *}
{config_load file="/libs/lang.conf"}

<tr class="withover">

{* display user name *}
<td class="short"><a href="{$user_userlink}">{$user_username}</a></td>

{* display number of links *}
<td class="short">{$user_total_links}</td>
	
	{* if number of links is greater than zero *}
	{if $user_total_links gt 0} 

      {* display number of published links and their percentage out of the total published links *}
	<td class="short">{$user_published_links}&nbsp;({$user_published_links_percent}%)</td>
	
	{else}
	<td class="short">{$user_published_links}&nbsp;(-)</td>
	{/if}

{* display number of comments *}
<td class="short">{$user_total_comments}</td>

{* display number of votes *}
<td class="short">{$user_total_votes}</td>

	{* if number of votes is greater than zero *}
	{if $user_total_votes gt 0}

	{* display number of votes and their percentage out of the total votes *}
	<td class="short">{$user_published_votes}&nbsp;({$user_published_votes_percent}%)</td>
	
	{else}
	<td class="short">{$user_published_votes}&nbsp;(-)</td>
	{/if}

{* display user's karma *}
<td class="short">{$user_karma}</td>

</tr>
