<!-- menu -->
	 <div id="menu">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('leftsidebar') ) : ?>
			<ul><li><a href="<?php echo get_option('home'); ?>">Home</a></li></ul>
			<h4>Pages</h4>
			<ul><?php wp_list_pages('title_li='); ?></ul>
			<h4>Categories</h4>
			<ul>
				<?php wp_list_categories('title_li='); ?>
			</ul>
			<br />
			<?php if(get_bloginfo('description') != ""){ ?>
		      <h4><?php bloginfo('name'); ?></h4>
			  <p><?php bloginfo('description'); ?></p>
			<br />
			<? } ?>
			<p><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication"><img src="http://www.feedburner.com/fb/images/pub/feed-icon16x16.png"></abbr>'); ?></a>
			</p>
		    <div id="sidebarSearch">
						<div class="BlogSearch">
							<form id="searchform" method="get" action="preview.php">
							<h4>Quick search:</h4>
							<input type="text" name="s" id="s" value="" size="12" /><input type="submit" id="searchsubmit" name="search" value="Search" />
		
							</form>
						</div>
			</div>
			<h4>Archives</h4>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
			<h4>Links</h4>
			<ul>
			<?php wp_list_bookmarks('title_li=0&categorize=0'); ?>
			</ul>
			<?php } ?>
	<?php endif; ?>
	</div>