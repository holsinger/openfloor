<br/>
<table cellpadding=1 cellspacing=0 border=0 width=90%>
<tr><th>{#PLIGG_Visual_Login_Username#}</th><th>{#PLIGG_Visual_View_User_Level#}</th><th>{#PLIGG_Visual_View_User_Email#}</th></tr>
	{section name=nr loop=$userlist}
	<tr>
	<td><a href = "?mode=view&user={$userlist[nr].user_login}">{$userlist[nr].user_login}</a></td>
	<td>{$userlist[nr].user_level}</td>
	<td>{$userlist[nr].user_email}</td>
	</tr>
	{/section}
</table>
