<?php $this->config_load("/libs/lang.conf", null, null); ?>
														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
																				<div id="comments">
<div class="form-error">
<br/>
<p>
<?php if ($this->_vars['register_error_text'] == "errorinserting"): ?>
	<?php echo $this->_confs['PLIGG_Visual_Register_Error_Inserting']; ?>
	
<?php endif; ?>
<?php if ($this->_vars['register_error_text'] == "usernameexists"): ?>
	<?php echo $this->_confs['PLIGG_Visual_Register_Error_UserExists']; ?>
	
<?php endif; ?>
<?php if ($this->_vars['register_error_text'] == "badcode"): ?>
	<?php echo $this->_confs['PLIGG_Visual_Register_Error_BadCode']; ?>
	
<?php endif; ?>
<?php if ($this->_vars['register_error_text'] == "nopassmatch"): ?>
	<?php echo $this->_confs['PLIGG_Visual_Register_Error_NoPassMatch']; ?>
	
<?php endif; ?>
<?php if ($this->_vars['register_error_text'] == "fivecharpass"): ?>
	<?php echo $this->_confs['PLIGG_Visual_Register_Error_FiveCharPass']; ?>
	
<?php endif; ?>
<?php if ($this->_vars['register_error_text'] == "emailexists"): ?>
	<?php echo $this->_confs['PLIGG_Visual_Register_Error_EmailExists']; ?>
	
<?php endif; ?>
<?php if ($this->_vars['register_error_text'] == "bademail"): ?>
	<?php echo $this->_confs['PLIGG_Visual_Register_Error_BadEmail']; ?>
	
<?php endif; ?>
<?php if ($this->_vars['register_error_text'] == "usernameinvalid"): ?>
	<?php echo $this->_confs['PLIGG_Visual_Register_Error_UserInvalid']; ?>
	
<?php endif; ?>
<?php if ($this->_vars['register_error_text'] == "usertooshort"): ?>
	<?php echo $this->_confs['PLIGG_Visual_Register_Error_UserTooShort']; ?>
	
<?php endif; ?>
</p>
<input type=button onclick="window.history.go(-1)" value="<?php echo $this->_confs['PLIGG_Visual_Register_Error_Return']; ?>
" class="submit" >
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