{config_load file="/libs/lang.conf"}
 <h2>{#PLIGG_Visual_Profile_ModifyProfile#}</h2>
 
{if $Allow_User_Change_Templates eq "true"} 
<div class="tabs" style="border:none; margin-top:-50px;">
 	<ul>
 	  	<li><a href="{$URL_template}"><span>Change Layout</span></a></li>
 	</ul>
</div>
{/if}
 
 {if $savemsg neq ""}{$savemsg}{/if}
 
	<fieldset>
		<legend>{#PLIGG_Visual_Profile_ModifyProfile#}</legend>
		<br />
			{if $UseAvatars neq false}
			 
				<fieldset><legend>{#PLIGG_Visual_Profile_UploadAvatar2#}:</legend>
				<br />
					{if $user_avatar_source eq "useruploaded"}
							{* this form can't be inside of another form! *}
							<form method="POST" enctype="multipart/form-data" name="image_upload_form" action="{php}$_SERVER["PHP_SELF"];{/php}">
								<input type="file" name="image_file" size="20" style="margin-right:50px;">
								<input type="hidden" name="avatar" value="uploaded"/>
								<input type="submit" value="{#PLIGG_Visual_Profile_AvatarUpload#}" name="action">
							</form>
							<br /> 
							<br />
					{/if}
		    {/if}
			
			<form action="" method="post" id="thisform">
			
			{if $UseAvatars neq false}
						<b>{#PLIGG_Visual_Profile_CurrentAvatar#}</b>
						<img src="{$Avatar_ImgLarge}" alt="Avatar"/>
						<img src="{$Avatar_ImgSmall}" alt="Avatar"/>
					<br /><br />
					<input type="radio" name="avatarsource" class="check" value="" {if $user_avatar_source eq ""}CHECKED{/if}> {#PLIGG_Visual_Profile_UseDefaultAvatar#}<br /><br />
					<input type="radio" name="avatarsource" class="check" value="useruploaded" {if $user_avatar_source eq "useruploaded"}CHECKED{/if}> {#PLIGG_Visual_Profile_UploadAvatar#}<br /><br />
				   <input type=submit name="save_profile" value="{#PLIGG_Visual_Profile_Save#}" class="log2"><br />
						
				</fieldset>
			{/if}
			
			<br />
			
			<table style="border:none">
	
			<input type="hidden" name="process" value="1">
			<input type="hidden" name="user_id" value="{$user_id}"><br />
			
			{checkActionsTpl location="tpl_profile_center_fields"}
			
			<tr>
			<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_RealName#}:</label></td>
			<td><input type="text" name="names" id="names" tabindex="1" value="{$user_names}"></td>
			</tr>
			
			<tr>
			<td><label for="email" accesskey="1">{#PLIGG_Visual_Profile_Email#}: </label></td>
			<td><input type="text" name="email" id="email" tabindex="2" value="{$user_email}"></td>
			<td><em>{#PLIGG_Visual_Profile_OnlyAdmins#}</em></td>
			</td>		

			<tr>
			<td><label for="public_email" accesskey="1">{#PLIGG_Visual_User_Profile_PublicEmail#}:</label></td>
			<td><input type="text" name="public_email" id="public_email" tabindex="3" value="{$user_publicemail}"></td>
			</tr>

			<tr>
			<td><label for="url" accesskey="1">{#PLIGG_Visual_User_Profile_Homepage#}:</label></td>
			<td><input type="text" name="url" id="url" tabindex="4" value="{$user_url}"></td>
			</tr>

			<tr>
			<td><label for="location" accesskey="1">{#PLIGG_Visual_Profile_Location#}:</label></td>
			<td><input type="text" name="location" id="location" tabindex="5" value="{$user_location}"></td>
			</tr>
			 
			<tr>
			<td><label for="occupation" accesskey="1">{#PLIGG_Visual_Profile_Occupation#}:</label></td>
			<td><input type="text" name="occupation" id="occupation" tabindex="6" value="{$user_occupation}"></td>
			</tr>
			
			<tr>
			<td><label for="aim" accesskey="1">{#PLIGG_Visual_User_Profile_AIM#}:</label></td>
			<td><input type="text" name="aim" id="aim" tabindex="7" value="{$user_aim}"></td>
			</tr>
			
			<tr>
			<td><label for="msn" accesskey="1">{#PLIGG_Visual_User_Profile_MSN#}:</label></td>
			<td><input type="text" name="msn" id="msn" tabindex="8" value="{$user_msn}"></td>
            </tr>			
			
			<tr>
			<td><label for="yahoo" accesskey="1">{#PLIGG_Visual_User_Profile_Yahoo#}:</label></td>
			<td><input type="text" name="yahoo" id="yahoo" tabindex="9" value="{$user_yahoo}"></td>
			</tr>

			<tr>
			<td><label for="gtalk" accesskey="1">{#PLIGG_Visual_User_Profile_GTalk#}:</label></td>
			<td><input type="text" name="gtalk" id="gtalk" tabindex="10" value="{$user_gtalk}"></td>
			</tr>
			
			<tr>
			<td><label for="skype" accesskey="1">{#PLIGG_Visual_User_Profile_Skype#}:</label></td>
			<td><input type="text" name="skype" id="skype" tabindex="11" value="{$user_skype}"></td>	
			</tr>			

			<tr>
			<td><label for="irc" accesskey="1">{#PLIGG_Visual_User_Profile_IRC#}: {#PLIGG_Visual_Profile_IRC_Instruct#}</label></td>
			<td><input type="text" name="irc" id="irc" tabindex="12" value="{$user_irc}"></td>
			</tr>
			</table>
			
			
			<br />
			<br />		
          
			
			<b>{#PLIGG_Visual_Profile_ChangePass#}</b>
			
            
			<table style="border:none">			
			<tr>
			<td><label for="password" accesskey="1">{#PLIGG_Visual_Profile_OldPass#}:</label></td>
			<td><input type="password" id="oldpassword" name="oldpassword" tabindex="13"/></td>
			</tr>
			
			<tr>
			<td><label for="password" accesskey="1">{#PLIGG_Visual_Profile_NewPass#}:</label></td>
			<td><input type="password" id="password" name="password" tabindex="14"/></td>
			</tr>
			
			<tr>
            <td><label for="verify" accesskey="1">{#PLIGG_Visual_Profile_VerifyNewPass#}: </label></td>
			<td><input type="password" id="verify" name="password2" tabindex="15"/></td>	
			</tr>
			
			<tr>
			<td><input type=submit name="save_profile" value="{#PLIGG_Visual_Profile_Save#}" class="log2" tabindex="16"></td>
			</tr>			
			</table>
			
		</form>
	</fieldset>
