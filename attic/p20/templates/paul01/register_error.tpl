{config_load file="/libs/lang.conf"}
<div class="form-error">
There was an error.
<p>
{if $register_error_text eq "errorinserting"}
	{#PLIGG_Visual_Register_Error_Inserting#}	
{/if}
{if $register_error_text eq "usernameexists"}
	{#PLIGG_Visual_Register_Error_UserExists#}	
{/if}
{if $register_error_text eq "badcode"}
	{#PLIGG_Visual_Register_Error_BadCode#}	
{/if}
{if $register_error_text eq "nopassmatch"}
	{#PLIGG_Visual_Register_Error_NoPassMatch#}	
{/if}
{if $register_error_text eq "fivecharpass"}
	{#PLIGG_Visual_Register_Error_FiveCharPass#}	
{/if}
{if $register_error_text eq "emailexists"}
	{#PLIGG_Visual_Register_Error_EmailExists#}	
{/if}
{if $register_error_text eq "bademail"}
	{#PLIGG_Visual_Register_Error_BadEmail#}	
{/if}
{if $register_error_text eq "usernameinvalid"}
	{#PLIGG_Visual_Register_Error_UserInvalid#}	
{/if}
{if $register_error_text eq "usertooshort"}
	{#PLIGG_Visual_Register_Error_UserTooShort#}	
{/if}
</p>
<input type=button onclick="window.history.go(-1)" value="{#PLIGG_Visual_Register_Error_Return#}" class="submit" >
</div>
