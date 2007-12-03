<?php

?>
<body>
	<!--  load AJAX views -->
	<div id="overlay" style="display:none"></div>
	<div id="hijax" style="display:none"></div>
	<? //$this->load->view('ajax/aview_zip_nine.php'); ?>
	<? $this->load->view('ajax/aview_login.php'); ?>
    <div id="root">
        <div class="frame"><div class="ctl"><div class="ctr"><div class="cbr"><div class="cbl">
            <div class="top-menu">
                <ul class="left">
                    <li><?=anchor('', 'HOME')?></li>
                </ul>
                <ul class="right" id="userLogin">
					<? if ($this->userauth->isUser()):?>
						<li class="login">Welcome, <?=anchor("user/profile/{$this->userauth->user_name}",$this->userauth->display_name,'user');?>&nbsp;(<span onClick="showBox('karma_explained');" class='link'><?=$this->userauth->user_karma;?></span></li>
						<li><div id='karma_star'></div></li>
						<li>)</li>
						<li class="separator">|</li>
						<li><?=anchor('user/profile/'.$this->userauth->user_name,'Manage Account');?></li>
						<li class="separator">|</li>
						<li><?=anchor('user/logout/',"Logout");?></li>
					<? else: ?>
						<li><a onClick="showBox('login');">Login</a></li>
						<li class="separator">|</li>					
						<li><?= anchor('user/createAccount','Create Account');?></li>
					<? endif; ?>
                </ul>
            </div>
            
            <div class="header">
                <div class="flag">  
                    <span class="left-banner">
					</span>
                    <a href="#" class="logo"><img src="images/logo.gif" alt="" /></a>
                    <span class="right-banner">
                    </span>
                </div>
				<div class="menu-container">
	                <div class="menu">
	                    <div class="links">
							<img src="images/RP_YOUaretheparty.gif" style="position:relative;top:5px;"/>
	                        <!-- <a href="#"><img src="images/people.gif" alt="" /></a>
	                        <div class="sep"></div>
	                        <a href="#"><img src="images/politics.gif" alt="" /></a>
	                        <div class="sep"></div>
	                        <a href="#"><img src="images/change.gif" alt="" /></a> -->
	                    </div>
	                    
	                    <!-- <div class="update">Last Update: <span>9:32 AM MST</span></div> -->
	                </div>
				</div>
            </div>
            
            <div class="content">
                <table cellspacing="0" cellpadding="0" border="0">
					<tr>