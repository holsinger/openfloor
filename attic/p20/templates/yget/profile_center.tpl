{config_load file="/libs/lang.conf"}
<h2>{#PLIGG_Visual_Profile_ModifyProfile#}</h2>
{if $savemsg neq ""}{$savemsg}{/if} 
<fieldset>
	<legend><span class="sign">{#PLIGG_Visual_Profile_ModifyProfile#}</span></legend>
		{if $UseAvatars neq false}
			<fieldset><legend>{#PLIGG_Visual_Profile_UploadAvatar2#}:</legend>
				{if $user_avatar_source eq "useruploaded"}
					<span style="float:right; width:60%;"><br />
						{* this form can't be inside of another form! *}
						<form method="POST" enctype="multipart/form-data" name="image_upload_form" action="{php}$_SERVER["PHP_SELF"];{/php}">
							<input type="file" name="image_file" size="20">
							<input type="hidden" name="avatar" value="uploaded"/>
							<input type="submit" value="{#PLIGG_Visual_Profile_AvatarUpload#}" name="action"><br>
							{#PLIGG_Visual_Profile_AvatarResize#}
						</form> 
					</span>
				{/if}
		{/if}
		
		<form action="" method="post" id="thisform">		
		{if $UseAvatars neq false}
				{#PLIGG_Visual_Profile_CurrentAvatar#}
				<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgLarge}" alt="Avatar"/></span>
				<span id="ls_avatar-{$link_shakebox_index}"><img src="{$Avatar_ImgSmall}" alt="Avatar"/></span>
				<br />
				<input type="radio" name="avatarsource" value="" {if $user_avatar_source eq ""}CHECKED{/if}> {#PLIGG_Visual_Profile_UseDefaultAvatar#}<br />
				<input type="radio" name="avatarsource" value="useruploaded" {if $user_avatar_source eq "useruploaded"}CHECKED{/if}> {#PLIGG_Visual_Profile_UploadAvatar#}
				<p class="l-bottom"><input type=submit name="save_profile" value="{#PLIGG_Visual_Profile_Save#}" class="log2"></p>
						
			</fieldset>
		{/if}		
		
	<table style="border:none">
	<input type="hidden" name="process" value="1">
	<input type="hidden" name="user_id" value="{$user_id}">
	
	{checkActionsTpl location="tpl_profile_center_fields"}
	
	<tr>
	<td width="30%"><p class="l-top"><label for="name" accesskey="1">{#PLIGG_Visual_Profile_RealName#}:</label>
	<input type="text" name="names" id="names" tabindex="1" value="{$user_names}">
	</p></td>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_AIM#}:</label>
	<input type="text" name="aim" id="aim" tabindex="2" value="{$user_aim}">
	</p></td>
	</tr>
	
	<tr>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Email#}:</label>
	<input type="text" name="email" id="email" tabindex="3" value="{$user_email}"> <br /><em>{#PLIGG_Visual_Profile_OnlyAdmins#}</em>
	</p></td>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_MSN#}:</label>
	<input type="text" name="msn" id="msn" tabindex="4" value="{$user_msn}">
	</p></td>
	</tr>
	
	<tr>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_PublicEmail#}:</label>
	<input type="text" name="public_email" id="public_email" tabindex="5" value="{$user_publicemail}">
	</p></td>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Yahoo#}:</label>
	<input type="text" name="yahoo" id="yahoo" tabindex="6" value="{$user_yahoo}">
	</p></td>
	</tr>
	
	<tr>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Homepage#}:</label>
	<input type="text" name="url" id="url" tabindex="7" value="{$user_url}">
	</p></td>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_GTalk#}:</label>
	<input type="text" name="gtalk" id="gtalk" tabindex="8" value="{$user_gtalk}">
	</p></td>
	</tr>
	
	<tr>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Location#}:</label>
	<input type="text" name="location" id="location" tabindex="9" value="{$user_location}">
	</p></td>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Skype#}:</label>
	<input type="text" name="skype" id="skype" tabindex="10" value="{$user_skype}">
	</p></td>
	</tr>
	
	<tr>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Occupation#}:</label>
	<input type="text" name="occupation" id="occupation" tabindex="11" value="{$user_occupation}">
	</p></td>
	<td><p class="l-mid"><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_IRC#}: {#PLIGG_Visual_Profile_IRC_Instruct#}</label>
	<input type="text" name="irc" id="irc" tabindex="12" value="{$user_irc}">
	</p></td>	
	</tr>			
	</table>
	
	<br />
	<br />
	
	<p class="l-mid">{#PLIGG_Visual_Profile_ChangePass#}</p>
	<br />
	<table style="border:none">
	<tr>
	<td colspan = 2>
	<p class="l-mid"><label for="password">{#PLIGG_Visual_Profile_OldPass#}:</label>
	<input type="password" id="oldpassword" name="oldpassword" size="25" tabindex="13"/></p>
	</td>
	</tr>
	
	<tr>
	<td width="30%"><p class="l-mid"><label for="password">{#PLIGG_Visual_Profile_NewPass#}:</label>
	<input type="password" id="password" name="password" size="25" tabindex="14"/></p>
	</td>
	<td>
	<p class="l-mid"><label for="verify">{#PLIGG_Visual_Profile_VerifyNewPass#}: </label>
	<input type="password" id="verify" name="password2" size="25" tabindex="15"/></p>
	</td>
	</tr>
	</table>
	
	<br />
	<p class="l-bottom"><input type=submit name="save_profile" value="{#PLIGG_Visual_Profile_Save#}" class="log2" tabindex="16"></p>
	</form>
</fieldset>