<div class="tlb2">
	<span onclick="javascript:toggle('regtab','exp2','logtab','exp');" id="exp2" class="expand-up">{#PLIGG_Visual_Register#}</span>
	<span onclick="javascript:toggle('logtab','exp','regtab','exp2');" id="exp" class="expand-down">{#PLIGG_Visual_Login_Title#}</span>
</div>

<div id="logtab" class="featurebox">
	<div class="tlb">
		{php}
			echo "<span><a onclick=\"new Effect.toggle('s3','blind', {queue: 'end'}); \"> <img src=\"".my_pligg_base."/templates/yget/images/expand.png\"></a></span>";
		{/php}
		<a href="{$my_pligg_base}/login.php">{#PLIGG_Visual_Login_Title#}</a>
	</div>
	
	<div id=s3>
		<a name=\"log_reg_box\"></a>
		<form action="{$URL_login}" method="post"> 
			{#PLIGG_Visual_Login_Username#}:<br /><input type="text" name="username" class="login" value="{$login_username}" /><br />
			{#PLIGG_Visual_Login_Password#}:<br /><input type="password" name="password" class="login" /><br />
			<input type="hidden" name="processlogin" value="1"/>
			<input type="hidden" name="return" value="{$templatelite.get.return}"/>
			{#PLIGG_Visual_Login_Remember#}: <input type="checkbox" name="persistent" />
			<input type="submit" value="{#PLIGG_Visual_Login_LoginButton#}" class="submit-s" />
		</form>
		<li class="rmore"><a href="{$URL_login}">{#PLIGG_Visual_What_Is_Pligg_Read_More#}</a></li>
	</div>
</div>



<div id="regtab" style="display:none;"  class="featurebox">	
	<div class="tlb">
		{php}
			echo "<span><a onclick=\"new Effect.toggle('s4','blind', {queue: 'end'}); \"> <img src=\"".my_pligg_base."/templates/yget/images/expand.png\"></a></span>";
		{/php}
		<a href="{$my_pligg_base}/register.php">{#PLIGG_Visual_Register#}</a>
	</div>

	<div id=s4>	
		<a name=\"log_box\"></a>
		<form action="{$my_pligg_base}/register.php" method="post" id="thisform">				
			{#PLIGG_Visual_Register_Username#}:<br /><input type="text" name="username" id="name" value="" onkeyup="enablebutton(this.form.checkbutton1, this.form.submit, this)" size="20" tabindex="1"/>
			<br />{#PLIGG_Visual_Register_Email#}:<br /><input type="text" id="email" name="email" value=""  onkeyup="enablebutton(this.form.checkbutton2, this.form.submit, this)" size="20" tabindex="2"/>
			<br />{#PLIGG_Visual_Register_Password#}:<br /><input type="password" id="password" name="password" size="20" tabindex="3"/>
			<br />{#PLIGG_Visual_Register_Verify_Password#}:<br /><input type="password" id="verify" name="password2" size="20" tabindex="4"/>
			<br /><input type="submit" name="submit" value="{#PLIGG_Visual_Register_Create_User#}" class="log2" tabindex="6" />
			<input type="hidden" name="process" value="1"/>		
		</form>	
		<li class="rmore"><a href="{$URL_register}">{#PLIGG_Visual_What_Is_Pligg_Read_More#}</a></li>
	 </div>
</div> 