														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
																				<div id="comments">
<fieldset><legend>{#PLIGG_Visual_Change_Link_Status#}</legend>
<b>{#PLIGG_Visual_Change_Link_Title#}:</b> {$link_title} <br /><br />
<b>{#PLIGG_Visual_Change_Link_URL#}:</b> {$link_url} <a href = "{$my_base_url}{$my_pligg_base}/manage_banned_domains.php?id={$link_id}&add={$banned_domain_url}">{#PLIGG_Visual_Ban_This_URL#}</a><br /><br />
<b>{#PLIGG_Visual_Change_Link_Content#}:</b> {$link_content}<br /><br />
<b>{#PLIGG_Visual_Change_Link_Status2#}:</b> {$link_status|capitalize}<br /><br />
<b>{#PLIGG_Visual_Change_Link_Submitted_By#}:</b> {$user_login} <a href ="{$my_base_url}{$my_pligg_base}/admin_users.php?mode=disable&user={$user_login}">{#PLIGG_Visual_Disable_This_USer#}</a><br />

<hr />
				
<a href = "{$admin_discard_url}">Set to "discard"</a> - {#PLIGG_Visual_Change_Link_Discard#}<br /><br />
<a href = "{$admin_queued_url}">Set to "queued"</a> - {#PLIGG_Visual_Change_Link_Queued#}<br /><br />
<a href = "{$admin_published_url}">Set to "published"</a> - {#PLIGG_Visual_Change_Link_Published#}<br /><br /></fieldset>
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
