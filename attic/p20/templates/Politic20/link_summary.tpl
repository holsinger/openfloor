																				<div class="topic">
																					<div class="raiting">
																						<a href="javascript:{$link_shakebox_javascript_vote}" class="up">up</a>
																						<a href="javascript:{$link_shakebox_javascript_vote_negative}" class="down">down</a>
																						<a href="javascript:{$link_shakebox_javascript_vote}"><strong id="mnms-{$link_shakebox_index}">{$link_shakebox_votes}</strong></a>
																					</div>
																					<div class="describtion">
																						<div class="describtion-frame">
																							<div class="descr-tr">
																								<div class="descr-bl">
																									<div class="descr-br">
																										<h3>
																										{if $use_title_as_link eq true}
																											{if $url_short neq "http://" && $url_short neq "://"}
																											<a href="{$url}" {if $open_in_new_window eq true} target="_blank"{/if}>{$title_short}</a>
																											{else}
																											<a href="{$story_url}">{$title_short}</a>
																											{/if}
																										{else}
																											<a href="{$story_url}">{$title_short}</a>
																										{/if}
																										</h3>
																										<div class="autor">
																											{if $UseAvatars neq "0"}<a href="{$submitter_profile_url}"><img src="{$Avatar_ImgSrc}" alt="Avatar" /></a>{/if}
																											<p>{#PLIGG_Visual_LS_Posted_By#}: <a href="{$submitter_profile_url}">{$link_submitter}</a>{$link_submit_timeago} {#PLIGG_Visual_Comment_Ago#}
																												<span id="ls_story_link-{$link_shakebox_index}">
																												{if $url_short neq "http://" && $url_short neq "://"}
																													<a href="{$url}" {if $open_in_new_window eq true} target="_blank"{/if} class="screen">({$url_short})</a>
																												{else}
																													({$No_URL_Name})
																												{/if}
																												</span>
																											</p>
																											<p>{#PLIGG_MiscWords_Category#}: <a href="{$category_url}">{$link_category}</a>
																												{if $enable_tags eq 'true'}
																												{if $tags ne ''}
																												| {#PLIGG_Visual_Tags_Link_Summary#}: 
																													{section name=thistag loop=$tag_array}
																														<a href="{$tags_url_array[thistag]}">{$tag_array[thistag]}</a>
																													{/section}
																												{/if}
																												{/if}
																											{if $isadmin eq "yes" || $user_logged_in eq $link_submitter}
																												| <a href="javascript://" onclick="var replydisplay=document.getElementById('ls_adminlinks-{$link_shakebox_index}').style.display ? '' : 'none';document.getElementById('ls_adminlinks-{$link_shakebox_index}').style.display = replydisplay;">{#PLIGG_Visual_Admin_Links#}</a>
																											{/if}
																												<span id="ls_adminlinks-{$link_shakebox_index}" style="display:none">
																													{if $isadmin eq "yes"}
																														<span id="ls_admin_links-{$link_shakebox_index}">
																															<br /><a href="{$story_edit_url}">{#PLIGG_Visual_LS_Admin_Edit#}</a>
																															| <a href="{$story_admin_url}">{#PLIGG_Visual_LS_Admin_Status#}</a>
																														</span>
																													{else}
																														{if $user_logged_in eq $link_submitter}
																															<span id="ls_user_edit_links-{$link_shakebox_index}"><br /><a href="{$story_edit_url}">{#PLIGG_Visual_LS_Admin_Edit#}</a></span>
																														{/if}
																													{/if}
																												</span>
																											</p>
																										</div>
																										<p>{if $show_content neq 'FALSE'}{$story_content}{/if}{if $pagename neq "story"} <a href="{$story_url}" class="more">{#PLIGG_Visual_Read_More#} &raquo;</a> {/if}</p>
																										<ul class="options">
																											<li class="discuss"><a href="{$story_url}">{#PLIGG_MiscWords_Discuss#}</a></li>
{if $url_short neq "http://" && $url_short neq "://"}
																											<li class="trackback"><span id="ls_trackback-{$link_shakebox_index}"><a href="{$trackback_url}" title="{$trackback_url}">{#PLIGG_MiscWords_Trackback#}</a></span></li>
{/if} 	
																											{if $Enable_Recommend eq 1}
																												{if $Recommend_Type eq 1}
																													<li class="tell-friend" id="ls_recommend-{$link_shakebox_index}"><a href="javascript://" onclick="show_recommend({$link_shakebox_index}, {$link_id}, '{$instpath}');">{#PLIGG_Visual_Recommend_Link_Text#}</a></li>
																												{/if}
																												{if $Recommend_Type eq 2}
																													<li class="tell-friend" id="ls_recommend-{$link_shakebox_index}"><a href="{$recommend_url}">Tell a friend</a></li>
																												{/if}
																											{/if}	
																										</ul>
																										{if $Enable_Recommend eq 1}
																											{if $Recommend_Type eq 1}
																												<span id="emailto-{$link_shakebox_index}" style="display:none"></span>
																											{/if}
																										{/if}


																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>