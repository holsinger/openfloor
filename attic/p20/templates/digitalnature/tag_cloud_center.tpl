<h2>{#PLIGG_Visual_Tags_Tags#}</h2>
<div class="tabs" style="margin-top:-50px; border:none">
  <ul>
    {section name=i start=0 loop=$count_range_values step=1}
    {if $templatelite.section.i.index eq $current_range}
    <li class="active"><a><span>{$range_names[i]}</span></a></li>
    {else}    
    <li><a href="{$URL_tagcloud_range, $templatelite.section.i.index}"><span>{$range_names[i]}</span></a></li>
    {/if}
    {/section}
  </ul>
  <br clear="all" />
</div>

 <center>
<div style="line-height: {$tags_max_pts}pt;"> {section name=customer loop=$tag_number} 
  {* --- to change the way the words are displayed, change this part --- *} 
 
  <span style="font-size: {$tag_size[customer]}pt"> <a href="{$tag_url[customer]}">{$tag_name[customer]}</a> </span>&nbsp;&nbsp;

  {* ---		--- *}
  
  {/section} 
</div>
</center>