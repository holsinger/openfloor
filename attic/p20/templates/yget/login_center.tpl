{config_load file="/libs/lang.conf"}

<h2>{$page_header}</h2>

<form action="" id="thisform" method="post">
	<fieldset><legend><span class="sign">{#PLIGG_Visual_Login_Login#}</span></legend>
		{if $errorMsg ne ""}
			<p class="l-top"><span class="error">{$errorMsg}</span></p><br />
	    {/if} 
		<p class="l-top"><label for="name">{#PLIGG_Visual_Login_Username#}:</label>
		<input type="text" name="username" size="25" tabindex="1" id="name" value="{$login_username}" /></p><br />
		<p class="l-mid"><label for="password">{#PLIGG_Visual_Login_Password#}:</label>
		<input type="password" name="password" id="password" size="25" tabindex="2"/></p>
		<p class="l-mid"><label for="remember">{#PLIGG_Visual_Login_Remember#}: <input type="checkbox" name="persistent" id="remember" tabindex="3"/></label></p>
		<p class="l-bot"><input type="submit" value="{#PLIGG_Visual_Login_LoginButton#}" class="log2" tabindex="4" />
		<input type="hidden" name="processlogin" value="1"/></p>
		<input type="hidden" name="return" value="{$templatelite.get.return}"/></p>
	</fieldset>
</form>

<form action="{$my_pligg_base}/login.php" id="thisform2" method="post">
	<fieldset>
		<legend><span class="sign">{#PLIGG_Visual_Login_ForgottenPassword#}</span></legend>
		<p class="l-top"><label for="name">{#PLIGG_Visual_Login_Username#}:</label>
		<input type="text" name="username" size="25" tabindex="5" id="name" value="{$login_username}" /></p><br />
		<p class="l-bot"><input type="submit" value="{#PLIGG_Visual_Login_EmailChangePass#}" class="log2" tabindex="6" />
		<input type="hidden" name="processlogin" value="3"/></p>
		<input type="hidden" name="return" value="{$templatelite.get.return}"/></p>
	</fieldset>
</form>

<fieldset>
	<legend><span class="sign">{#PLIGG_Visual_Login_NewUsers#}</span></legend>
	<p class="l-top">{#PLIGG_Visual_Login_NewUsersA#}<a href = "{$register_url}">{#PLIGG_Visual_Login_NewUsersB#}</a>{#PLIGG_Visual_Login_NewUsersC#}</p>
</fieldset>