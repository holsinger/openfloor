<div class="tlb">
{php}
	echo "<span><a onclick=\"new Effect.toggle('sr','blind', {queue: 'end'}); \">  <img src=\"".my_pligg_base."/templates/yget/images/expand.png\"  onClick=expandcontent(this,'sr') ></a></span>";
{/php}
	<a href="#">{#PLIGG_Visual_RSS_Feeds#}</a>
</div>
<div id="sr" style="padding-bottom:5px;">
	<ul id="nav-rss">
		<li><a href="{$URL_rss2}" target="_blank">{#PLIGG_Visual_RSS_Published#}</a></li>
		<li><a href="{$URL_rss2queued}" target="_blank">{#PLIGG_Visual_RSS_Queued#}</a></li>
		<li><a href="{$URL_rss2all}" target="_blank">{#PLIGG_Visual_RSS_All#}</a></li>	
  </ul>
  </div>
