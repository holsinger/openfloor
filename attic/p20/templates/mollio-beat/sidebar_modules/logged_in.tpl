<h3> {#PLIGG_Visual_Welcome_Back#} {$user_logged_in} <img src="{$Current_User_Avatar_ImgSrc}" alt="Avatar"/></h3>
<ul>
	<li>
		<a href="{$URL_userNoVar}">{#PLIGG_Visual_Profile#}</a>
	</li>
	{checkActionsTpl location="tpl_sidebar_logged_in_just_below_profile"}
	{if $isadmin eq 1}
		<li>
			<a href="{$URL_admin}">{#PLIGG_Visual_Header_AdminPanel#}</a>
		</li>
  	{if $Enable_Live eq 'false'}
  		<li>
  			<a href='{$URL_live}'>{#PLIGG_Visual_Live#}</a>
  		</li>
  	{/if}
	{/if}
	<li>
		<a href="{$URL_logout}">{#PLIGG_Visual_Logout#}</a>
	</li>
</ul>