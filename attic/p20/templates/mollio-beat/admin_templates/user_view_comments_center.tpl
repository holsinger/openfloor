<br />
<table cellpadding=1 cellspacing=0 border=0 width=90%>
	<tr><th>Comment Content</th><th>Open Link</th><th>Edit Comment</th></tr>
	{section name=nr loop=$comments}
    <tr>
				{if $urlmethod eq 1}
				<td>{$comments[nr].comment_content}</td>
				<td><a href = "./story.php?id={$comments[nr].comment_link_id}" target="_blank">Open Link</a></td>
				<td><a href = "./edit.php?id={$comments[nr].comment_link_id}&commentid={$comments[nr].comment_id}" target="_blank">Edit Comment</a></td></tr>
				{else}
				
				<td>{$comments[nr].comment_content}</td>
				<td><a href = "/story/{$comments[nr].comment_link_id}/" target="_blank">Open Link</a></td>
				<td><a href = "/edit/{$comments[nr].comment_link_id}/{$comments[nr].comment_id}/" target="_blank">Edit Comment</a></td></tr>
				
				{/if}
				
				
    </tr>
	{/section}
	<tr><td colspan = 4><input type=button onclick="window.history.go(-1)" value="back to user" class="log2"></td></tr>
</table>