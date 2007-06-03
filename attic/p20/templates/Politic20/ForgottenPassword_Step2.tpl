<form action="{$login_url}" id="thisform2" method="post">
	<fieldset><legend><span class="sign">{#PLIGG_PassEmail_Step2_Head#}</span></legend>
		<p class="l-top"><label for="name">{#PLIGG_PassEmail_Step2_ConfirmCode#}:</label><br />
		<input type="text" name="confirmationcode" size="55" tabindex="1" id="name"/></p>
		<p class="l-bot"><input type="submit" value="{#PLIGG_PassEmail_Step2_ChangePass#}" class="log2" tabindex="4" />
		<input type="hidden" name="username" value="{$user_login}"/></p>
		<input type="hidden" name="processlogin" value="4"/>
		<input type="hidden" name="return" value="{$profile_url}"/>
	</fieldset>
</form>