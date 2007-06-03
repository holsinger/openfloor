{* display tag cloud header *}
<h2>{#PLIGG_Visual_Tags_Tags#}</h2>

{* display the "all 48 hours this week this month this year" links *}
<div id="right" style="padding-left:300px; margin-top:-27px;" align="left">

{section name=i start=0 loop=$count_range_values step=1}

{if $templatelite.section.i.index eq $current_range}
<span class="current"><strong>{$range_names[i]}</strong></span>&nbsp;&nbsp;
{else}
	
	
      <span><a href="{$URL_tagcloud_range, $templatelite.section.i.index}" style="text-decoration:none">	{$range_names[i]}</a></span>&nbsp;&nbsp;              				  
      
      
{/if}

{/section}
   
</div>
 

{* display the tag cloud *}
<div style="margin: 20px 0 20px 0; line-height: {$tags_max_pts}pt; margin-left: 100px;">

{section name=customer loop=$tag_number}

<span style="font-size: {$tag_size[customer]}pt">
<a href="{$tag_url[customer]}">{$tag_name[customer]}</a>
</span>
&nbsp;&nbsp;

{/section}

</div>
