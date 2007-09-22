<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<base href="<?= $this->config->site_url();?>" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Run Politics</title>

<style type="text/css" media="screen">
    @import url("css/main.css");
</style>
<style media="all" type="text/css">@import "css/userWindow.css";</style>
<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="css/ie6.css" /><![endif]-->
<script type="text/javascript" src="javascript/lib/prototype.js"></script>
<script src="javascript/src/scriptaculous.js" type="text/javascript"></script>
<script src="javascript/src/effects.js" type="text/javascript"></script>
<script type="text/javascript" src="javascript/userWindow.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAkKcqFPODFw9EgKwKbb0vmxQMMgp4bRk8oDwCMuUVC3eAkH6yhxRey5JriXQU4hISBErCZHOSAAHL4w"></script>
<script type="text/javascript">

google.load("feeds", "1");

function initialize() {
  var feed = new google.feeds.Feed("http://blog.runpolitics.com/category/home/feed");
  feed.load(function(result) {
    if (!result.error) {
      var container = document.getElementById("feed");
      for (var i = 0; i < result.feed.entries.length; i++) {
        var entry = result.feed.entries[i];
      var div = document.createElement("div");
      //create link
      var link = document.createElement("a");
      link.setAttribute("href", entry.link);
      link.className = 'feed_title';
      link.appendChild(document.createTextNode(entry.title));
      div.appendChild(link);
      var text = document.createElement("p");
      //text.setAttribute("href", entry['link']);
      //text.appendChild(document.createTextNode(entry['contentSnippet']));
      text.innerHTML = entry.content;
      div.appendChild(text);
	  var br = document.createElement("br");
	  div.appendChild(br);
      container.appendChild(div);
    }
    }
  });
}
google.setOnLoadCallback(initialize);

</script>
</head>
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
                    <? /*
					<li class="login">Welcome, <a href="#">maryjo8</a> (100 <img class="star" src="images/star.gif" alt="" />)</li>
                    <li class="separator">|</li>
                    <li><a href="#">Manage Account</a></li>
                    <li class="separator">|</li>
                    <li><a href="#">Log Out</a></li>
					*/?>
					<? if ($this->userauth->isUser()) { ?>
						<li class="login">Welcome, <?=anchor("user/profile/{$this->userauth->user_name}",$this->userauth->display_name,'user');?>&nbsp;(<span onClick="showBox('karma_explained');" class='link'><?=$this->userauth->user_karma;?></span><img src="images/karma_star_default.png" style='top:4px;'>)</li>
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
                    <a href="#" class="left-banner"><img src="images/blank.gif" alt="" /></a>
                    <img src="images/logo.gif" alt="" class="logo" />
                    <a href="#" class="right-banner"><img src="images/blank.gif" alt="" /></a>
                </div>
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
        
            <div class="content">
                <div class="col-left">
                    
					<h1></h1>
                    <!--
					<h1>MY GOVERNMENT</h1>
                    <h2>STATE</h2>
                    <a href="#">Governor</a>
                    
                    <h2>FEDERAL</h2>
                    <a href="#">President</a>
                    <a href="#">Vice President</a>
					-->
                </div>
                
                <div class="col-center">
                    <div class="blog">
                        <h1>THE RUNPOLITICS BLOG</h1>
                        <h2>WHY DON'T AMERICANS VOTE?</h2>
                        <img src="images/vote.jpg" alt="" />
                        
                        <div class="blog-left"> 
                            <h3>What has happened to democracy in America?</h3>
                            <p>EVERYWHERE, U.S.A. - Who truly holds the power - the government or the people? What can be done about the disillusionment and frustration YOU feel when faced with U.S. politics?</p>
                            <p>These are some of the questions RunPolitics.com was created to address.</p>
                        </div>
                        
                        <div class="blog-right">
                            <p class="first">At RunPolitics.com, you don?t have to spend $1000 a plate to sit at the table with your elected official.</p>
                            <p>You don't have to spend hours upon hours sifting through mounds of biased data to find the facts. You are given a face, a voice, and a megaphone.</p>
                            <p>We're more than a library, more than a search engine, more than a social gathering place. Politic 2.0 is not just a website; it's a place where you finally are as powerful as the people who represent you... the way it should be.</p>
                            <p>Welcome to RunPolitics.com &mdash; Join the party.</p>
                        </div>
                    </div>
                    
                    <div class="news">
                        <h1>BREAKING NEWS</h1>
                        <div id="feed"></div>
                    </div>
                </div>
                
                <div class="col-right">
                    <h1>VIDEOS</h1>
                    
                    <div class="video">
                        <div class="box" id="videos">

						<!-- ++Begin Video Search Control Wizard Generated Code++ -->
						  <!--
						  // Created with a Google AJAX Search Wizard
						  // http://code.google.com/apis/ajaxsearch/wizards.html
						  -->
						
						  <!--
						  // The Following div element will end up holding the Video Search Control.
						  // You can place this anywhere on your page.
						  -->
						  <div id="videoControl">
						    <span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
						  </div>
						
						  <!-- Ajax Search Api and Stylesheet
						  // Note: If you are already using the AJAX Search API, then do not include it
						  //       or its stylesheet again
						  //
						  // The Key Embedded in the following script tag is designed to work with
						  // the following site:
						  // http://politic20.com
						  -->
						  <script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-vsw&key=ABQIAAAAkKcqFPODFw9EgKwKbb0vmxQMMgp4bRk8oDwCMuUVC3eAkH6yhxRey5JriXQU4hISBErCZHOSAAHL4w"
						    type="text/javascript"></script>
						  <style type="text/css">
						    @import url("http://www.google.com/uds/css/gsearch.css");
						  </style>
						
						  <!-- Video Search Control and Stylesheet -->
						  <script type="text/javascript">
						    window._uds_vsw_donotrepair = true;
						  </script>
						  <script src="http://www.google.com/uds/solutions/videosearch/gsvideosearch.js?mode=new"
						    type="text/javascript"></script>
						  <style media="all" type="text/css">@import "css/googleVideo.css";</style>
						
						  <script type="text/javascript">
						    function LoadVideoSearchControl() {
						      var options = { twoRowMode : true };
						      //var options = { largeResultSet : true };
						      var videoSearch = new GSvideoSearchControl(
						                              document.getElementById("videoControl"),
						                              [{ query : "Republican"}, { query : "Democrat"}, { query : "Conservative"}, { query : "Liberal"}, { query : "Presidential Campaign"}, { query : "Breaking Political News"}, { query : "U.S. Senate"}, { query : "U.S. House"}, { query : "Bush Administration"}, { query : "Supreme Court"}, { query : "Local & State Government"}], null, null, options);
						    }
						    // arrange for this function to be called during body.onload
						    // event processing
						    GSearch.setOnLoadCallback(LoadVideoSearchControl);
						  </script>
						
						<!-- --End Video Search Control Wizard Generated Code-- -->
						                
							
							
						</div>
                    </div>
                    
                    <div class="post">
                        <h1>BLOG POSTS</h1>
                        
                        <div class="box" id="blog">

						<!-- ++Begin Blog Bar Wizard Generated Code++ -->
						  <!--
						  // Created with a Google AJAX Search Wizard
						  // http://code.google.com/apis/ajaxsearch/wizards.html
						  -->
						
						  <!--
						  // The Following div element will end up holding the actual blogbar.
						  // You can place this anywhere on your page.
						  -->
						  <div id="blogBar-bar">
						    <span style="color:#676767;font-size:11px;margin:10px;padding:4px;">Loading...</span>
						  </div>
						
						  <!-- Ajax Search Api and Stylesheet
						  // Note: If you are already using the AJAX Search API, then do not include it
						  //       or its stylesheet again
						  //
						  // The Key Embedded in the following script tag is designed to work with
						  // the following site:
						  // http://politic20.com
						  -->
						  <script src="http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-blbw&key=ABQIAAAAkKcqFPODFw9EgKwKbb0vmxQMMgp4bRk8oDwCMuUVC3eAkH6yhxRey5JriXQU4hISBErCZHOSAAHL4w"
						    type="text/javascript"></script>
						  <style type="text/css">
						    @import url("http://www.google.com/uds/css/gsearch.css");
						  </style>
						
						  <!-- Blog Bar Code and Stylesheet -->
						  <script src="http://www.google.com/uds/solutions/blogbar/gsblogbar.js?mode=new"
						    type="text/javascript"></script>
						  <style type="text/css">
						    @import "css/googleBar.css";
						  </style>
						
						  <script type="text/javascript">
						    function LoadBlogBar() {
						      var blogBar;
						      var options = {
						        largeResultSet : false,
						        title : " ",
						        horizontal : false,
						        orderBy : GSearch.ORDER_BY_DATE,
						        autoExecuteList : {
						          executeList : [ "Republican", "Democrat", "Conservative", "Liberal", "Presidential Campaign", "Breaking Political News", "U.S. Senate", "U.S. House", "Bush Administration", "Supreme Court", "Local & State Government"]
						        }
						      }
						
						      blogBar = new GSblogBar(document.getElementById("blogBar-bar"), options);
						    }
						    // arrange for this function to be called during body.onload
						    // event processing
						    GSearch.setOnLoadCallback(LoadBlogBar);
						  </script>
						<!-- ++End Blog Bar Wizard Generated Code++ -->
							
							
						</div>
                        
                    </div>
                </div>
            </div>
            
            <div class="footer">Copyright &copy; 2007 RunPolitics.com. All Rights Reserved. Reproduction in whole<br />or part in any form or medium without express written permission is strictly prohibited.</div>
        </div></div></div></div></div>
    </div>
</body>
</html>