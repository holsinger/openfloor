{config_load file="libs/lang.conf"}



<ul id="sidelist" style="margin-top:-30px;">

{if $pagename neq "live"}

   {literal}
   <script type="text/javascript">
	document.getElementById('sidelist').style.display='none';
    //new Effect.PopOut('sidelist'); // hide it
   </script>
   {/literal}
   
{/if} 

{checkActionsTpl location="tpl_sidebar_top"}
   
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
	{assign var=sidebar_module value="categories"}
	{assign var=sidebar_module_cache value="true"} {* enable caching for this module *}
	{assign var=sidebar_module_cache_id value="sidebar|category|".$templatelite.get.category} {* unique cache id *}
	{assign var=sidebar_module_cache_lifetime value="-1"} {* cache will never expire *}
	{include file=$the_template_sidebar_modules."/wrapper2.tpl"}
	{assign var=sidebar_module_cache value="false"} {* turn caching back off *}
{/if}

{* mini tag cloud *}
	{assign var=sidebar_module value="tags"}{include file=$the_template_sidebar_modules."/wrapper.tpl"}

{assign var=sidebar_module value="rss"}{include file=$the_template_sidebar_modules."/wrapper2.tpl"}



</ul>

{if $pagename neq "live"}

{literal}
<script type="text/javascript">
  var sideFade = function(element) {
     element._opacity = Element.getOpacity(element);
     new Effect.Opacity(element, {duration:0.2, from:element._opacity, to:0.7});
     new Effect.Highlight(element, {});
  }
  Sortable.create('sidelist', {starteffect: sideFade}); 
</script> 
{/literal}

{/if}