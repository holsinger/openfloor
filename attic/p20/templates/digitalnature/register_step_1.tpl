{config_load file="/libs/lang.conf"}
<h2>{$page_header}</h2>

	<form action="{$URL_register}" method="post" id="thisform">
		<fieldset>
			<legend>{#PLIGG_Visual_Register_Register#}</legend>
			<br />
			<label for="name">{#PLIGG_Visual_Register_Username#} </label><br />
				<input type="text" name="username" id="name" value="" onkeyup="enablebutton(this.form.checkbutton1, this.form.submit, this)" size="25" tabindex="1" maxlength="32"/> <span id="checkit"><input type="button" name="checkbutton1" id="checkbutton1" disabled="disabled" value="{#PLIGG_Visual_Register_Verify#}" onclick="checkfield('username', this.form, this.form.username)" class="submit-s" /></span> <span id="usernamecheckitvalue"></span><br />
            <label for="email">{#PLIGG_Visual_Register_Email#} ({#PLIGG_Visual_Register_Lowercase#})</label><br />
			
			<input type="text" id="email" name="email" value=""  onkeyup="enablebutton(this.form.checkbutton2, this.form.submit, this)" size="25" tabindex="2" maxlength="128"/>
			<span id="checkit"><input type="button" name="checkbutton2" id="checkbutton2" disabled="disabled" value="{#PLIGG_Visual_Register_Verify#}" onclick="checkfield('email', this.form, this.form.email)" class="submit-s" /></span> <span id="emailcheckitvalue"></span><br />
            <label for="password">{#PLIGG_Visual_Register_Password#} ({#PLIGG_Visual_Register_FiveChar#})</label><br />
			<input type="password" id="password" name="password" size="25" tabindex="3"/><br />
		     <label for="verify">{#PLIGG_Visual_Register_Verify_Password#}: </label> <br />
			<input type="password" id="verify" name="password2" size="25" tabindex="4"/><br />
	         
			 
			 
			 <input type="submit" disabled="true" name="submit" value="{#PLIGG_Visual_Register_Create_User#}" class="log2" tabindex="6" /></p>

		<input type="hidden" name="process" value="1"/>
		<input type="hidden" name="charset_check" value="�.�"/>
      <br />
	</fieldset>
	</form>

