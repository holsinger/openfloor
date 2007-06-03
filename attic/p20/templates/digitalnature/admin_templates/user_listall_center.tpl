<fieldset><legend>User Management</legend>
	<table cellpadding=1 cellspacing=5 border=0 width=90% class="listing">
	<tr><th>Username</th><th>Level</th><th>Email</th></tr>
	{section name=nr loop=$userlist}
    <tr>
                    <td><a href = "?mode=view&user={$userlist[nr].user_login}">{$userlist[nr].user_login}</a></td>
                    <td>{$userlist[nr].user_level}</td>
                    <td>{$userlist[nr].user_email}</td>
    </tr>
	{/section}
	</table>
	<br />
	</fieldset>
	
	
	<br />
    <input type=button onclick="window.history.go(-1)" value="back" class="log2">