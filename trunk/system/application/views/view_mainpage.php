<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<base href="<?= $this->config->site_url();?>" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Run Politics</title>
<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="css/ie6.css" /><![endif]-->
<!--[if gt IE 6]><link rel="stylesheet" type="text/css" href="css/ie7.css" /><![endif]-->

<!-- 

CSS DEPENDENCIES
#dependency all2.css
#dependency main.css
#dependency userWindow.css
#dependency googleVideo.css
#dependency googleBar.css

JAVASCRIPT DEPENDENCIES
#dependency /lib/prototype.js
#dependency /src/scriptaculous.js
#dependency /src/effects.js
#dependency userWindow.js

-->

<!-- #dependencies -->

<script type="text/javascript">
	site_url = '<?= $this->config->site_url();?>';
	username = '<?=$this->userauth->user_name;?>';
</script>

<style type="text/css" media="screen">
	 @import url("http://www.google.com/uds/css/gsearch.css");
</style>
<style type="text/css" media="screen">
	@import url("http://www.google.com/uds/solutions/newsbar/gsnewsbar.css");
</style>

</head>
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
                    <li class="separator">|</li>
                    <li><?=anchor("event/","EVENTS");?></li>
                    <li class="separator">|</li>
					<li><?=anchor("information/aboutUs","ABOUT US");?></li>
                    <li class="separator">|</li>
					<li><a href="http://blog.runpolitics.com">BLOG</a></li>
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
						<li><a onClick="showBox('login');">Login</a></li>
						<li class="separator">|</li>					
						<li><?= anchor('user/createAccount','Create Account');?></li>
					<? } ?>
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
	                    <div class="date"><?=date('l, F j, Y');?></div>
	                    
	                    <div class="links">
							<img src="images/RP_YOUaretheparty.gif" style="position:relative;top:5px;left:91px;"/>
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
                <div class="col-center-container">
	                <div class="col-left">
	                    
						<h1>MORE</h1>
	                    <?/*
						<h1>MY GOVERNMENT</h1>
	                    <h2>STATE</h2>
	                    <a href="#">Governor</a>
	                    */?>
	                    <h2>Political</h2>
	                    <a href="http://media.runpolitics.com/category/policy/">Policy</a>
	                    <a href="http://media.runpolitics.com/category/elections/">Elections</a>
	                    <a href="http://media.runpolitics.com/category/beltway/">Beltway</a>
	                    <a href="http://media.runpolitics.com/category/commentary/">Commentary</a>
	                    <a href="http://media.runpolitics.com/category/hot-topics/">Hot Topics</a>															
											<a href="http://media.runpolitics.com/">All</a>
											
											<br /><br />
											<form id="searchform" action="http://media.runpolitics.com/" method="get">
											<input id="s" type="text" name="s" size="10" class='txt' value=""/>
											<br />
											<input id="searchsubmit" type="submit" value="Search"/ class='button'>
											</form>	
						
	                </div>
	                <div class="col-center">	
	                    <?=$center;?>
	                </div>
                </div>
                <div class="col-right">
                    <?=$right;?>
                    
                </div>
            </div>
            
            <div class="footer">Copyright &copy; 2007 RunPolitics.com. All Rights Reserved. Reproduction in whole<br />or part in any form or medium without express written permission is strictly prohibited.</div>
			<div class="contact_us"><a href="<?=$this->config->site_url()?>contact/showForm/contact_us">Contact Us</a></div>
        </div></div></div></div></div>
    </div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
    
    </script>
    
    <script type="text/javascript">
    
    _uacct = "UA-1010094-3";
    urchinTracker();
    </script>
</body>
</html>