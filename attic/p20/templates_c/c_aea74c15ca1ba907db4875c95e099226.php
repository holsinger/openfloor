														<ul class="tabs">
															<li class="active" id="exp"><span onclick="javascript:toggle1('logtab','exp','regtab','exp2');"><?php echo $this->_confs['PLIGG_Visual_Login_Title']; ?>
</span></li>
															<li id="exp2"><span onclick="javascript:toggle1('regtab','exp2','logtab','exp');"><?php echo $this->_confs['PLIGG_Visual_Register']; ?>
</span></li>
														</ul>
														<div id="logtab">
															<h3>
															<?php 
																echo "<a onclick=\"new Effect.toggle('s3','blind', {queue: 'end'}); \" class=\"close\">close</a>";
															 ?>
																<span class="login"><?php echo $this->_confs['PLIGG_Visual_Login_Title']; ?>
</span></h3>
															<div class="box" id="s3">
																<form action="<?php echo $this->_vars['URL_login']; ?>
" class="login-form" method="post">
																	<ul>
																		<li><label><?php echo $this->_confs['PLIGG_Visual_Login_Username']; ?>
:</label></li>
																		<li><input type="text" class="txt" name="username" value="<?php echo $this->_vars['login_username']; ?>
" /></li>
																		<li><label><?php echo $this->_confs['PLIGG_Visual_Login_Password']; ?>
:</label></li>
																		<li>
																			<input type="password" class="txt" name="password" />
																			<input type="hidden" name="processlogin" value="1" />
																			<input type="hidden" name="return" value="<?php echo $_GET['return']; ?>
"/>
																		</li>
																		<li class="all"><label><?php echo $this->_confs['PLIGG_Visual_Login_Remember']; ?>
:</label><input type="checkbox" class="checkbox" name="persistent" /><input type="image" src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/Politic20/images/btn-login.gif" alt="login" /></li>
																	</ul>
																</form>
																<a href="<?php echo $this->_vars['URL_login']; ?>
" class="more"><?php echo $this->_confs['PLIGG_Visual_What_Is_Pligg_Read_More']; ?>
 &raquo;</a>
															</div>
															<div class="box-bottom"></div>
														</div>
														<div id="regtab" style="display:none;">
															<h3>
															<?php 
																echo "<a onclick=\"new Effect.toggle('s4','blind', {queue: 'end'}); \" class=\"close\">close</a>";
															 ?>
																<span class="login"><?php echo $this->_confs['PLIGG_Visual_Register']; ?>
</span></h3>
															<div class="box" id="s4">
																<form action="<?php echo $this->_vars['my_pligg_base']; ?>
/register.php" method="post" class="login-form">
																	<ul>
																		<li><?php echo $this->_confs['PLIGG_Visual_Register_Username']; ?>
:<br /><input type="text" name="username" id="name" value="" onkeyup="enablebutton(this.form.checkbutton1, this.form.submit, this)" size="20" tabindex="1" class="txt" /></li>
																		<li><?php echo $this->_confs['PLIGG_Visual_Register_Email']; ?>
:<br /><input type="text" id="email" name="email" value=""  onkeyup="enablebutton(this.form.checkbutton2, this.form.submit, this)" size="20" tabindex="2" class="txt"/></li>
																		<li><?php echo $this->_confs['PLIGG_Visual_Register_Password']; ?>
:<br /><input type="password" id="password" name="password" size="20" tabindex="3" class="txt"/></li>
																		<li><?php echo $this->_confs['PLIGG_Visual_Register_Verify_Password']; ?>
:<br /><input type="password" id="verify" name="password2" size="20" tabindex="4" class="txt"/><input type="hidden" name="process" value="1" /></li>
																		<li><input type="submit" name="submit" value="<?php echo $this->_confs['PLIGG_Visual_Register_Create_User']; ?>
" class="log2" tabindex="6" /></li>
																	</ul>
																</form>	
																<a href="<?php echo $this->_vars['URL_register']; ?>
" class="more"><?php echo $this->_confs['PLIGG_Visual_What_Is_Pligg_Read_More']; ?>
 &raquo;</a>
															</div>
															<div class="box-bottom"></div>
														</div>