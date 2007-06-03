<br />
	<table cellpadding=1 cellspacing=0 border=0 width=90%>
		<tr><th>Status</th><th>Title - Opens in new window.</th></tr>
		{section name=nr loop=$links}
    <tr>
                    {if $urlmethod eq 1}					
					<td>{$links[nr].link_status}</td>
					<td><a href = "{$my_pligg_base}/story.php?title={$links[nr].link_title_url}" target="_blank">{$links[nr].link_title}</a></td>
					
					{else}					
					
                    <td>{$links[nr].link_status}</td>
                    <td><a href = "{$my_pligg_base}/story/{$links[nr].link_id}/" target="_blank">{$links[nr].link_title}</a></td>
					
					{/if}
    </tr>
		{/section}
		<tr></tr>
		<tr><td colspan = 3><input type=button onclick="window.history.go(-1)" value="back to user" class="log2"></td></tr>
		</table>