<?php require_once('C:\php5\htdocs\p20\plugins\modifier.sanitize.php'); $this->register_modifier("sanitize", "tpl_modifier_sanitize"); ?>	<div id="page">
		<!-- header start here -->
		<div id="header">
			<h1><a href="<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
">Politic20</a></h1>
			<form action="<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
">
				<div>
					<input type="text" class="txt" />
					<input type="image" src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/Politic20/images/btn-search.gif" alt="search" />
				</div>
			</form>
		</div>
		<!-- top navigation start here -->
		<ul class="top-nav">
			<li><span><a href="#">Home</a></span></li>
			<li><a href="#">Events</a></li>
			<li><a href="#">ConventionNext</a></li>
		</ul>
		<div class="slogan"><strong class="slogan">populace politic change</strong></div>
		<div id="pagewidth">
			<div class="frame">
				<div class="top">
					<!-- main navigation start here -->
					<ul class="nav">
					<?php if ($this->_vars['user_authenticated'] == true): ?>
						<?php if ($this->_vars['isadmin'] == 1): ?><li><a href="<?php echo $this->_vars['URL_admin']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Header_AdminPanel']; ?>
</a></li><?php endif; ?>
						<li><a href="<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
">ConventionNext Home</a></li>
						<li><a href="<?php echo $this->_vars['URL_userNoVar']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Profile']; ?>
</a></li>
						<?php if ($this->_vars['user_authenticated'] != true): ?><li><a href="<?php echo $this->_vars['my_pligg_base']; ?>
/register.php"><?php echo $this->_confs['PLIGG_Visual_Register']; ?>
</a></li><?php endif; ?>
						<?php if ($this->_vars['Enable_Live'] == 'false'): ?><li><a href='#'><?php echo $this->_confs['PLIGG_Visual_Live']; ?>
</a></li><?php endif; ?>
						<li><a href='<?php echo $this->_vars['URL_topusers']; ?>
'><?php echo $this->_confs['PLIGG_Visual_Top_Users']; ?>
</a></li>
						<?php if ($this->_vars['Enable_Tags'] == 'true'): ?><li><a href="<?php echo $this->_vars['URL_tagcloud']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Tags']; ?>
</a></li><?php endif; ?>
						<?php if ($this->_vars['user_authenticated'] == true): ?><li class="last"><a href="<?php echo $this->_vars['URL_logout']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Logout']; ?>
</a></li><?php endif; ?>
					<?php else: ?>
						<li><a href="<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
">ConventionNext Home</a></li>
						<li><a href='<?php echo $this->_vars['URL_login']; ?>
'><?php echo $this->_confs['PLIGG_Visual_Login_Title']; ?>
</a></li>
						<?php if ($this->_vars['user_authenticated'] != true): ?><li><a href="<?php echo $this->_vars['my_pligg_base']; ?>
/register.php"><?php echo $this->_confs['PLIGG_Visual_Register']; ?>
</a></li><?php endif; ?>
						<?php if ($this->_vars['Enable_Live'] == 'false'): ?><li><a href='#'> <?php echo $this->_confs['PLIGG_Visual_Live']; ?>
</a></li><?php endif; ?>
						<li><a href='<?php echo $this->_vars['URL_topusers']; ?>
'><?php echo $this->_confs['PLIGG_Visual_Top_Users']; ?>
</a></li>
						<li class="last"><?php if ($this->_vars['Enable_Tags'] == 'true'): ?><a href="<?php echo $this->_vars['URL_tagcloud']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Tags']; ?>
</a><?php endif; ?></li>
					<?php endif; ?>
					</ul>
					<strong class="convention-next">Convention next</strong>
					<ul class="breadcrumb">
						<li><a href = "<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Breadcrumb_SiteName'];  echo $this->_confs['PLIGG_Visual_Breadcrumb_Home']; ?>
</a></li>
						<li><?php if ($this->_vars['navbar_where']['link1'] != ""): ?>&gt; <a href="<?php echo $this->_vars['navbar_where']['link1']; ?>
"><?php echo $this->_vars['navbar_where']['text1']; ?>
</a><?php elseif ($this->_vars['navbar_where']['text1'] != ""): ?>&gt; <?php echo $this->_vars['navbar_where']['text1'];  endif; ?></li>
						<li><?php if ($this->_vars['navbar_where']['link2'] != ""): ?>&gt; <a href="<?php echo $this->_vars['navbar_where']['link2']; ?>
"><?php echo $this->_vars['navbar_where']['text2']; ?>
</a><?php elseif ($this->_vars['navbar_where']['text2'] != ""): ?>&gt; <?php echo $this->_vars['navbar_where']['text2'];  endif; ?></li>   	
						<li><?php if ($this->_vars['navbar_where']['link3'] != ""): ?>&gt; <a href="<?php echo $this->_vars['navbar_where']['link3']; ?>
"><?php echo $this->_vars['navbar_where']['text3']; ?>
</a><?php elseif ($this->_vars['navbar_where']['text3'] != ""): ?>&gt; <?php echo $this->_vars['navbar_where']['text3'];  endif; ?></li>      	
						<li><?php if ($this->_vars['navbar_where']['link4'] != ""): ?>&gt; <a href="<?php echo $this->_vars['navbar_where']['link4']; ?>
"><?php echo $this->_vars['navbar_where']['text4']; ?>
</a><?php elseif ($this->_vars['navbar_where']['text4'] != ""): ?>&gt; <?php echo $this->_vars['navbar_where']['text4'];  endif; ?></li>
					</ul>
				</div>
				<!-- search box start here -->
				<div class="search">			
					<form action="<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
/search.php" method="get" id="thisform">
						<ul>
							<li><label>Search</label></li>
							<?php if ($_GET['search'] != ""): ?>
								<?php $this->assign('searchboxtext', $this->_run_modifier($_GET['search'], 'sanitize', 1, 2)); ?>
							<?php else: ?>
								<?php $this->assign('searchboxtext', ""); ?>			
							<?php endif; ?>
							<li><input type="text" class="txt" name="search" id="searchsite"  value="<?php echo $this->_vars['searchboxtext']; ?>
" /></li>
							<li><input type="image" src="<?php echo $this->_vars['my_pligg_base']; ?>
/templates/Politic20/images/btn-go.gif" alt="go" /></li>
						</ul>
					</form>
				</div>
				<div id="content">
					<div class="c-frame">
						<div class="c-bl">
							<div class="c-br">
								<div class="ct-l">
									<div class="c-tr">
										<div class="bg2">
											<div class="bg3">
												<div class="bg">
													<div class="top-box">
														<strong class="questions">Questions</strong>
														<!-- local (sub) navigation start here -->
														<ul class="local-nav">
														<?php if ($this->_vars['pagename'] == "upcoming"): ?>
																<li><a href="<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
" class="published-questions"><?php echo $this->_confs['PLIGG_Visual_Published_News']; ?>
</a></li>
																<li class="active"><a href="<?php echo $this->_vars['URL_upcoming']; ?>
" class="unpublished-questions"><?php echo $this->_confs['PLIGG_Visual_Pligg_Queued']; ?>
</a></li>
																<li><a href="<?php echo $this->_vars['URL_submit']; ?>
" class="submit-questions"><?php echo $this->_confs['PLIGG_Visual_Submit_A_New_Story']; ?>
</a></li>
														<?php elseif ($this->_vars['pagename'] == "index"): ?>
																<li class="active"><a href="<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
" class="published-questions"><?php echo $this->_confs['PLIGG_Visual_Published_News']; ?>
</a></li>
																<li><a href="<?php echo $this->_vars['URL_upcoming']; ?>
" class="unpublished-questions"><?php echo $this->_confs['PLIGG_Visual_Pligg_Queued']; ?>
</a></li>
																<li><a href="<?php echo $this->_vars['URL_submit']; ?>
" class="submit-questions"><?php echo $this->_confs['PLIGG_Visual_Submit_A_New_Story']; ?>
</a></li>
														<?php elseif ($this->_vars['pagename'] == "submit"): ?>
																<li><a href="<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
" class="published-questions"><?php echo $this->_confs['PLIGG_Visual_Published_News']; ?>
</a></li>
																<li><a href="<?php echo $this->_vars['URL_upcoming']; ?>
" class="unpublished-questions"><?php echo $this->_confs['PLIGG_Visual_Pligg_Queued']; ?>
</a></li>
																<li class="active"><a href="<?php echo $this->_vars['URL_submit']; ?>
" class="submit-questions"><?php echo $this->_confs['PLIGG_Visual_Submit_A_New_Story']; ?>
</a></li>
														<?php else: ?>
																<li><a href="<?php echo $this->_vars['my_base_url'];  echo $this->_vars['my_pligg_base']; ?>
" class="published-questions"><?php echo $this->_confs['PLIGG_Visual_Published_News']; ?>
</a></li>
																<li><a href="<?php echo $this->_vars['URL_upcoming']; ?>
" class="unpublished-questions"><?php echo $this->_confs['PLIGG_Visual_Pligg_Queued']; ?>
</a></li>
																<li><a href="<?php echo $this->_vars['URL_submit']; ?>
" class="submit-questions"><?php echo $this->_confs['PLIGG_Visual_Submit_A_New_Story']; ?>
</a></li>   
														<?php endif; ?>
														</ul>
														<ul class="sort-questions">
														<?php if ($this->_vars['pagename'] == "upcoming"): ?>
															<li><strong><?php echo $this->_confs['PLIGG_Visual_Pligg_Sort_News_By']; ?>
:</strong></li>
															<li><?php if ($this->_vars['paorder'] == "" || $this->_vars['paorder'] == "newest"):  echo $this->_confs['PLIGG_Visual_Pligg_Newest_St'];  else: ?><a href="<?php echo $this->_vars['upcoming_url_newest']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Pligg_Newest_St']; ?>
</a><?php endif; ?></li>
															<li><?php if ($this->_vars['paorder'] == "oldest"):  echo $this->_confs['PLIGG_Visual_Pligg_Oldest_St'];  else: ?><a href="<?php echo $this->_vars['upcoming_url_oldest']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Pligg_Oldest_St']; ?>
</a><?php endif; ?></li>
															<li><?php if ($this->_vars['paorder'] == "mostpopular"):  echo $this->_confs['PLIGG_Visual_Pligg_Most_Pop'];  else: ?><a href="<?php echo $this->_vars['upcoming_url_mostpopular']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Pligg_Most_Pop']; ?>
</a><?php endif; ?></li>
															<li><?php if ($this->_vars['paorder'] == "leastpopular"):  echo $this->_confs['PLIGG_Visual_Pligg_Least_Pop'];  else: ?><a href="<?php echo $this->_vars['upcoming_url_leastpopular']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Pligg_Least_Pop']; ?>
</a><?php endif; ?></li>
															<li class="rss"><a href="<?php echo $this->_vars['URL_rss2queued']; ?>
">rss</a></li>
														<?php elseif ($this->_vars['pagename'] != "story"): ?>
															<?php if ($this->_vars['Voting_Method'] == 1): ?>
															<li><strong><?php echo $this->_confs['PLIGG_Visual_Pligg_Sort_News_By']; ?>
:</strong></li>
															<li><?php if ($this->_vars['setmeka'] == "" || $this->_vars['setmeka'] == "recent"):  echo $this->_confs['PLIGG_Visual_Recently_Pop'];  else: ?><a href="<?php echo $this->_vars['index_url_recent']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Recently_Pop']; ?>
</a><?php endif; ?></li>
															<li><?php if ($this->_vars['setmeka'] == "today"):  echo $this->_confs['PLIGG_Visual_Top_Today'];  else: ?><a href="<?php echo $this->_vars['index_url_today']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Top_Today']; ?>
</a><?php endif; ?></li>
															<li><?php if ($this->_vars['setmeka'] == "yesterday"):  echo $this->_confs['PLIGG_Visual_Yesterday'];  else: ?><a href="<?php echo $this->_vars['index_url_yesterday']; ?>
"><?php echo $this->_confs['PLIGG_Visual_Yesterday']; ?>
</a><?php endif; ?></li>
															<li><?php if ($this->_vars['setmeka'] == "week"):  echo $this->_confs['PLIGG_Visual_This_Week'];  else: ?><a href="<?php echo $this->_vars['index_url_week']; ?>
"><?php echo $this->_confs['PLIGG_Visual_This_Week']; ?>
</a><?php endif; ?></li>
															<li><?php if ($this->_vars['setmeka'] == "month"):  echo $this->_confs['PLIGG_Visual_This_Month'];  else: ?><a href="<?php echo $this->_vars['index_url_month']; ?>
"><?php echo $this->_confs['PLIGG_Visual_This_Month']; ?>
</a><?php endif; ?></li>
															<?php endif; ?>
															<li class="rss"><a href="<?php echo $this->_vars['URL_rss2']; ?>
">rss</a></li>
														<?php endif; ?>
														</ul>
														<?php if ($this->_vars['pagename'] == "upcoming"): ?>
														<h2><?php echo $this->_confs['PLIGG_Visual_Pligg_Queued']; ?>
 </h2>
														<?php elseif ($this->_vars['pagename'] == "index"): ?>
														<h2><?php echo $this->_confs['PLIGG_Visual_Published_News']; ?>
</h2>
														<?php else: ?>
														<h2>&nbsp;</h2>
														<?php endif; ?>
													</div>