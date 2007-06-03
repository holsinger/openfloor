<div id="inside"><br />
<table cellpadding=1 cellspacing=5 border=0 width=90% class=listing>
	<tr><th>Comment Content</th><th>Open Link</th><th>Edit Comment</th></tr>
	{section name=nr loop=$comments}
    <tr>
				<td>{$comments[nr].comment_content}</td>
				<td><a href = "./story.php?id={$comments[nr].comment_link_id}" target="_blank">Open Link</a></td>
				<td><a href = "./edit.php?id={$comments[nr].comment_link_id}&commentid={$comments[nr].comment_id}" target="_blank">Edit Comment</a></td></tr>				
				
    </tr>
	{/section}
	</table>
	<br />
	<br />
	<input type=button onclick="window.history.go(-1)" value="back to user" class="log2">


