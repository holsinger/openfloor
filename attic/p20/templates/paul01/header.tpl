{config_load file="/libs/lang.conf"}
<div id="site-name"><a href="{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Name#}</a></div>
<ul id="nav">
  <li class="first"><a href="{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Home#}</a></li>
  {if $user_authenticated eq true}
  <li><a href="{$URL_userNoVar}">{#PLIGG_Visual_Profile#}</a></li>

  {checkActionsTpl location="tpl_header_just_after_profile"}

  {if $isadmin eq 1}
  <li><a href="{$URL_admin}">{#PLIGG_Visual_Header_AdminPanel#}</a></li>
  {/if}
  <li class="last"><a href="{$URL_logout}">{#PLIGG_Visual_Logout#}</a></li>
  {else}
  <li><a href="{$URL_login}">{#PLIGG_Visual_Login#}</a></li>
  <li class="last"><a href="{$URL_register}">{#PLIGG_Visual_Register#}</a></li>
  {/if}
</ul>
</div>
