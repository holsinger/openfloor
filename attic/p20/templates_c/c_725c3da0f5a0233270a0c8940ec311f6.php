																				<div class="topic">
																					<div class="raiting">
																						<a href="javascript:<?php echo $this->_vars['link_shakebox_javascript_vote']; ?>
" class="up">up</a>
																						<a href="javascript:<?php echo $this->_vars['link_shakebox_javascript_vote_negative']; ?>
" class="down">down</a>
																						<a href="javascript:<?php echo $this->_vars['link_shakebox_javascript_vote']; ?>
"><strong id="mnms-<?php echo $this->_vars['link_shakebox_index']; ?>
"><?php echo $this->_vars['link_shakebox_votes']; ?>
</strong></a>
																					</div>
																					<div class="describtion">
																						<div class="describtion-frame">
																							<div class="descr-tr">
																								<div class="descr-bl">
																									<div class="descr-br">
																										<h3>
																										<?php if ($this->_vars['use_title_as_link'] == true): ?>
																											<?php if ($this->_vars['url_short'] != "http://" && $this->_vars['url_short'] != "://"): ?>
																											<a href="<?php echo $this->_vars['url']; ?>
" <?php if ($this->_vars['open_in_new_window'] == true): ?> target="_blank"<?php endif; ?>><?php echo $this->_vars['title_short']; ?>
</a>
																											<?php else: ?>
																											<a href="<?php echo $this->_vars['story_url']; ?>
"><?php echo $this->_vars['title_short']; ?>
</a>
																											<?php endif; ?>
																										<?php else: ?>
																											<a href="<?php echo $this->_vars['story_url']; ?>
"><?php echo $this->_vars['title_short']; ?>
</a>
																										<?php endif; ?>
																										</h3>
																										<div class="autor">
																											<?php if ($this->_vars['UseAvatars'] != "0"): ?><a href="<?php echo $this->_vars['submitter_profile_url']; ?>
"><img src="<?php echo $this->_vars['Avatar_ImgSrc']; ?>
" alt="Avatar" /></a><?php endif; ?>
																											<p><?php echo $this->_confs['PLIGG_Visual_LS_Posted_By']; ?>
: <a href="<?php echo $this->_vars['submitter_profile_url']; ?>
"><?php echo $this->_vars['link_submitter']; ?>
</a><?php echo $this->_vars['link_submit_timeago']; ?>
 <?php echo $this->_confs['PLIGG_Visual_Comment_Ago']; ?>

																												<span id="ls_story_link-<?php echo $this->_vars['link_shakebox_index']; ?>
">
																												<?php if ($this->_vars['url_short'] != "http://" && $this->_vars['url_short'] != "://"): ?>
																													<a href="<?php echo $this->_vars['url']; ?>
" <?php if ($this->_vars['open_in_new_window'] == true): ?> target="_blank"<?php endif; ?> class="screen">(<?php echo $this->_vars['url_short']; ?>
)</a>
																												<?php else: ?>
																													(<?php echo $this->_vars['No_URL_Name']; ?>
)
																												<?php endif; ?>
																												</span>
																											</p>
																											<p><?php echo $this->_confs['PLIGG_MiscWords_Category']; ?>
: <a href="<?php echo $this->_vars['category_url']; ?>
"><?php echo $this->_vars['link_category']; ?>
</a>
																												<?php if ($this->_vars['enable_tags'] == 'true'): ?>
																												<?php if ($this->_vars['tags'] != ''): ?>
																												| <?php echo $this->_confs['PLIGG_Visual_Tags_Link_Summary']; ?>
: 
																													<?php if (isset($this->_sections['thistag'])) unset($this->_sections['thistag']);
$this->_sections['thistag']['name'] = 'thistag';
$this->_sections['thistag']['loop'] = is_array($this->_vars['tag_array']) ? count($this->_vars['tag_array']) : max(0, (int)$this->_vars['tag_array']);
$this->_sections['thistag']['show'] = true;
$this->_sections['thistag']['max'] = $this->_sections['thistag']['loop'];
$this->_sections['thistag']['step'] = 1;
$this->_sections['thistag']['start'] = $this->_sections['thistag']['step'] > 0 ? 0 : $this->_sections['thistag']['loop']-1;
if ($this->_sections['thistag']['show']) {
	$this->_sections['thistag']['total'] = $this->_sections['thistag']['loop'];
	if ($this->_sections['thistag']['total'] == 0)
		$this->_sections['thistag']['show'] = false;
} else
	$this->_sections['thistag']['total'] = 0;
if ($this->_sections['thistag']['show']):

		for ($this->_sections['thistag']['index'] = $this->_sections['thistag']['start'], $this->_sections['thistag']['iteration'] = 1;
			 $this->_sections['thistag']['iteration'] <= $this->_sections['thistag']['total'];
			 $this->_sections['thistag']['index'] += $this->_sections['thistag']['step'], $this->_sections['thistag']['iteration']++):
$this->_sections['thistag']['rownum'] = $this->_sections['thistag']['iteration'];
$this->_sections['thistag']['index_prev'] = $this->_sections['thistag']['index'] - $this->_sections['thistag']['step'];
$this->_sections['thistag']['index_next'] = $this->_sections['thistag']['index'] + $this->_sections['thistag']['step'];
$this->_sections['thistag']['first']	  = ($this->_sections['thistag']['iteration'] == 1);
$this->_sections['thistag']['last']	   = ($this->_sections['thistag']['iteration'] == $this->_sections['thistag']['total']);
?>
																														<a href="<?php echo $this->_vars['tags_url_array'][$this->_sections['thistag']['index']]; ?>
"><?php echo $this->_vars['tag_array'][$this->_sections['thistag']['index']]; ?>
</a>
																													<?php endfor; endif; ?>
																												<?php endif; ?>
																												<?php endif; ?>
																											<?php if ($this->_vars['isadmin'] == "yes" || $this->_vars['user_logged_in'] == $this->_vars['link_submitter']): ?>
																												| <a href="javascript://" onclick="var replydisplay=document.getElementById('ls_adminlinks-<?php echo $this->_vars['link_shakebox_index']; ?>
').style.display ? '' : 'none';document.getElementById('ls_adminlinks-<?php echo $this->_vars['link_shakebox_index']; ?>
').style.display = replydisplay;"><?php echo $this->_confs['PLIGG_Visual_Admin_Links']; ?>
</a>
																											<?php endif; ?>
																												<span id="ls_adminlinks-<?php echo $this->_vars['link_shakebox_index']; ?>
" style="display:none">
																													<?php if ($this->_vars['isadmin'] == "yes"): ?>
																														<span id="ls_admin_links-<?php echo $this->_vars['link_shakebox_index']; ?>
">
																															<br /><a href="<?php echo $this->_vars['story_edit_url']; ?>
"><?php echo $this->_confs['PLIGG_Visual_LS_Admin_Edit']; ?>
</a>
																															| <a href="<?php echo $this->_vars['story_admin_url']; ?>
"><?php echo $this->_confs['PLIGG_Visual_LS_Admin_Status']; ?>
</a>
																														</span>
																													<?php else: ?>
																														<?php if ($this->_vars['user_logged_in'] == $this->_vars['link_submitter']): ?>
																															<span id="ls_user_edit_links-<?php echo $this->_vars['link_shakebox_index']; ?>
"><br /><a href="<?php echo $this->_vars['story_edit_url']; ?>
"><?php echo $this->_confs['PLIGG_Visual_LS_Admin_Edit']; ?>
</a></span>
																														<?php endif; ?>
																													<?php endif; ?>
																												</span>
																											</p>
																										</div>
																										<p><?php if ($this->_vars['show_content'] != 'FALSE'):  echo $this->_vars['story_content'];  endif;  if ($this->_vars['pagename'] != "story"): ?> <a href="<?php echo $this->_vars['story_url']; ?>
" class="more"><?php echo $this->_confs['PLIGG_Visual_Read_More']; ?>
 &raquo;</a> <?php endif; ?></p>
																										<ul class="options">
																											<li class="discuss"><a href="<?php echo $this->_vars['story_url']; ?>
"><?php echo $this->_confs['PLIGG_MiscWords_Discuss']; ?>
</a></li>
<?php if ($this->_vars['url_short'] != "http://" && $this->_vars['url_short'] != "://"): ?>
																											<li class="trackback"><span id="ls_trackback-<?php echo $this->_vars['link_shakebox_index']; ?>
"><a href="<?php echo $this->_vars['trackback_url']; ?>
" title="<?php echo $this->_vars['trackback_url']; ?>
"><?php echo $this->_confs['PLIGG_MiscWords_Trackback']; ?>
</a></span></li>
<?php endif; ?> 	
																											<?php if ($this->_vars['Enable_Recommend'] == 1): ?>
																												<?php if ($this->_vars['Recommend_Type'] == 1): ?>
																													<li class="tell-friend" id="ls_recommend-<?php echo $this->_vars['link_shakebox_index']; ?>
"><a href="javascript://" onclick="show_recommend(<?php echo $this->_vars['link_shakebox_index']; ?>
, <?php echo $this->_vars['link_id']; ?>
, '<?php echo $this->_vars['instpath']; ?>
');"><?php echo $this->_confs['PLIGG_Visual_Recommend_Link_Text']; ?>
</a></li>
																												<?php endif; ?>
																												<?php if ($this->_vars['Recommend_Type'] == 2): ?>
																													<li class="tell-friend" id="ls_recommend-<?php echo $this->_vars['link_shakebox_index']; ?>
"><a href="<?php echo $this->_vars['recommend_url']; ?>
">Tell a friend</a></li>
																												<?php endif; ?>
																											<?php endif; ?>	
																										</ul>
																										<?php if ($this->_vars['Enable_Recommend'] == 1): ?>
																											<?php if ($this->_vars['Recommend_Type'] == 1): ?>
																												<span id="emailto-<?php echo $this->_vars['link_shakebox_index']; ?>
" style="display:none"></span>
																											<?php endif; ?>
																										<?php endif; ?>


																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>