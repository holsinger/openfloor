														<h3>
<?php 
															echo "<a onclick=\"new Effect.toggle('cats','blind', {queue: 'end'}); \" class=\"close\">close</a>";
 ?>
															<span class="categories"><?php echo $this->_confs['PLIGG_Visual_Category_Title']; ?>
</span></h3>
														<div class="box" id="cats">
															<ul class="list-rss">
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
																<li>
<?php if ($this->_vars['pagename'] == "index"): ?>
																	<a href="<?php echo $this->_vars['URL_rss2category'].$this->_vars['cat_array'][$this->_sections['thecat']['index']]['auto_id']; ?>
" class="rss">rss</a><a href="<?php echo $this->_vars['URL_maincategory'].$this->_vars['cat_array'][$this->_sections['thecat']['index']]['safename']; ?>
"><?php echo $this->_vars['cat_array'][$this->_sections['thecat']['index']]['name']; ?>
</a>
<?php else: ?>
																	<a href="<?php echo $this->_vars['URL_rss2category'].$this->_vars['cat_array'][$this->_sections['thecat']['index']]['auto_id']; ?>
" class="rss">rss</a><a href="<?php echo $this->_vars['URL_maincategory'].$this->_vars['cat_array'][$this->_sections['thecat']['index']]['safename']; ?>
"><?php echo $this->_vars['cat_array'][$this->_sections['thecat']['index']]['name']; ?>
</a>
<?php endif; ?>
																</li>
<?php endfor; endif; ?>
															</ul>
														</div>
														<div class="box-bottom"></div>