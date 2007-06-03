{config_load file="/libs/lang.conf"}
<h2>{$page_header}</h2>
<form action="" id="thisform" method="post">
	<fieldset>
	<legend>{#PLIGG_Visual_Login_Login#}</legend>
	<br />
	{if $errorMsg ne ""}
    <p class="error">{$errorMsg}</p><br />
    {/if} 
	
	<table cellspacing="5">
	<tr>
	<td>{#PLIGG_Visual_Login_Username#}:</td>
	<td><input type="text" name="username" size="25" tabindex="1" id="name" value="{$login_username}" /></td>
	</tr>
	
	<tr>
	<td>{#PLIGG_Visual_Login_Password#}:</td> 
	<td><input type="password" name="password" id="password" size="25" tabindex="2"/></td>
    </tr>	
	
	<tr>
	<td>{#PLIGG_Visual_Login_Remember#}</td> 
	<td><input type="checkbox" name="persistent" id="remember" tabindex="3" class="check" /></td>
	</tr>
	</table>	
		
	<p><input type="submit" value="{#PLIGG_Visual_Login_LoginButton#}" class="log2" tabindex="4" />
		<input type="hidden" name="processlogin" value="1"/></p>
		<input type="hidden" name="return" value="{$templatelite.get.return}"/></p>
	<br />		
	</fieldset>
</form>

<form action="{$my_pligg_base}/login.php" id="thisform2" method="post">
	<fieldset>
		<legend>{#PLIGG_Visual_Login_ForgottenPassword#}</legend>
			<br />
		<label for="name">{#PLIGG_Visual_Login_Username#}:</label>
			<input type="text" name="username" size="25" tabindex="5" id="name" value="{$login_username}" /><br />
		<p><input type="submit" value="{#PLIGG_Visual_Login_EmailChangePass#}" class="log2" tabindex="6" />
			<input type="hidden" name="processlogin" value="3"/></p>
			<input type="hidden" name="return" value="{$templatelite.get.return}"/></p>
			<br />	
	</fieldset>
</form>

	<fieldset>
		<legend>{#PLIGG_Visual_Login_NewUsers#}</legend>
			<br />
		<p>{#PLIGG_Visual_Login_NewUsersA#}<a href = "{$register_url}">{#PLIGG_Visual_Login_NewUsersB#}</a>{#PLIGG_Visual_Login_NewUsersC#}</p>
	<br />
	</fieldset>