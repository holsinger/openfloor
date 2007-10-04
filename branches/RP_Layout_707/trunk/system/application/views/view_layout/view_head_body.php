<?php

?>
<body>
	<!--  load AJAX views -->
	<div id="overlay" onclick="hideBox()" style="display:none"></div>
	<div id="hijax" style="display:none"></div>
	<? //$this->load->view('ajax/aview_zip_nine.php'); ?>
	<? $this->load->view('ajax/aview_login.php'); ?>
    <div id="root">
        <div class="frame"><div class="ctl"><div class="ctr"><div class="cbr"><div class="cbl">
            <div class="top-menu">
                <ul class="left">
                    <li><?=anchor('', 'Home')?></li>
                    <li class="separator">|</li>
                    <li><?=anchor("event/","Events");?></li>
                    <li class="separator">|</li>
					<li><?=anchor("information/view/about_us","About Us");?></li>
                    <li class="separator">|</li>
					<li><a href="http://blog.runpolitics.com">Blog</a></li>
                </ul>
                <ul class="right" id="userLogin">
					<? if ($this->userauth->isUser()) { ?>
						<li class="login">Welcome, <?=anchor("user/profile/{$this->userauth->user_name}",$this->userauth->display_name,'user');?>&nbsp;(<span onClick="showBox('karma_explained');" class='link'><?=$this->userauth->user_karma;?></span></li>
						<li><img src="images/karma_star_default.png" style='top:4px;'></li>
						<li>)</li>
						<li class="separator">|</li>
						<li><?=anchor('user/profile/'.$this->userauth->user_name,'Manage Account');?></li>
						<li class="separator">|</li>
						<li><?=anchor('user/logout/',"Logout");?></li>
					<? } else { ?>
						<li><img src="images/openid-icon-small.gif" style='top:4px;'></li>
						<li><a onClick="showBox('login');">Login</a></li>
						<li class="separator">|</li>					
						<li><?= anchor('user/createAccount','Create Account');?></li>
					<? } ?>
                </ul>
            </div>
            
            <div class="header">
                <div class="flag">  
                    <span class="left-banner">
					<script type="text/javascript"><!--
					google_ad_client = "pub-1655877598275494";
					google_ad_width = 180;
					google_ad_height = 150;
					google_ad_format = "180x150_as";
					google_ad_type = "text_image";
					google_ad_channel = "";
					google_color_border = "ffffff";
					google_color_bg = "FFFFFF";
					google_color_link = "0000FF";
					google_color_text = "000000";
					google_color_url = "008000";
					google_ui_features = "rc:0";
					//-->
					</script>
					<script type="text/javascript"
					  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
					</span>
                    <a href="#" class="logo"><img src="images/logo.gif" alt="" /></a>
                    <span class="right-banner">
                    <script type="text/javascript"><!--
					google_ad_client = "pub-1655877598275494";
					google_ad_width = 180;
					google_ad_height = 150;
					google_ad_format = "180x150_as";
					google_ad_type = "text_image";
					google_ad_channel = "";
					google_color_border = "ffffff";
					google_color_bg = "FFFFFF";
					google_color_link = "0000FF";
					google_color_text = "000000";
					google_color_url = "008000";
					google_ui_features = "rc:0";
					//-->
					</script>	
					<script type="text/javascript"
					  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>					
                    </span>
                </div>
				<div class="menu-container">
	                <div class="menu">
	                    <div class="date"><?=date('l, F j, Y');?></div>
	                    
	                    <div class="links">
	                        <a href="#"><img src="images/people.gif" alt="" /></a>
	                        <div class="sep"></div>
	                        <a href="#"><img src="images/politics.gif" alt="" /></a>
	                        <div class="sep"></div>
	                        <a href="#"><img src="images/change.gif" alt="" /></a>
	                    </div>
	                    
	                    <!-- <div class="update">Last Update: <span>9:32 AM MST</span></div> -->
	                </div>
				</div>
            </div>
            
            <div class="content">
                <div class="col-center-container">