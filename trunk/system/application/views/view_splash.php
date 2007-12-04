<?
//var_dump($data);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Politics,Election, Government, Democrate, Events, Open Floor, Republican" />
	<meta name="Keywords" content="RunPolitics is a non-partisan political social tool that allows you to: discuss political issues with others, present questions related to issues that affect you, request events where politicians and candidates will answer your questions, & participate in live, online OpenFloor events where the top questions will be asked." />
	<meta name="Description" content="RunPolitics.com" />
	<base href="<?= $this->config->site_url();?>" />
	<script src="./javascript/prototype.js" type="text/javascript"></script>
	<script src="./javascript/scriptaculous.js" type="text/javascript"></script>	
	<script type="text/javascript" charset="utf-8" src="javascript/ajaxVideo.js"></script>
	<script type="text/javascript" charset="utf-8" src="javascript/userWindow.js"></script>
	<script type="text/javascript">
			site_url = '<?= $this->config->site_url();?>';
		</script>
	<meta name="robots" content="all" />
	<title>Run Politics</title>
	<link href="css/splash.css" rel="stylesheet" type="text/css" />
	<link href="css/userWindow.css" rel="stylesheet" type="text/css" />
	<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="<?= $this->config->site_url() ?>css/lt7.css" /><![endif]-->
</head>
<body>
<!--  load AJAX views -->
<div id="overlay" onclick="hideBox()" style="display:none"></div>
<div id="hijax" style="display:none"></div>
<div id="back">
  <div id="banner">
    <ul class="topLinks">
      <li class="link_a"><a href="<?= $this->config->site_url();?>user/login">LOGIN</a></li>
      <li class="link_b"><a href="<?= $this->config->site_url();?>user/createAccount">CREATE ACCOUNT</a></li>
    </ul>
    <h1><span>Run Politics</span></h1>
    <h3><span>You are the party!</span></h3>
  </div>
  <div id="front">
	<div id="bg_front">
	    <ul class="nav">
	    	<li class="fist">
	        <h3>&nbsp;<span>Demand</span></h3>
	        <p><span>Demand to speak to your politician!</span></p>
	        &nbsp;<span class='more_info' onClick="showBox('demand_home')"></span>
	        </li>
	        <li class="question">
	        <h3>&nbsp;<span>Ask</span></h3>
	        <p><span>Ask the questions, and decide which ones get answered!</span></p>
	        &nbsp;<span class='more_info' onClick="showBox('ask_home')"></span>
	        </li>
	        <li class="megaphone">
	        <h3>&nbsp;<span>Participate</span></h3>
	        <p><span>Participate in an event happening now!</span></p>
	        &nbsp;<span class='more_info' onClick="showBox('participate_home')"></span>
	        </li>
	    </ul>
	</div>
  </div>
  <div id="about">
  <br/>
  	<h2>Welcome</h2>
    <p>
    Welcome to RunPolitics, your gateway into the political world. This site is intended<br/> 
    to be a department store of information about the politics that affect you, <br/> 
    a place to find information, opinions of other people like you, and some statistics <br/>
    about the politicians who represent you. Click the button below to jump right in. 
	</p>
  </div>
  <div id="getStarted">
    <h3><a href="<?= $this->config->site_url();?>event">Get Started!</a></h3>
  </div>
  <div id="footer">
	<div id="bg_footer">
	    <ul>
	      <li class="bottomA">
	        <h2>RUNPOLITICS</h2>
	        <ul class="inner_nav">
	          <li class="a1"><a href="http://blog.runpolitics.com">Our Blog<span class="divider">|</span></a></li>
	          <li class="a2"><a href="<?= $this->config->site_url();?>information/aboutUs">About Us<span class="divider">|</span></a></li>
	          <li class="a3"><a href="http://www.zazzle.com/runpolitics">Shop</a></li>
	          <li class="a4"><a href="<?= $this->config->site_url();?>information/view/terms_of_use">Terms of Use<span class="divider">|</span></a></li>
	          <li class="a5"><a href="<?= $this->config->site_url();?>information/press">Press</a></li>
	          <?/*<li class="b4"><a href="#">Terms &amp; Conditions</a></li>*/ ?>
          
	        </ul>
	      </li>
	      <li class="bottomB">
	        <h2>OUR NETWORKS</h2>
	        <ul class="inner_nav">
	          <li class="b1"><a href="http://www.twitter.com/runpolitics">Twitter<span class="divider">|</span></a></li>
	          <?/*<li class="c2"><a href="#">Jaiku<span class="divider">|</span></a></li> */?>
	          <li class="b2"><a href="http://www.myspace.com/politic20">Myspace<span class="divider">|</span></a></li>
	          <li class="b3"><a href="http://www.facebook.com/profile.php?id=14468770213">Facebook</a></li>
	          <li class="b4"><a href="http://runpolitics.tumblr.com/">Tumblr<span class="divider">|</span></a></li>
	          <li class="b5"><a href="http://www.pownce.com/runpolitics">Pownce</a></li>
	        </ul>
	      </li>
	      <li class="bottomC">
	        <h2>HELP &amp; INFO</h2>
	        <ul class="inner_nav">
	          <li class="c1"><a href="<?= $this->config->site_url();?>information/view/event_instructions">Help Center<span class="divider">|</span></a></li>
	          <li class="c2"><a href="<?= $this->config->site_url();?>information/view/faq">FAQ</a></li>
	          <li class="c3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?= $this->config->site_url();?>information/view/privacy_policy">Privacy Policy</a></li>
	        </ul>
	      </li>
	      <li class="bottomD">
	        <h2>BOOKMARK US</h2>
	        <div id="inner_nav_bookmarks">
	          <a href="http://digg.com/submit?phase=2&url=http%3A%2F%2Fwww.runpolitics.com%2F&title=RunPolitics.com%20is%20a%20non-partisan%20political%20social%20tool&bodytext="><img src="images/splash/icon1.png" /></a>
	          <a href="http://del.icio.us/post?url=http%3A%2F%2Fwww.runpolitics.com%2F&title=RunPolitics.com"><img src="images/splash/icon2.png" /></a>
	          <a href="http://reddit.com/submit?url=http%3A%2F%2Frunpolitics.com&title=RunPolitics.com%20is%20a%20non-partisan%20political%20social%20tool"><img src="images/splash/icon3.png" /></a>
	          <a href="http://www.stumbleupon.com/submit?url=href=http%3A%2F%2Frunpolitics.com&title=RunPolitics.com%20is%20a%20non-partisan%20political%20social%20tool"><img src="images/splash/icon4.png" /></a>
	          <a href="http://myweb2.search.yahoo.com/myresults/bookmarklet?u=http%3A%2F%2Frunpolitics.com&t=RunPolitics.com%20is%20a%20non-partisan%20political%20social%20tool"><img src="images/splash/icon5.png" /></a>
	          <a href="http://www.newsvine.com/_wine/save?popoff=0&u=http%3A%2F%2Frunpolitics.com&h=RunPolitics.com%20is%20a%20non-partisan%20political%20social%20tool"><img src="images/splash/icon6.png" /></a>
	          <a href="http://www.google.com/bookmarks/mark?op=add&title=RunPolitics.com%20is%20a%20non-partisan%20political%20social%20tool&bkmk=http%3A%2F%2Frunpolitics.com"><img src="images/splash/icon7.png" /></a>
	      </li>
	    </ul>
	</div>
  </div>
</div>
</body>
</html>
