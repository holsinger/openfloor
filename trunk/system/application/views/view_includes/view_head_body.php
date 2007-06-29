<?php

?>
	<div id="page">
		<!-- header start here -->
		<div id="header">
			<h1><a href="http://www.politic20.com">Politic20</a></h1>
			<? if ($this->session->userdata('user_name')) { ?>
			<div id="userLogin">Welcome, <a href="index.php/user/profile/<?=$this->session->userdata('user_name');?>"><?=$this->session->userdata('user_name');?></a>&nbsp;|&nbsp;<a href="index.php/user/profile/<?=$this->session->userdata('user_name');?>">Manage Account</a>&nbsp;|&nbsp;<a href="index.php/user/logout/">Logout</a></div>
			<? } else { ?>
			<div id="userLogin"><span onClick="showBox('login');">Login</span>&nbsp;|&nbsp;<a href="index.php/user/createAccount/">Create Account</a></div>
			<? } ?>
			<form action="whosyourgovt.php" method="get">
				<div>
					<!--
					<input type="text" class="txt" name="zip" value="<?= isset($_GET['zip'])?$_GET['zip']:'' ?>"/>
					<input type="image" src="images/btn-go.gif" alt="search" />
					-->
				</div>
			</form>
		</div>
		<!-- top navigation start here -->
		<div class="body">
      <ul class="top-nav">
  			<li><span><a href="<?= $this->config->site_url();?>">Home</a></span></li>
  			<li><a href="index.php/event/">Events</a></li>
  			<li><a href="#">About Us</a></li>
  			<li><a href="http://blog.politic20.com">Blog</a></li>
  
  		</ul>
  		<div class="slogan"><strong class="slogan">populace politic change</strong></div>
  		
  		<div id="pagewidth">
  			
  			<div class="frame">
  		