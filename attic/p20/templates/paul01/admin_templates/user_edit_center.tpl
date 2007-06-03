{section name=nr loop=$userdata}
<fieldset>
<legend>Edit User: {$userdata[nr].user_login}</legend>
<form id="form1" name="form1" method="get" action="">
<input type=hidden name=user value="{$userdata[nr].user_login}">
<table style="border:none">
<tr>
  <td>Login:
    <input name=login value="{$userdata[nr].user_login}"></td>
</tr>
{if $amIgod eq 1}
<tr>
  <td>Level:
    <SELECT NAME="level">
      
		{html_options values=$levels output=$levels selected=$userdata[nr].user_level}
	
    </SELECT>
	
     </td>
</tr>
{else}
	<input name="level" type="hidden" value="{$userdata[nr].user_level}" />
{/if}
<tr>
  <td>Email:
    <input name=email value="{$userdata[nr].user_email}"></td>
</tr>
<tr>
  <td><input type=submit name=mode value="{#PLIGG_Visual_Profile_Save#}" class="log2">
    <input type=button onclick="window.history.go(-1)" value="{#PLIGG_Visual_View_User_Edit_Cancel#}" class="log2"></td>
</tr>
<tr>
  <td></td>
</tr>
{sectionelse}
	{include file=$the_template."/admin_templates/user_doesnt_exist_center.tpl"}
{/section}
	</table>
    </fieldset>
