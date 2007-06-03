<br />
<table cellpadding=1 cellspacing=0 border=0 width=90%>
<tr><th>{#PLIGG_Visual_View_Links_Status#}</th><th>{#PLIGG_Visual_View_Links_New_Window#}</th></tr>
	{section name=nr loop=$links}
    
	<tr>
		<td>{$links[nr].link_status}</td>
		<td><a href = "{$my_pligg_base}/story.php?title={$links[nr].link_title_url}" target="_blank">{$links[nr].link_title}</a></td>
	</tr>
	
	{/section}
	
</table>
<br/>
<br/>
<input type=button onclick="window.history.go(-1)" value="{#PLIGG_Visual_View_Links_Back_To_User#}" class="log2">
