{config_load file=$sidebar_stats_lang_conf}

{if $the_template eq "mollio-beat" || $the_template eq "paul01"}

<div class="featurebox">
	<img src=minus.gif class=showstate onClick=expandcontent(this,'sidebar_stats') />
	<h3>{#PLIGG_SIDEBAR_STATS_Header#}</h3>
	<div id=sidebar_stats class=switchcontent>
		{#PLIGG_SIDEBAR_STATS_Members#}{$sidebar_stats_members}<br />
		{#PLIGG_SIDEBAR_STATS_Total#}{$sidebar_stats_total}<br />
		{#PLIGG_SIDEBAR_STATS_Published#}{$sidebar_stats_published}<br />
		{#PLIGG_SIDEBAR_STATS_Queued#}{$sidebar_stats_queued}<br />
		{#PLIGG_SIDEBAR_STATS_Votes#}{$sidebar_stats_votes}<br />
		{#PLIGG_SIDEBAR_STATS_Comments#}{$sidebar_stats_comments}
	</div>
</div>


{elseif $the_template eq "digitalnature"}
<li>
  <div class="box" id="loggedinbox">
    <div class="box2" id="loggedin">
      <div class="wrap">
        <div class="content">
          <div style="padding:10px 6px;">
            <h3>{#PLIGG_SIDEBAR_STATS_Header#}</h3>
		{#PLIGG_SIDEBAR_STATS_Members#}{$sidebar_stats_members}<br />
		{#PLIGG_SIDEBAR_STATS_Total#}{$sidebar_stats_total}<br />
		{#PLIGG_SIDEBAR_STATS_Published#}{$sidebar_stats_published}<br />
		{#PLIGG_SIDEBAR_STATS_Queued#}{$sidebar_stats_queued}<br />
		{#PLIGG_SIDEBAR_STATS_Votes#}{$sidebar_stats_votes}<br />
		{#PLIGG_SIDEBAR_STATS_Comments#}{$sidebar_stats_comments}
 </div>
        </div>
      </div>
    </div>
  </div>

</li>
   
   {elseif $the_template eq "yget"}

<div class="featurebox">	
<div class="tlb">
{php}
	echo "<span><a onclick=\"new Effect.toggle('sidebar_stats','blind', {queue: 'end'}); \"> <img src=\"".my_pligg_base."/templates/yget/images/expand.png\"  onClick=expandcontent(this,'sidebar_stats') ></a></span>";
{/php}

<a href="{$URL_about}">{#PLIGG_SIDEBAR_STATS_Header#}</a>

</div>
	<div id="sidebar_stats" class="switchurl">
		{#PLIGG_SIDEBAR_STATS_Members#}{$sidebar_stats_members}<br />
		{#PLIGG_SIDEBAR_STATS_Total#}{$sidebar_stats_total}<br />
		{#PLIGG_SIDEBAR_STATS_Published#}{$sidebar_stats_published}<br />
		{#PLIGG_SIDEBAR_STATS_Queued#}{$sidebar_stats_queued}<br />
		{#PLIGG_SIDEBAR_STATS_Votes#}{$sidebar_stats_votes}<br />
		{#PLIGG_SIDEBAR_STATS_Comments#}{$sidebar_stats_comments}
	</div>	
</div>
   
{/if}

{* this is a temporary fix. When you load a new config file the existing config gets dropped. *}
{config_load file="/libs/lang.conf"}