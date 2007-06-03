<fieldset><legend><?php echo $this->_confs['PLIGG_Visual_Submit1_NewsSource']; ?>
</legend>
	<form action="<?php echo $this->_vars['URL_submit']; ?>
" method="post" id="thisform">
		<label for="url"><?php echo $this->_confs['PLIGG_Visual_Submit1_NewsURL']; ?>
:</label>
		<input type="text" name="url" id="url" value="http://" size=55 class="form-full" />
		<input type="hidden" name="phase" value=1>
		<input type="hidden" name="randkey" value="<?php echo $this->_vars['submit_rand']; ?>
">
		<input type="hidden" name="id" value="c_1">
		<input type="submit" value="<?php echo $this->_confs['PLIGG_Visual_Submit1_Continue']; ?>
" class="submit-s" />
	</form>
	<br /><?php if ($this->_vars['Submit_Require_A_URL'] != 1):  echo $this->_confs['PLIGG_Visual_Submit_Editorial'];  endif; ?>
</fieldset>
