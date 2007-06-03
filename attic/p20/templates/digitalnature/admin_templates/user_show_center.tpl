{section name=nr loop=$userdata}
<div id="admin_view_user">
<fieldset style="padding: 5px 5px 5px 5px;"><legend>View User: {$userdata[nr].user_login}</legend>
	    <table style="border:none" cellspacing="5">
        <tr><td><b>Login: </b></td><td>{$userdata[nr].user_login}</td></tr>
		<tr><td><b>Level: </b></td><td>{$userdata[nr].user_level}</td></tr>
		<tr><td><b>Email: </b></td><td>{$userdata[nr].user_email}</td></tr>
		{checkActionsTpl location="tpl_admin_user_show_center_fields"}		
		<tr><td><strong>Last Login Date/Time:</strong> </td><td>{$userdata[nr].user_lastlogin}</td></tr>
		<tr><td><strong>Last Login IP Address: </strong></td><td> {$userdata[nr].user_lastip}</td></tr>
		{if $userdata[nr].user_login neq "god"}
		<tr><td><strong>Registration IP Address:</strong></td><td> {$userdata[nr].user_ip}</td></tr>
		{/if}
		<tr><td><a href="?mode=viewlinks&user={$userdata[nr].user_login}">View submitted links</a></td><td>{$linkcount} Total</td></tr>
		<tr><td><a href="?mode=viewcomments&user={$userdata[nr].user_login}">View submitted comments</a></td><td>{$commentcount} Total</td></tr>
		</table>
		</fieldset>	
		</div>
		
		
		<br />
		<br />
		
		
		<div id="admin_view_user_edit">
		<fieldset><legend>Edit User: {$userdata[nr].user_login}</legend>
	    <table style="border:none" cellspacing="5">		
		
		<tr><td><a href="?mode=resetpass&user={$userdata[nr].user_login}">Reset user's password to "password"</a></td></tr>
		<tr><td><a href="?mode=edit&user={$userdata[nr].user_login}">Edit user data</a></td></tr>
		<tr><td><a href="?mode=disable&user={$userdata[nr].user_login}">Disable this user</a></td></tr>
		<tr><td><a href="?mode=killspam&user={$userdata[nr].user_login}&id={$userdata[nr].user_id}">KillSpam this user.</a> (disable user and all their links and comments)</td></tr>		
		
		</table>
		
		</fieldset>
		</div>
		
		{sectionelse}
			{include file=$the_template."/admin_templates/user_doesnt_exist_center.tpl"}
		{/section}
		
		
		
