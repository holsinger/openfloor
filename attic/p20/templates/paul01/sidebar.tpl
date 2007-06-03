{config_load file="/libs/lang.conf"}

{checkActionsTpl location="tpl_sidebar_top"}

{assign var=sidebar_module value="misc_links_1"}{include file=$the_template_sidebar_modules."/wrapper2.tpl"}
<center>
  <form action="{$my_base_url}{$my_pligg_base}/search.php" method="get" name="thisform" id="thisform">
		{if $templatelite.get.search neq ""}
			{assign var=searchboxtext value=$templatelite.get.search|sanitize:2}
		{else}
			{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}
		{/if}
		<input type="text" size="25" name="search" id="searchsite" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}"/>
    <input type="submit" value="{#PLIGG_Visual_Search_Go#}" class="submit" />
  </form>
</center>
{if $pagename eq "index" || $pagename eq "upcoming"}
	{assign var=sidebar_module value="sidebar_stories"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}
{/if}

{if $user_authenticated ne true} {* show only if NOT logged in *}
  {if $pagename eq "index"} {* show this only if on the index page *}
		{assign var=sidebar_module value="about_box"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}
  {/if}
	{assign var=sidebar_module value="login"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}
{else} {* show if logged in *} 
	{assign var=sidebar_module value="logged_in"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}
{/if}
  	
{* mini tag cloud *}
	{assign var=sidebar_module value="tags"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}

{if $cat_array neq ""}
	{assign var=sidebar_module value="categories"}{include file=$the_template_sidebar_modules."/wrapper2.tpl"}
{/if}

{assign var=sidebar_module value="misc_links_2"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}

{assign var=sidebar_module value="rss"}{include file=$the_template_sidebar_modules."/wrapper2.tpl"}