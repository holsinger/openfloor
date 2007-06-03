<?php $this->config_load("/libs/lang.conf", null, null); ?>
														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
																				<div id="comments">

<h2 style="margin:0px;border:none;"><?php echo $this->_vars['page_header']; ?>
</h2>

<?php echo tpl_function_checkActionsTpl(array('location' => "tpl_user_center_just_below_header"), $this);?>

<?php if ($this->_vars['user_view'] == 'history'): ?>
<div id="cab" style="margin:0px">
	<ul class="postin">
			<li><img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/rss.png" border="0" alt="" /><a href="<?php echo $this->_vars['user_rss']."all"; ?>
">RSS</a></li>
	    <li><a href="<?php echo $this->_vars['user_url_personal_data']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_sent']; ?>
" class="navbut4"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsSent']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_published']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_unpublished']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsUnPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_commented']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsCommented']; ?>
</span></a></li>
			<li><a href="<?php echo $this->_vars['user_url_news_voted']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsVoted']; ?>
</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;"></div>
<?php endif; ?>

<?php if ($this->_vars['user_view'] == 'published'): ?>
<div id="cab" style="margin:0px">
	<ul class="postin">
			<li><img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/rss.png" border="0" alt="" /><a href="<?php echo $this->_vars['user_rss']."published"; ?>
">RSS</a></li>
	    <li><a href="<?php echo $this->_vars['user_url_personal_data']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_sent']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsSent']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_published']; ?>
" class="navbut4"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_unpublished']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsUnPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_commented']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsCommented']; ?>
</span></a></li>
			<li><a href="<?php echo $this->_vars['user_url_news_voted']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsVoted']; ?>
</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;"></div>
<?php endif; ?>

<?php if ($this->_vars['user_view'] == 'shaken'): ?>
<div id="cab" style="margin:0px">
	<ul class="postin">
			<li><img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/rss.png" border="0" alt="" /><a href="<?php echo $this->_vars['user_rss']."queued"; ?>
">RSS</a></li>
	    <li><a href="<?php echo $this->_vars['user_url_personal_data']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_sent']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsSent']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_published']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_unpublished']; ?>
" class="navbut4"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsUnPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_commented']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsCommented']; ?>
</span></a></li>
		<li><a href="<?php echo $this->_vars['user_url_news_voted']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsVoted']; ?>
</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;"></div>
<?php endif; ?>

<?php if ($this->_vars['user_view'] == 'commented'): ?>
<div id="cab" style="margin:0px">
	<ul class="postin">
			<li><img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/rss.png" border="0" alt="" /><a href="<?php echo $this->_vars['user_rss']."commented"; ?>
">RSS</a></li>
	    <li><a href="<?php echo $this->_vars['user_url_personal_data']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_sent']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsSent']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_published']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_unpublished']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsUnPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_commented']; ?>
" class="navbut4"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsCommented']; ?>
</span></a></li>
		<li><a href="<?php echo $this->_vars['user_url_news_voted']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsVoted']; ?>
</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;"></div>
<?php endif; ?>

<?php if ($this->_vars['user_view'] == 'voted'): ?>
<div id="cab" style="margin:0px">
	<ul class="postin">
			<li><img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/rss.png" border="0" alt="" /><a href="<?php echo $this->_vars['user_rss']."voted"; ?>
" >RSS</a></li>
	    <li><a href="<?php echo $this->_vars['user_url_personal_data']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_sent']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsSent']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_published']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_unpublished']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsUnPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_commented']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsCommented']; ?>
</span></a></li>
		<li><a href="<?php echo $this->_vars['user_url_news_voted']; ?>
" class="navbut4"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsVoted']; ?>
</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;"></div>
<?php endif; ?>

<?php if ($this->_vars['user_view'] == 'viewfriends'): ?>
<?php if ($this->_vars['UseAvatars'] != "0"): ?><span id="ls_avatar-<?php echo $this->_vars['link_shakebox_index']; ?>
"><img src="<?php echo $this->_vars['Avatar_ImgSrc']; ?>
" alt="" /></span><?php endif; ?>
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="<?php echo $this->_vars['user_url_personal_data']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_sent']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsSent']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_published']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_unpublished']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsUnPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_commented']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsCommented']; ?>
</span></a></li>
			<li><a href="<?php echo $this->_vars['user_url_news_voted']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsVoted']; ?>
</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;">
	<?php if ($this->_vars['Allow_Friends'] != "0"): ?>

	<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/rss.png" alt="" /> 
	<a href="<?php echo $this->_vars['user_rss']."published"; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_RSS']; ?>
 <?php echo $this->_vars['user_login']; ?>
's <?php echo $this->_confs['PLIGG_Visual_User_Profile_View_RSS_2']; ?>
</a><br />
	
	<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/friends2.png" alt="" /> 
	<a href="<?php echo $this->_vars['user_url_friends2']; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_Friends_2']; ?>
</a> 
	
	<?php endif; ?>
</div>
<?php endif; ?>

<?php if ($this->_vars['user_view'] == 'viewfriends2'): ?>
<?php if ($this->_vars['UseAvatars'] != "0"): ?><span id="ls_avatar-<?php echo $this->_vars['link_shakebox_index']; ?>
"><img src="<?php echo $this->_vars['Avatar_ImgSrc']; ?>
" style="float:left" alt="" /></span><?php endif; ?>
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="<?php echo $this->_vars['user_url_personal_data']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_sent']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsSent']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_published']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_unpublished']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsUnPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_commented']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsCommented']; ?>
</span></a></li>
		<li><a href="<?php echo $this->_vars['user_url_news_voted']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsVoted']; ?>
</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;">
	<?php if ($this->_vars['Allow_Friends'] != "0"): ?>
	
	<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/rss.png" alt="" />
	<a href="<?php echo $this->_vars['user_rss']."published"; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_RSS']; ?>
 <?php echo $this->_vars['user_login']; ?>
's <?php echo $this->_confs['PLIGG_Visual_User_Profile_View_RSS_2']; ?>
</a><br /> 	
	
	<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/friends.png" alt="" />
	<a href="<?php echo $this->_vars['user_url_friends']; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_Friends']; ?>
</a>
	
	<?php endif; ?>
</div>
<?php endif; ?>

<?php if ($this->_vars['user_view'] == 'removefriend'): ?>
<?php if ($this->_vars['UseAvatars'] != "0"): ?><span id="ls_avatar-<?php echo $this->_vars['link_shakebox_index']; ?>
"><img src="<?php echo $this->_vars['Avatar_ImgSrc']; ?>
" style="float:left" alt="" /></span><?php endif; ?>
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="<?php echo $this->_vars['user_url_personal_data']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_sent']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsSent']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_published']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_unpublished']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsUnPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_commented']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsCommented']; ?>
</span></a></li>
		<li><a href="<?php echo $this->_vars['user_url_news_voted']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsVoted']; ?>
</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;">
	<?php if ($this->_vars['Allow_Friends'] != "0"): ?>	
		
		<?php if ($this->_vars['user_login'] != $this->_vars['user_logged_in']): ?>  
		<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/friends.png" alt="" />
		<a href="<?php echo $this->_vars['user_url_friends']; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_Friends']; ?>
</a><br />
		<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/friends2.png" alt="" />
		<a href="<?php echo $this->_vars['user_url_friends2']; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_Friends_2']; ?>
</a>
  
		<?php endif; ?>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php if ($this->_vars['user_view'] == 'addfriend'): ?>
<?php if ($this->_vars['UseAvatars'] != "0"): ?><span id="ls_avatar-<?php echo $this->_vars['link_shakebox_index']; ?>
"><img src="<?php echo $this->_vars['Avatar_ImgSrc']; ?>
" style="float:left" alt="" /></span><?php endif; ?>
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="<?php echo $this->_vars['user_url_personal_data']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_sent']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsSent']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_published']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_unpublished']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsUnPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_commented']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsCommented']; ?>
</span></a></li>
		<li><a href="<?php echo $this->_vars['user_url_news_voted']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsVoted']; ?>
</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;">
	<?php if ($this->_vars['Allow_Friends'] != "0"): ?>
	
	<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/rss.png" alt="" />
	<a href="<?php echo $this->_vars['user_rss']."published"; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_RSS']; ?>
 <?php echo $this->_vars['user_login']; ?>
's <?php echo $this->_confs['PLIGG_Visual_User_Profile_View_RSS_2']; ?>
</a><br />
	<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/friends.png" alt="" />
	<a href="<?php echo $this->_vars['user_url_friends']; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_Friends']; ?>
</a><br />
	<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/friends2.png" alt="" />
	<a href="<?php echo $this->_vars['user_url_friends2']; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_Friends_2']; ?>
</a>   
	
	<?php endif; ?>
</div>
<?php endif; ?>

<?php if ($this->_vars['user_view'] == 'profile'): ?>
<?php if ($this->_vars['UseAvatars'] != "0"): ?><span id="ls_avatar-<?php echo $this->_vars['link_shakebox_index']; ?>
"><img src="<?php echo $this->_vars['Avatar_ImgSrc']; ?>
" style="float:left"/></span><?php endif; ?>
<div id="cab" style="margin:0px">
	<ul class="postin">
	    <li><a href="<?php echo $this->_vars['user_url_personal_data']; ?>
" class="navbut4"><span><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_sent']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsSent']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_published']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_news_unpublished']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsUnPublished']; ?>
</span></a></li>
	    <li><a href="<?php echo $this->_vars['user_url_commented']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsCommented']; ?>
</span></a></li>
		<li><a href="<?php echo $this->_vars['user_url_news_voted']; ?>
" class="navbut3"><span><?php echo $this->_confs['PLIGG_Visual_User_NewsVoted']; ?>
</span></a></li>
	</ul>
</div>
<div id="navbar" style="margin:0px;">
<?php if ($this->_vars['Allow_Friends'] != "0"): ?>	

			<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/rss.png" alt="" />
			<a href="<?php echo $this->_vars['user_rss']."published"; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_RSS']; ?>
 <?php echo $this->_vars['user_login']; ?>
's <?php echo $this->_confs['PLIGG_Visual_User_Profile_View_RSS_2']; ?>
</a><br />

		<?php if ($this->_vars['user_login'] != $this->_vars['user_logged_in']): ?>

  			<?php if ($this->_vars['is_friend'] > 0): ?>
  
			<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/user_delete.png" alt="" />
			<a href="<?php echo $this->_vars['user_url_remove']; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_Remove_Friend']; ?>
 <?php echo $this->_vars['user_login']; ?>
 <?php echo $this->_confs['PLIGG_Visual_User_Profile_Remove_Friend_2']; ?>
</a><br />

	   			<?php if ($this->_vars['user_authenticated'] == true): ?>

		
				<?php echo tpl_function_checkActionsTpl(array('location' => "tpl_user_center"), $this);?>

				<?php endif; ?>
 			
			<?php else: ?>
  				
   				<?php if ($this->_vars['user_authenticated'] == true): ?>

				<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/user_add.png" alt=""/>
				<a href="<?php echo $this->_vars['user_url_add']; ?>
">	<?php echo $this->_confs['PLIGG_Visual_User_Profile_Add_Friend']; ?>
 <?php echo $this->_vars['user_login']; ?>
 <?php echo $this->_confs['PLIGG_Visual_User_Profile_Add_Friend_2']; ?>
</a><br />

			    <?php endif; ?>   
   
			<?php endif; ?>   
   		
		<?php else: ?> 
		<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/friends.png" alt="" />
		<a href="<?php echo $this->_vars['user_url_friends']; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_Friends']; ?>
</a><br />
		<img src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/<?php echo $this->_vars['the_template']; ?>
/images/friends2.png" alt="" />
		<a href="<?php echo $this->_vars['user_url_friends2']; ?>
"><?php echo $this->_confs['PLIGG_Visual_User_Profile_View_Friends_2']; ?>
</a> 
  
		<?php endif; ?> 
	<?php endif; ?>
</div>
	
<br />

<div id="wrapper">
	<div id="personal_info">
		<fieldset><legend><?php echo $this->_confs['PLIGG_Visual_User_PersonalData']; ?>
</legend>
			<table style="border:none">
			<tr>
			<td style="background:none"><strong><?php echo $this->_confs['PLIGG_Visual_Login_Username']; ?>
:</strong></td>
			<td style="background:none"><?php if ($this->_vars['UseAvatars'] != "0"): ?><span id="ls_avatar-<?php echo $this->_vars['link_shakebox_index']; ?>
"><img src="<?php echo $this->_vars['Avatar_ImgSrc']; ?>
" alt="Avatar" align="absmiddle"/></span><?php endif; ?> <?php echo $this->_vars['user_username']; ?>
</td>
			</tr>
			
			<?php if ($this->_vars['user_names'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_User']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_names']; ?>
</td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_url'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_Homepage']; ?>
:</strong></td>
			<td><a href="<?php echo $this->_vars['user_url']; ?>
" target="_blank"><?php echo $this->_vars['user_url']; ?>
</a></td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_publicemail'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_PublicEmail']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_publicemail']; ?>
</td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_location'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_Profile_Location']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_location']; ?>
</td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_occupation'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_Profile_Occupation']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_occupation']; ?>
</td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_aim'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_AIM']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_aim']; ?>
</td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_msn'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_MSN']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_msn']; ?>
</td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_yahoo'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_Yahoo']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_yahoo']; ?>
</td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_gtalk'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_GTalk']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_gtalk']; ?>
</td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_skype'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_Skype']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_skype']; ?>
</td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_irc'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_IRC']; ?>
:</strong></td>
			<td><a href="<?php echo $this->_vars['user_irc']; ?>
" target="_blank"><?php echo $this->_vars['user_irc']; ?>
</a></td>
			</tr>
			<?php endif; ?>

			<?php if ($this->_vars['user_login'] == $this->_vars['user_logged_in']): ?>
			<tr><td><input type="button" value="<?php echo $this->_confs['PLIGG_Visual_User_Profile_Modify']; ?>
" class="log2" onclick="location='<?php echo $this->_vars['URL_Profile']; ?>
'" /></td></tr>
			<?php endif; ?>
			</table>
		</fieldset>
	</div>

	<div id="stats">
		<fieldset><legend><?php echo $this->_confs['PLIGG_Visual_User_Profile_User_Stats']; ?>
</legend>
			<table style="border:none;">
			<tr>
			<td style="background:none"><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_Joined']; ?>
:</strong></td>
			<td style="background:none"><?php echo $this->_vars['user_joined']; ?>
</td>
			</tr>

			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_Total_Links']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_total_links']; ?>
</td>
			</tr>

			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_Published_Links']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_published_links']; ?>
</td>
			</tr>

			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_Total_Comments']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_total_comments']; ?>
</td>
			</tr>

			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_Total_Votes']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_total_votes']; ?>
</td>
			</tr>

			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_Published_Votes']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_published_votes']; ?>
</td>
			</tr>

			<?php if ($this->_vars['user_karma'] != ""): ?>
			<tr>
			<td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_KarmaPoints']; ?>
:</strong></td>
			<td><?php echo $this->_vars['user_karma']; ?>
</td>
			</tr>
			<?php endif; ?>

			<tr><td><strong><?php echo $this->_confs['PLIGG_Visual_User_Profile_Last_5_Title']; ?>
:</strong></td></tr>
				<?php if (isset($this->_sections['customer'])) unset($this->_sections['customer']);
$this->_sections['customer']['name'] = 'customer';
$this->_sections['customer']['loop'] = is_array($this->_vars['last_viewers_names']) ? count($this->_vars['last_viewers_names']) : max(0, (int)$this->_vars['last_viewers_names']);
$this->_sections['customer']['show'] = true;
$this->_sections['customer']['max'] = $this->_sections['customer']['loop'];
$this->_sections['customer']['step'] = 1;
$this->_sections['customer']['start'] = $this->_sections['customer']['step'] > 0 ? 0 : $this->_sections['customer']['loop']-1;
if ($this->_sections['customer']['show']) {
	$this->_sections['customer']['total'] = $this->_sections['customer']['loop'];
	if ($this->_sections['customer']['total'] == 0)
		$this->_sections['customer']['show'] = false;
} else
	$this->_sections['customer']['total'] = 0;
if ($this->_sections['customer']['show']):

		for ($this->_sections['customer']['index'] = $this->_sections['customer']['start'], $this->_sections['customer']['iteration'] = 1;
			 $this->_sections['customer']['iteration'] <= $this->_sections['customer']['total'];
			 $this->_sections['customer']['index'] += $this->_sections['customer']['step'], $this->_sections['customer']['iteration']++):
$this->_sections['customer']['rownum'] = $this->_sections['customer']['iteration'];
$this->_sections['customer']['index_prev'] = $this->_sections['customer']['index'] - $this->_sections['customer']['step'];
$this->_sections['customer']['index_next'] = $this->_sections['customer']['index'] + $this->_sections['customer']['step'];
$this->_sections['customer']['first']	  = ($this->_sections['customer']['iteration'] == 1);
$this->_sections['customer']['last']	   = ($this->_sections['customer']['iteration'] == $this->_sections['customer']['total']);
?>
				<tr><td><img src="<?php echo $this->_vars['last_viewers_avatar'][$this->_sections['customer']['index']]; ?>
" align="absmiddle"> <a href = "<?php echo $this->_vars['last_viewers_profile'][$this->_sections['customer']['index']]; ?>
"><?php echo $this->_vars['last_viewers_names'][$this->_sections['customer']['index']]; ?>
</a></td></tr>
				<?php endfor; endif; ?>		 
			</table>
		</fieldset>
	</div>

	<?php if ($this->_vars['user_login'] == $this->_vars['user_logged_in']): ?>
	<hr />
	<div id="bookmarklet">
		<fieldset><legend><?php echo $this->_confs['PLIGG_Visual_User_Profile_Bookmarklet_Title']; ?>
</legend>
			<br /><?php echo $this->_confs['PLIGG_Visual_User_Profile_Bookmarklet_Title_1']; ?>
 <?php echo $this->_confs['PLIGG_Visual_Name']; ?>
.<?php echo $this->_confs['PLIGG_Visual_User_Profile_Bookmarklet_Title_2']; ?>
<br />
			<br /><b><?php echo $this->_confs['PLIGG_Visual_User_Profile_IE']; ?>
:</b> <?php echo $this->_confs['PLIGG_Visual_User_Profile_IE_1']; ?>

			<br /><b><?php echo $this->_confs['PLIGG_Visual_User_Profile_Firefox']; ?>
:</b> <?php echo $this->_confs['PLIGG_Visual_User_Profile_Firefox_1']; ?>

			<br /><b><?php echo $this->_confs['PLIGG_Visual_User_Profile_Opera']; ?>
:</b> <?php echo $this->_confs['PLIGG_Visual_User_Profile_Opera_1']; ?>

			<br /><br /><b><?php echo $this->_confs['PLIGG_Visual_User_Profile_The_Bookmarklet']; ?>
: <a href="javascript:q=(document.location.href);void(open('<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
/submit.php?url='+escape(q),'','resizable,location,menubar,toolbar,scrollbars,status'));"><?php echo $this->_confs['PLIGG_Visual_Name']; ?>
</a></b>
		</fieldset>
	</div>
<?php endif; ?>
</div>
<?php endif; ?>

<?php 
Global $db, $main_smarty, $view, $user, $rows, $page_size, $offset;
switch ($view) {
	case 'history':
		do_history();
 ?>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
<?php 														
		do_pages($rows, $page_size, $the_page);		
		break;
	case 'published':
		do_published();
 ?>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
<?php 			
		do_pages($rows, $page_size, $the_page); 
		break;
	case 'shaken':
		do_shaken();
 ?>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
<?php 			
		do_pages($rows, $page_size, $the_page);
		break;	
	case 'commented':
        do_commented();
 ?>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
<?php 			
	    do_pages($rows, $page_size, $the_page);
      	break;
	case 'voted':
        do_voted();
 ?>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
<?php 			
	    do_pages($rows, $page_size, $the_page);
      	break;	
	case 'profile':
		default:
 ?>
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
<?php 
		break;	
	case 'removefriend':
		do_removefriend();
		break;
	case 'addfriend':
		do_addfriend();
		break;
	case 'viewfriends':
		do_viewfriends();
		break;
	case 'viewfriends2':
		do_viewfriends2();
		break;
	case 'sendmessage':
		do_sendmessage();
		break;
}
 ?>
