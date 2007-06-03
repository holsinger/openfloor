{section name=nr loop=$userdata}
<fieldset><legend>{#PLIGG_Visual_Breadcrumb_Edit_User#}: {$userdata[nr].user_login}</legend>
	<form id="form1" name="form1" method="get" action="">
		<input type=hidden name=user value="{$userdata[nr].user_login}">
		<table style="border:none">
		<tr><td>{#PLIGG_Visual_View_User_Login#}:<input name=login value="{$userdata[nr].user_login}"></td></tr>
		
		{if $amIgod eq 1}
		<tr><td>{#PLIGG_Visual_View_User_Level#}:<select name="level">{html_options values=$levels output=$levels selected=$userdata[nr].user_level}</select></td></tr>
		{else}
		<input name="level" type="hidden" value="{$userdata[nr].user_level}" />
		{/if}

		<tr><td>{#PLIGG_Visual_View_User_Email#}:<input name=email value="{$userdata[nr].user_email}"></td></tr>
		<tr><td><input type=submit name=mode value="{#PLIGG_Visual_Profile_Save#}" class="log2"><input type=button onclick="window.history.go(-1)" value="{#PLIGG_Visual_View_User_Edit_Cancel#}" class="log2"></td></tr>
		
{sectionelse}
	{include file=$the_template."/admin_templates/user_doesnt_exist_center.tpl"}
{/section}
		</table>
	    </fieldset>
