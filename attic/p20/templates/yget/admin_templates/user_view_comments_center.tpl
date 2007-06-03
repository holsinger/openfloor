<br />
<table cellpadding=1 cellspacing=0 border=0 width=90%>
	<tr><th>{#PLIGG_Visual_View_Comments_Content#}</th><th>{#PLIGG_Visual_View_Comments_Open_Link#}</th><th>{#PLIGG_Visual_View_Comments_Edit#}</th></tr>
	{section name=nr loop=$comments}
    <tr>				
		<td>{$comments[nr].comment_content}</td>
		<td><a href = "{$my_pligg_base}/story.php?id={$comments[nr].comment_link_id}" target="_blank">{#PLIGG_Visual_View_Comments_Open_Link#}</a></td>
		<td><a href = "{$my_pligg_base}/edit.php?id={$comments[nr].comment_link_id}&commentid={$comments[nr].comment_id}" target="_blank">{#PLIGG_Visual_View_Comments_Edit#}</a></td>		
				
    </tr>
	{/section}
	
</table>
<br/>
<br/>
<input type=button onclick="window.history.go(-1)" value="{#PLIGG_Visual_View_Links_Back_To_User#}" class="log2">