<?php $this->config_load("/libs/lang.conf", null, null); ?>
														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
																				<div id="comments">
<h2><?php echo $this->_vars['page_header']; ?>
</h2>
<?php if ($this->_vars['register_error'] == true): ?>
	<div class="form-error"><p><?php echo $this->_vars['register_error_text']; ?>
</p></div>
<?php else: ?>
	<div id="contents-wide">
		<form action="<?php echo $this->_vars['URL_register']; ?>
" method="post" id="thisform">
			<span class="sign"><?php echo $this->_confs['PLIGG_Visual_Register_Validation']; ?>
</span>
				<?php echo $this->_confs['PLIGG_Visual_Register_Enter_Number']; ?>
<br />				
				<input type="hidden" name="ts_random" value="<?php echo $this->_vars['ts_random']; ?>
" /><br />
				<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/ts_image.php?ts_random=<?php echo $this->_vars['ts_random']; ?>
" class="ch2" />
				<p><input type="text" size="20" name="ts_code" /><br /><br />			
				<input type="submit" name="submit" value="<?php echo $this->_confs['PLIGG_Visual_Register_Continue']; ?>
" class="submit" /></p>
				<input type="hidden" name="process" value="2" />
				<input type="hidden" name="email" value="<?php echo $_POST['email']; ?>
" />
				<input type="hidden" name="username" value="<?php echo $_POST['username']; ?>
" />
				<input type="hidden" name="password" value="<?php echo $_POST['password']; ?>
" />
				<input type="hidden" name="reghash" value="<?php echo $this->_vars['reghash']; ?>
" />
		</form>
	</div>
<?php endif; ?>
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