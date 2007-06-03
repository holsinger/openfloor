{config_load file="/libs/lang.conf"}
<ul id="nav">
<li id="navhome"><a href="{$my_base_url}{$my_pligg_base}" class="main"><span>{#PLIGG_Visual_Home#}</span></a></li>
{if $user_authenticated eq true}
<li id="navprofile"><a href="{$URL_userNoVar}" class="main"><span>{#PLIGG_Visual_Profile#}</span></a>
  <ul>
    <li class="first"><a href="{$URL_userNoVar}">{#PLIGG_Visual_Profile_2#}</a></li>
    <li class="last"><a href="{$URL_profile}">{#PLIGG_Visual_Profile_3#}</a></li>
  </ul>
  
  {checkActionsTpl location="tpl_header_just_after_profile"}
  
</li>
{if $isadmin eq 1}
<li id="navadmin"><a href="{$URL_admin}" class="main"><span>{#PLIGG_Visual_Header_AdminPanel#}</span></a>
  <ul>
    <li class="first"><a href="{$URL_admin_users}">{#PLIGG_Visual_Header_AdminPanel_1#}</a></li>
	{if $isgod eq 1}
    <li><a href="{$URL_admin_categories}">{#PLIGG_Visual_Header_AdminPanel_2#}</a></li>
    {checkActionsTpl location="tpl_header_admin_links"}
    <li><a href="{$URL_admin_backup}">{#PLIGG_Visual_Header_AdminPanel_4#}</a></li>
	<li><a href="{$URL_admin_modules}">{#PLIGG_Visual_Header_AdminPanel_6#}</a></li>
    <li class="last"><a href="{$URL_admin_config}">{#PLIGG_Visual_Header_AdminPanel_5#}{#PLIGG_Visual_Name#}</a></li>
	<li class="last"><a href="{$URL_admin_rss}" target="_blank">{#PLIGG_Visual_Header_AdminPanel_RSSImport#}</a></li>
	{/if}
  </ul>
</li>
{/if}
<li id="navlogout"><a href="{$URL_logout}" class="main"><span>{#PLIGG_Visual_Logout#}</span></a></li>
{else}
<li id="navlogin"><a href="{$URL_login}" class="main"><span>{#PLIGG_Visual_Login#}</span></a></li>
<li id="navregister"><a href="{$URL_register}" class="main"><span>{#PLIGG_Visual_Register#}</span></a></li>
{/if} 
</ul>

<a id="logo"><span>Pligg</span></a>

<div id="search">
  <form action="{$my_base_url}{$my_pligg_base}/search.php" method="get">
     <img src="{$my_pligg_base}/templates/{$the_template}/images/search.gif" class="go" />
     <input type="text" class="text" onclick="clearText(this, '{#PLIGG_Visual_Search_SearchDefaultText#}')" onblur="restoreText(this,'{#PLIGG_Visual_Search_SearchDefaultText#}')" name="search" id="searchsite" value="{#PLIGG_Visual_Search_SearchDefaultText#}" />
     <br clear="all" />
  </form>
</div>