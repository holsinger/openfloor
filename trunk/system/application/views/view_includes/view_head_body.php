<?php

?>
	<div id="page">
		<!-- header start here -->
		<div id="header">
			<h1><a href="http://www.politic20.com">Politic20</a></h1>
			<? if ($this->session->userdata('user_name')) { ?>
			<div id="userLogin">Welcome, <?=anchor("user/profile/{$this->session->userdata('user_name')}",$this->session->userdata('user_name'));?>&nbsp;(<span onClick="showBox('karma_explained');" class='link'><?=$this->userauth->user_karma;?></span><img src="./images/karma_star_default.png" style='top:4px;'>)&nbsp;|&nbsp;<?=anchor('user/profile/'.$this->session->userdata('user_name'),'Manage Account');?>&nbsp;|&nbsp;<?=anchor('user/logout/',"Logout");?></div>
			<? } else { ?>
			<div id="userLogin"><img src="images/openid-icon-small.gif" style='top:4px;'>&nbsp;<span onClick="showBox('login');">Login</span>&nbsp;|&nbsp;<a href="index.php/user/createAccount/">Create Account</a></div>
			<? } ?>
			<form action="yourgovernment/" method="get">
				<div>
					<!--
					<input type="text" class="txt" name="zip" value="<?= isset($_GET['zip'])?$_GET['zip']:'' ?>"/>
					<input type="image" src="images/btn-go.gif" alt="search" />
					-->
					
					<!-- AddThis Bookmark Button BEGIN
					<a href="http://www.addthis.com/bookmark.php" onclick="addthis_url   = location.href; addthis_title = document.title; return addthis_click(this);" target="_blank"><img src="http://s9.addthis.com/button2-bm.png" width="160" height="24" border="0" alt="AddThis Social Bookmark Button" /></a> <script type="text/javascript">var addthis_pub = 'jimmysessions';</script><script type="text/javascript" src="http://s9.addthis.com/js/widget.php?v=10"></script>  
					AddThis Bookmark Button END -->
					
				</div>
			</form>
		</div>
		<!-- top navigation start here -->
		<div class="body">
      <ul class="top-nav">
  			<li><span><a href="<?= $this->config->site_url();?>">Home</a></span></li>
  			<li><?=anchor("event/","Events");?></li>
  			<li><?=anchor("information/view/about_us","About Us");?></li>  			
  			<li><a href="http://blog.politic20.com">Blog</a></li>  
  		</ul>
  		<div class="slogan"><strong class="slogan">populace politic change</strong></div>
  		
  		<div id="pagewidth">
  			
  			<div class="frame">
  		