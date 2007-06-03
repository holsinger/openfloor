<div id="inside"><br />
	<table cellpadding=1 cellspacing=5 border=0 width=90% class="listing">
		<tr><th>Status</th><th>Title - Opens in new window.</th></tr>
		{section name=nr loop=$links}
    <tr>        				
					<td>{$links[nr].link_status}</td>
					<td><a href = "{$my_pligg_base}/story.php?title={$links[nr].link_title_url}" target="_blank">{$links[nr].link_title}</a></td>
					
    </tr>
		{/section}
		
		</table>
		<br />
		<br />
		<input type=button onclick="window.history.go(-1)" value="back to user" class="log2">
		