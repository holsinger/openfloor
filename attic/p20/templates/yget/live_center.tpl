{config_load file="/libs/lang.conf"}

<div id="cab" style="float:right;">
	<ul class="postin">
		<li><a href="{$URL_comments}" class="navbut3"><span>{#PLIGG_Visual_Breadcrumb_Comments#}</span></a></li>
		<li><a href="{$URL_unpublished}" class="navbut3"><span>{#PLIGG_Visual_Breadcrumb_Unpublished_Tab#}</span></a></li>
		<li><a href="{$URL_published}" class="navbut3"><span>{#PLIGG_Visual_Breadcrumb_Published_Tab#}</span></a></li>
		<li><a href="{$URL_live}" class="navbut4"><span>{#PLIGG_Visual_Breadcrumb_All#}</span></a></li>
	</ul>
</div>

<h2 style="padding-bottom:6px">{#PLIGG_Visual_Live#}</h2>

<div class="air-with-footer">
	<div class="live2">
		<div class="live2-item">
			<div class="live2-ts"><strong>{#PLIGG_Visual_All_Hour#}</strong></div>
			<div class="live2-type"><strong>{#PLIGG_Visual_All_Action#}</strong></div>
			<div class="live2-votes"><strong>{#PLIGG_Visual_All_Votes#}</strong></div>
			<div class="live2-story"><strong>{#PLIGG_Visual_All_Story#}</strong></div>
			<div class="live2-who"><strong>{#PLIGG_Visual_All_User#}</strong></div>
			<div class="live2-status"><strong>{#PLIGG_Visual_All_State#}</strong></div>
		</div>
		{section name=foo start=0 loop=$items_to_show step=1}
				<div id="live2-{$templatelite.section.foo.index}" class="live2-item">&nbsp;</div>
		{/section}
	</div>
</div><!--#container closed-->
