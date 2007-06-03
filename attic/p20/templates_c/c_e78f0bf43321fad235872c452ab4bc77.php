<?php 
	include_once(mnminclude.'tags.php');
	global $main_smarty;
	
	$cloud=new TagCloud();
	$cloud->smarty_variable = $main_smarty; // pass smarty to the function so we can set some variables
	$cloud->word_limit = 5;
	$cloud->min_points = 6; // the size of the smallest tag
	$cloud->max_points = 15; // the size of the largest tag
	
	$cloud->show();
	$main_smarty = $cloud->smarty_variable; // get the updated smarty back from the function
 ?>

														<h3>
														<?php 
															echo "<a onclick=\"new effect.toggle('s2','blind', {queue: 'end'}); \" class=\"close\">close</a>";
														 ?>
															<span class="top-tags"><?php echo $this->_confs['PLIGG_Visual_Top_5_Tags']; ?>
</span></h3>
														<div class="box" id="s2">
														<?php if (isset($this->_sections['customer'])) unset($this->_sections['customer']);
$this->_sections['customer']['name'] = 'customer';
$this->_sections['customer']['loop'] = is_array($this->_vars['tag_number']) ? count($this->_vars['tag_number']) : max(0, (int)$this->_vars['tag_number']);
$this->_sections['customer']['show'] = true;
$this->_sections['customer']['max'] = $this->_sections['customer']['loop'];
$this->_sections['customer']['step'] = 1;
$this->_sections['customer']['start'] = $this->_sections['customer']['step'] > 0 ? 0 : $this->_sections['customer']['loop']-1;
if ($this->_sections['customer']['show']) {
	$this->_sections['customer']['total'] = $this->_sections['customer']['loop'];
	if ($this->_sections['customer']['total'] == 0)
		$this->_sections['customer']['show'] = false;
} else
	$this->_sections['customer']['total'] = 0;
if ($this->_sections['customer']['show']):

		for ($this->_sections['customer']['index'] = $this->_sections['customer']['start'], $this->_sections['customer']['iteration'] = 1;
			 $this->_sections['customer']['iteration'] <= $this->_sections['customer']['total'];
			 $this->_sections['customer']['index'] += $this->_sections['customer']['step'], $this->_sections['customer']['iteration']++):
$this->_sections['customer']['rownum'] = $this->_sections['customer']['iteration'];
$this->_sections['customer']['index_prev'] = $this->_sections['customer']['index'] - $this->_sections['customer']['step'];
$this->_sections['customer']['index_next'] = $this->_sections['customer']['index'] + $this->_sections['customer']['step'];
$this->_sections['customer']['first']	  = ($this->_sections['customer']['iteration'] == 1);
$this->_sections['customer']['last']	   = ($this->_sections['customer']['iteration'] == $this->_sections['customer']['total']);
?>
														
															
																<ul class="list-rss">
																	<li><a href="<?php echo $this->_vars['tag_url'][$this->_sections['customer']['index']]; ?>
"><?php echo $this->_vars['tag_name'][$this->_sections['customer']['index']]; ?>
</a></li>
																</ul>
															
															
														<?php endfor; endif; ?>
															<a href="<?php echo $this->_vars['URL_tagcloud']; ?>
" class="more"><?php echo $this->_confs['PLIGG_Visual_What_Is_Pligg_Read_More']; ?>
 &raquo;</a>
														</div>
														<div class="box-bottom"></div>