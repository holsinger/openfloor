{config_load file="/libs/lang.conf"}

{if $user_authenticated ne true} {* show only if NOT logged in *}
	{assign var=sidebar_module value="about_box"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}
{/if}

{checkActionsTpl location="tpl_sidebar_top"} 
 
{if $user_authenticated ne true} {assign var=sidebar_module value="login"}{include file=$the_template_sidebar_modules."/wrapper2.tpl"} {/if}

{assign var=sidebar_module value="sidebar_stories_u"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}

{assign var=sidebar_module value="sidebar_stories"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}

{assign var=sidebar_module value="categories"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}

{if $enable_tags eq 'true'} {assign var=sidebar_module value="tags"}{include file=$the_template_sidebar_modules."/wrapper.tpl"} {/if}

{assign var=sidebar_module value="rss"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}