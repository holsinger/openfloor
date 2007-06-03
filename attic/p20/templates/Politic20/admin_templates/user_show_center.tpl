{section name=nr loop=$userdata}
<div id="admin_view_user">
	<fieldset><legend>View User: {$userdata[nr].user_login}</legend>
		<table style="border:none">
		<tr><td><b>{#PLIGG_Visual_View_User_Login#}: </b></td><td>{$userdata[nr].user_login}</td></tr>
		<tr><td><b>{#PLIGG_Visual_View_User_Level#}: </b></td><td>{$userdata[nr].user_level}</td></tr>
		<tr><td><b>{#PLIGG_Visual_View_User_Email#}: </b></td><td>{$userdata[nr].user_email}</td></tr>
		<tr><td><b>{#PLIGG_Visual_View_User_LL_Date#}: </b></td><td>{$userdata[nr].user_lastlogin}</td></tr>
		<tr><td><b>{#PLIGG_Visual_View_User_LL_Address#}: </b></td><td> {$userdata[nr].user_lastip}</td></tr>
		{if $userdata[nr].user_login neq "god"}<tr><td><strong>{#PLIGG_Visual_View_User_IP_Address#}:</strong></td><td> {$userdata[nr].user_ip}</td></tr>{/if}
		<tr><td><a href="?mode=viewlinks&user={$userdata[nr].user_login}">{#PLIGG_Visual_View_User_Sub_Links#}</a></td><td>{$linkcount} Total</td></tr>
		<tr><td><a href="?mode=viewcomments&user={$userdata[nr].user_login}">{#PLIGG_Visual_View_User_Sub_Comments#}</a></td><td>{$commentcount} Total</td></tr>
		</table>
	</fieldset>	
</div>
		
		
<div id="admin_view_user_edit">
	<fieldset><legend>Edit User: {$userdata[nr].user_login}</legend>
		<table style="border:none">
		<tr><td><a href="?mode=resetpass&user={$userdata[nr].user_login}" onclick="return confirm('{#PLIGG_Visual_View_User_Reset_Pass_Confirm#}')">{#PLIGG_Visual_View_User_Reset_Pass#}</a></td></tr>
		<tr><td><a href="?mode=edit&user={$userdata[nr].user_login}">{#PLIGG_Visual_View_User_Edit_Data#}</a></td></tr>
		<tr><td><a href="?mode=disable&user={$userdata[nr].user_login}">{#PLIGG_Visual_View_User_Disable#}</a></td></tr>
		<tr><td><a href="?mode=killspam&user={$userdata[nr].user_login}&id={$userdata[nr].user_id}">{#PLIGG_Visual_View_User_Killspam#}</a></td></tr>
		</table>
	</fieldset>
</div>

{sectionelse}
	{include file=$the_template."/admin_templates/user_doesnt_exist_center.tpl"}
{/section}