														<h3>
{php}
															echo "<a onclick=\"new Effect.toggle('cats','blind', {queue: 'end'}); \" class=\"close\">close</a>";
{/php}
															<span class="categories">{#PLIGG_Visual_Category_Title#}</span></h3>
														<div class="box" id="cats">
															<ul class="list-rss">
{section name=thecat loop=$cat_array}
																<li>
{if $pagename eq "index"}
																	<a href="{$URL_rss2category, $cat_array[thecat].auto_id}" class="rss">rss</a><a href="{$URL_maincategory, $cat_array[thecat].safename}">{$cat_array[thecat].name}</a>
{else}
																	<a href="{$URL_rss2category, $cat_array[thecat].auto_id}" class="rss">rss</a><a href="{$URL_maincategory, $cat_array[thecat].safename}">{$cat_array[thecat].name}</a>
{/if}
																</li>
{/section}
															</ul>
														</div>
														<div class="box-bottom"></div>