<?php require_once('C:\php5\htdocs\p20\plugins\modifier.repeat_count.php'); $this->register_modifier("repeat_count", "tpl_modifier_repeat_count");  $this->config_load("/libs/lang.conf", null, null); ?>

<script src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/js/submit.js<?php if ($this->_vars['enable_gzip_files'] == 'true'): ?>.gz<?php endif; ?>" type="text/javascript"></script>
														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
																				<div id="comments">
<h2><?php echo $this->_confs['PLIGG_Visual_Submit2_Header']; ?>
</h2>
<form action="<?php echo $this->_vars['URL_submit']; ?>
" method="post" name="thisform">
	<input type="hidden" name="url" id="url" value="<?php echo $this->_vars['submit_url']; ?>
" />
	<input type="hidden" name="phase" value="2" />
	<input type="hidden" name="randkey" value="<?php echo $this->_vars['randkey']; ?>
" />
	<input type="hidden" name="id" value="<?php echo $this->_vars['submit_id']; ?>
" />
	
	<?php if ($this->_vars['Submit_Show_URL_Input'] == 1): ?>
		<?php echo $this->_confs['PLIGG_Visual_Submit2_Source']; ?>

			<p class="l-top"><label for="url" accesskey="2"><?php echo $this->_confs['PLIGG_Visual_Submit2_NewsURL']; ?>
:</label>
			<a href="<?php echo $this->_vars['submit_url']; ?>
" class="simple"><?php echo $this->_vars['submit_url']; ?>
</a></p><br />
			<?php if ($this->_vars['submit_url_title'] != "1"): ?>
				<p class="l-top"><label for="url_title" accesskey="2"><?php echo $this->_confs['PLIGG_Visual_Submit2_URLTitle']; ?>
:</label><?php echo $this->_vars['submit_url_title']; ?>

					<?php if ($this->_vars['submit_type'] == 'blog'): ?>
						<br /> <strong>(<?php echo $this->_confs['PLIGG_Visual_Submit2_IsBlog']; ?>
)</strong>
					<?php endif; ?>
				</p>
			<?php endif; ?>
	<?php endif; ?>
	
	<?php echo $this->_confs['PLIGG_Visual_Submit2_Details']; ?>

		<p class="l-mid"><label for="title" accesskey="1"><?php echo $this->_confs['PLIGG_Visual_Submit2_Title']; ?>
:</label>
		<span class="form-note"><?php echo $this->_confs['PLIGG_Visual_Submit2_TitleInstruct']; ?>
</span>
		<br/><input type="text" id="title" name="title" value="<?php echo $this->_vars['submit_url_title']; ?>
" size="55" maxlength="100" />
		</p>
		<br />
		
		<?php if ($this->_vars['enable_tags'] == 'true'): ?>
			<p class="l-mid">
				<label for="tags" accesskey="4"><?php echo $this->_confs['PLIGG_Visual_Submit2_Tags']; ?>
:</label>
				<span class="form-note"><strong><?php echo $this->_confs['PLIGG_Visual_Submit2_Tags_Inst1']; ?>
</strong> <?php echo $this->_confs['PLIGG_Visual_Submit2_Tags_Example']; ?>
 <em><?php echo $this->_confs['PLIGG_Visual_Submit2_Tags_Inst2']; ?>
</em></span>
				<br/><input type="text" id="tags" name="tags" value="<?php echo $this->_vars['tags_words']; ?>
" size="55" maxlength="40" /><br /><br />
			</p>
		<?php endif; ?>

		<p class="l-mid">
			<label for="bodytext" accesskey="1"><?php echo $this->_confs['PLIGG_Visual_Submit2_Description']; ?>
:</label>
			<span class="form-note"><?php echo $this->_confs['PLIGG_Visual_Submit2_DescInstruct']; ?>
</span>
			<?php if ($this->_vars['Story_Content_Tags_To_Allow'] == ""): ?><br /><b>No</b> <?php echo $this->_confs['PLIGG_Visual_Submit2_HTMLTagsAllowed']; ?>

			<?php else: ?><br /><?php echo $this->_confs['PLIGG_Visual_Submit2_HTMLTagsAllowed']; ?>
: <?php echo $this->_vars['Story_Content_Tags_To_Allow']; ?>

			<?php endif; ?>
			<br/><textarea name="bodytext" rows="10" cols="55" id="bodytext" wrap=SOFT onkeyup="if(this.form.summarycheckbox.checked == false) {this.form.summarytext.value = this.form.bodytext.value.substring(0, <?php echo $this->_vars['StorySummary_ContentTruncate']; ?>
);}textCounter(this.form.summarytext,this.form.remLen, <?php echo $this->_vars['StorySummary_ContentTruncate']; ?>
);"><?php echo $this->_vars['submit_content']; ?>
</textarea><br />
			<?php if ($this->_vars['Spell_Checker'] == 1 || $this->_vars['Spell_Checker'] == 2): ?><input type="button" name="spelling" value="Check Spelling" class="submit" onclick="openSpellChecker('bodytext');"/><?php endif; ?>
			<br /><br />
		</p>

		<?php if ($this->_vars['SubmitSummary_Allow_Edit'] == 1): ?>  
		<p class="l-mid">
			<label for="summarytext" accesskey="1"><?php echo $this->_confs['PLIGG_Visual_Submit2_Summary']; ?>
:</label>
			<span class="form-note"><?php echo $this->_confs['PLIGG_Visual_Submit2_SummaryInstruct'];  echo $this->_confs['PLIGG_Visual_Submit2_SummaryLimit'];  echo $this->_vars['StorySummary_ContentTruncate'];  echo $this->_confs['PLIGG_Visual_Submit2_SummaryLimitCharacters']; ?>
</span>
			<br /><input type = "checkbox" name = "summarycheckbox" id = "summarycheckbox" onclick="SetState(this, this.form.summarytext)"> <?php echo $this->_confs['PLIGG_Visual_Submit2_SummaryCheckBox']; ?>

			<?php if ($this->_vars['Story_Content_Tags_To_Allow'] == ""): ?><br /><b>No</b> <?php echo $this->_confs['PLIGG_Visual_Submit2_HTMLTagsAllowed']; ?>

			<?php else: ?><br /><?php echo $this->_confs['PLIGG_Visual_Submit2_HTMLTagsAllowed']; ?>
: <?php echo $this->_vars['Story_Content_Tags_To_Allow']; ?>

			<?php endif; ?>
			<br/><textarea disabled="true" name="summarytext"  rows="5" cols="55" id="summarytext" wrap=SOFT onkeydown="textCounter(this.form.summarytext,this.form.remLen, <?php echo $this->_vars['StorySummary_ContentTruncate']; ?>
);"><?php echo $this->_vars['submit_summary']; ?>
</textarea><br />
			<input readonly type=text name=remLen size=3 maxlength=3 value="125"><?php echo $this->_confs['PLIGG_Visual_Submit2_SummaryCharactersLeft']; ?>

			<?php if ($this->_vars['Spell_Checker'] == 1): ?><input type="button" name="spelling" value="Check Spelling" class="submit" onclick="openSpellChecker('summarytext');"/><?php endif; ?>
			<br /><br />
		</p>
		<?php endif; ?>
		
		<p class="l-mid">
			<label for="category" accesskey="1"><?php echo $this->_confs['PLIGG_Visual_Submit2_Category']; ?>
:</label>
			<span class="form-note"><?php echo $this->_confs['PLIGG_Visual_Submit2_CatInstruct']; ?>
</span>
			<br/>
			<select name="category">
				<?php if (isset($this->_sections['thecat'])) unset($this->_sections['thecat']);
$this->_sections['thecat']['name'] = 'thecat';
$this->_sections['thecat']['loop'] = is_array($this->_vars['cat_array']) ? count($this->_vars['cat_array']) : max(0, (int)$this->_vars['cat_array']);
$this->_sections['thecat']['show'] = true;
$this->_sections['thecat']['max'] = $this->_sections['thecat']['loop'];
$this->_sections['thecat']['step'] = 1;
$this->_sections['thecat']['start'] = $this->_sections['thecat']['step'] > 0 ? 0 : $this->_sections['thecat']['loop']-1;
if ($this->_sections['thecat']['show']) {
	$this->_sections['thecat']['total'] = $this->_sections['thecat']['loop'];
	if ($this->_sections['thecat']['total'] == 0)
		$this->_sections['thecat']['show'] = false;
} else
	$this->_sections['thecat']['total'] = 0;
if ($this->_sections['thecat']['show']):

		for ($this->_sections['thecat']['index'] = $this->_sections['thecat']['start'], $this->_sections['thecat']['iteration'] = 1;
			 $this->_sections['thecat']['iteration'] <= $this->_sections['thecat']['total'];
			 $this->_sections['thecat']['index'] += $this->_sections['thecat']['step'], $this->_sections['thecat']['iteration']++):
$this->_sections['thecat']['rownum'] = $this->_sections['thecat']['iteration'];
$this->_sections['thecat']['index_prev'] = $this->_sections['thecat']['index'] - $this->_sections['thecat']['step'];
$this->_sections['thecat']['index_next'] = $this->_sections['thecat']['index'] + $this->_sections['thecat']['step'];
$this->_sections['thecat']['first']	  = ($this->_sections['thecat']['iteration'] == 1);
$this->_sections['thecat']['last']	   = ($this->_sections['thecat']['iteration'] == $this->_sections['thecat']['total']);
?>
				   <option value = "<?php echo $this->_vars['cat_array'][$this->_sections['thecat']['index']]['auto_id']; ?>
">
					  <?php if ($this->_vars['cat_array'][$this->_sections['thecat']['index']]['spacercount'] < $this->_vars['lastspacer']):  echo $this->_run_modifier($this->_vars['cat_array'][$this->_sections['thecat']['index']]['spacerdiff'], 'repeat_count', 1, '');  endif; ?>
					  <?php if ($this->_vars['cat_array'][$this->_sections['thecat']['index']]['spacercount'] > $this->_vars['lastspacer']):  endif; ?>
					  <?php echo $this->_run_modifier($this->_vars['cat_array'][$this->_sections['thecat']['index']]['spacercount'], 'repeat_count', 1, '&nbsp;&nbsp;&nbsp;'); ?>

					  <?php echo $this->_vars['cat_array'][$this->_sections['thecat']['index']]['name']; ?>
 
					  &nbsp;&nbsp;&nbsp;       
					  <?php $this->assign('lastspacer', $this->_vars['cat_array'][$this->_sections['thecat']['index']]['spacercount']); ?>
				  </option>
				<?php endfor; endif; ?>
			</select>
		</p>
		
		<br style="clear: both;" />
		
		<?php if ($this->_vars['Submit_Show_URL_Input'] == 1): ?>
			<p class="l-mid"><label for="trackback"><?php echo $this->_confs['PLIGG_Visual_Submit2_Trackback']; ?>
:</label>
				<span class="form-note"><?php echo $this->_confs['PLIGG_Visual_Submit2_TrackbackInstruct']; ?>
</span><br />
				<input type="text" name="trackback" id="trackback" value="<?php echo $this->_vars['submit_trackback']; ?>
" size="55" class="form-full" />
			</p>
			<br />
		<?php endif; ?>
		
		<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include($this->_vars['tpl_extra_fields'].".tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?><br />
		<p class="l-mid">
			<input type="submit" value="<?php echo $this->_confs['PLIGG_Visual_Submit2_Continue']; ?>
" class="submit" />
		<p class="l-mid">
</form>
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