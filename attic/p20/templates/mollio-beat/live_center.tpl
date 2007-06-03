{config_load file="/libs/lang.conf"}
<h2>{#PLIGG_Visual_Live#}</h2>
<div class="air-with-footer">
	<div class="live2">
		<div class="live2-item">
			<div class="live2-ts"><strong>hour</strong></div>
			<div class="live2-type"><strong>action</strong></div>
			<div class="live2-votes"><strong>votes</strong></div>
			<div class="live2-story"><strong>the news</strong></div>
			<div class="live2-who"><strong>user/problem</strong></div>
			<div class="live2-status"><strong>state</strong></div>
		</div>
		{section name=foo start=0 loop=$items_to_show step=1}
				<div id="live2-{$templatelite.section.foo.index}" class="live2-item">&nbsp;</div>
		{/section}
	</div>
</div><!--#container closed-->
