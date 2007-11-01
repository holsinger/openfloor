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
					<? if ($this->userauth->isAdmin()) echo "<li>&nbsp;&nbsp;".anchor('admin/', 'ADMIN')."</li>";?>
                </ul>
                <ul class="right" id="userLogin">
					<? if ($this->userauth->isUser()):?>
						<li class="login">Welcome, <?=anchor("user/profile/{$this->userauth->user_name}",$this->userauth->display_name,'user');?>&nbsp;(<span onClick="showBox('karma_explained');" class='link'><?=$this->userauth->user_karma;?></span></li>
						<li><img src="images/karma_star_default.png" style='top:4px;'></li>
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
                    <span class="left-banner">
						<div style="height: 45px;">
							<img src="./images/sub_site_main/secondary_logo.png" alt="" border="0" style="cursor: pointer;" onclick="window.location = '';"/>
						</div>
						<div style="margin-left: 35px;">
							<div class="date"><?=date('l, F j, Y');?></div>
						</div>
					</span>
					
					<span class="center_text"><?if(isset($top_banner_text)) echo($top_banner_text);?></span>
					
                    <span class="right-banner">	
						<img src="images/RP_YOUaretheparty.gif"/>	
                    </span>
            </div>
            
            <div class="content">
                <div class="col-center-container"  id="col_center_container">