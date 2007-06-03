{config_load file="/libs/lang.conf"}
</div>
</div>
</div>
<tr class="withover">
<td class="short"><a href="{$user_userlink}">{$user_username}</a></td>
<td class="short">{$user_total_links}</td>
{if $user_total_links gt 0} 
	<td class="short">{$user_published_links}&nbsp;({$user_published_links_percent}%)</td>
{else}
	<td class="short">{$user_published_links}&nbsp;(-)</td>
{/if}
<td class="short">{$user_total_comments}</td>
<td class="short">{$user_total_votes}</td>
{if $user_total_votes gt 0}
	<td class="short">{$user_published_votes}&nbsp;({$user_published_votes_percent}%)</td>
{else}
	<td class="short">{$user_published_votes}&nbsp;(-)</td>
{/if}
<td class="short">{$user_karma}</td>
</tr>
