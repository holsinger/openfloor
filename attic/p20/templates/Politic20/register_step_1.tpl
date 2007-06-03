{config_load file="/libs/lang.conf"}
														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
																				<div id="comments">
<h2>{$page_header}</h2>
<div id="contents">
	<form action="{$URL_register}" method="post" id="thisform">
		<span class="sign">{#PLIGG_Visual_Register_Register#}</span>
			<p class="l-top"><label for="name">{#PLIGG_Visual_Register_Username#}:</label>
				<input type="text" name="username" id="name" value="" onkeyup="enablebutton(this.form.checkbutton1, this.form.submit, this)" size="25" tabindex="1" maxlength="32"/>
				<span id="checkit"><input type="button" name="checkbutton1" id="checkbutton1" disabled="disabled" value="{#PLIGG_Visual_Register_Verify#}" onclick="checkfield('username', this.form, this.form.username)" class="submit-s" /></span>
				<br/><span id="usernamecheckitvalue"></span>
			</p>
			<br />
			<p class="l-mid"><label for="email">{#PLIGG_Visual_Register_Email#}:</label>
				{#PLIGG_Visual_Register_Lowercase#}<br />
				<input type="text" id="email" name="email" value=""  onkeyup="enablebutton(this.form.checkbutton2, this.form.submit, this)" size="25" tabindex="2" maxlength="128"/>
				<span id="checkit"><input type="button" name="checkbutton2" id="checkbutton2" disabled="disabled" value="{#PLIGG_Visual_Register_Verify#}" onclick="checkfield('email', this.form, this.form.email)" class="submit-s" /></span>
				<br/><span id="emailcheckitvalue"></span>
			</p>
			<br />
			<p class="l-mid"><label for="password">{#PLIGG_Visual_Register_Password#}:</label>
				{#PLIGG_Visual_Register_FiveChar#}<br />
				<input type="password" id="password" name="password" size="25" tabindex="3"/>
			</p>
			<br />
			<p class="l-mid"><label for="verify">{#PLIGG_Visual_Register_Verify_Password#}: </label>
				<input type="password" id="verify" name="password2" size="25" tabindex="4"/>
				
			</p>
			<br />
			<p class="l-bot"><input type="submit" disabled="true" name="submit" value="{#PLIGG_Visual_Register_Create_User#}" class="log2" tabindex="6" /></p>
			<input type="hidden" name="process" value="1"/>
			<input type="hidden" name="charset_check" value="�.�"/>
	</form>
</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="pagers">
															<div class="pbg">
																<div class="list">
																</div>
															</div>
														</div>