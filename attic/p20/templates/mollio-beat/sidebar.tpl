{config_load file="/libs/lang.conf"}

{checkActionsTpl location="tpl_sidebar_top"}

{* mini tag cloud *}
	{assign var=sidebar_module value="tags"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}

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
  	
{assign var=sidebar_module value="misc_links_1"}{include file=$the_template_sidebar_modules."/wrapper2.tpl"}

{if $cat_array neq ""}
	{assign var=sidebar_module value="categories"}{include file=$the_template_sidebar_modules."/wrapper2.tpl"}
{/if}

{assign var=sidebar_module value="misc_links_2"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}

{assign var=sidebar_module value="rss"}{include file=$the_template_sidebar_modules."/wrapper2.tpl"}