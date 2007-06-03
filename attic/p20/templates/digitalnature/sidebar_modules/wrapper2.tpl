{if $sidebar_module_cache eq 'true'}
	{include_clipcache file=$the_template_sidebar_modules."/".$sidebar_module.".tpl" cache_id=$sidebar_module_cache_id cache_lifetime=$sidebar_module_cache_lifetime}
{else}
	{include file=$the_template_sidebar_modules."/".$sidebar_module.".tpl"}
{/if}