<h3 id="rltxt">{#PLIGG_Visual_Login_Title#}</h3>

<div id="logtab">
<a name=\"log_reg_box\"></a>
<form action="{$URL_login}" method="post"> 
	{#PLIGG_Visual_Login_Username#}:
	<input type="text" name="username" class="login" value="{$login_username}" />
	{#PLIGG_Visual_Login_Password#}:
	<input type="password" name="password" class="login" />
	<input type="hidden" name="processlogin" value="1"/>
	 <input type="hidden" name="return" value="{$templatelite.get.return}"/>
	{#PLIGG_Visual_Login_Remember#}:
  <input type="checkbox" name="persistent" />
  <input type="submit" value="{#PLIGG_Visual_Login_LoginButton#}" class="submit-s" />
</form>

  {php}
				echo "<a onclick=\"Element.update('rltxt', 'Registration');new Effect.toggle('logtab','blind', {queue: 'front'}); new Effect.toggle('regtab','blind', { queue: 'end'});\" href=\"#log_reg_box\">Register new Account</a>";
			{/php}

</div>

<div id="regtab" style="display:none;padding: 4px 0 0 4px;">		
				<form action="{$my_pligg_base}/register.php" method="post" id="thisform">				
					{#PLIGG_Visual_Register_Username#}:
					<input type="text" name="username" id="name" value="" onkeyup="enablebutton(this.form.checkbutton1, this.form.submit, this)" size="20" tabindex="1"/>

					{#PLIGG_Visual_Register_Email#}:
					<input type="text" id="email" name="email" value=""  onkeyup="enablebutton(this.form.checkbutton2, this.form.submit, this)" size="20" tabindex="2"/>

					{#PLIGG_Visual_Register_Password#}:
					<input type="password" id="password" name="password" size="20" tabindex="3"/>
					
					{#PLIGG_Visual_Register_Verify_Password#}: 
					<input type="password" id="verify" name="password2" size="20" tabindex="4"/>

					<input type="submit" name="submit" value="{#PLIGG_Visual_Register_Create_User#}" class="log2" tabindex="6" />
						{php}
							echo "<a onclick=\"Element.update('rltxt', 'Login');new Effect.toggle('logtab','blind', {queue: 'end'}); new Effect.toggle('regtab','blind', { queue: 'front'});\" href=\"#log_reg_box\"> (back)</a>";
						{/php}</ul>						
					<input type="hidden" name="process" value="1"/>
					<input type="hidden" name="charset_check" value="?.?"/>				
				</form>	
 </div>