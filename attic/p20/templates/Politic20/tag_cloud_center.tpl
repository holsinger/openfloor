														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
																				<div id="comments">
																					<h2>{#PLIGG_Visual_Tags_Tags#}</h2>

<div id="cab" style="float:right; margin-top:-39px;">
	<ul class="postin">
		{section name=i start=0 loop=$count_range_values step=1}
		{if $templatelite.section.i.index eq $current_range}
			<li><a href="#" class="navbut4"><span>{$range_names[i]}</span></a></li>
		{else}	
			<li><a href="{$URL_tagcloud_range, $templatelite.section.i.index}" class="navbut3"><span>{$range_names[i]}</span></a></li>
		{/if}
		{/section}
	</ul>   
</div>

<div style="margin: 20px 0 20px 0; line-height: {$tags_max_pts}pt; margin-left: 100px;">
	{section name=customer loop=$tag_number}
	<span style="font-size: {$tag_size[customer]}pt"><a href="{$tag_url[customer]}">{$tag_name[customer]}</a></span>&nbsp;&nbsp;
	{/section}
</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="pagers">
															<div class="pbg">
																<div class="list">
																</div>
															</div>
														</div>