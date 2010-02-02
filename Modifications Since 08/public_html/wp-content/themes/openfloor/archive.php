<?php get_header(); ?>
<?php get_sidebar(); ?>

    <div class="subBodyText archive">

		<h1>
		<?php if ( is_day() ) : ?>
		<?php printf(__('Daily Archives: <span>%s</span>'), get_the_time(get_settings('date_format'))) ?>
		
		<?php elseif ( is_month() ) : ?>
		<?php printf(__('Monthly Archives: <span>%s</span>'), get_the_time('F Y')) ?>
		
		<?php elseif ( is_year() ) : ?>
		<?php printf(__('Yearly Archives: <span>%s</span>'), get_the_time('Y')) ?>
		
		<?php elseif ( is_category() ) : ?>
		Category Archives: <?php echo single_cat_title(); ?>
		
		<?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
		Blog Archives
		<?php endif; ?>
		</h1>


		<?php while(have_posts()) : the_post(); ?>	

		<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
      	<div class="post-date clearfix">Posted by <?php the_author(); ?> on <?php the_time('F jS, Y') ?></div>
			<?php edit_post_link('Edit', '<p>', '</p>'); ?>

		<p class="post-footer clearfix"> 
			<span class="post-cat"><?php the_category(', ') ?></span> 
			<span class="post-comments"><?php comments_popup_link('Post a comment', '1 Comment', '% Comments'); ?></span>
		</p>


		<?php endwhile; ?>

		<div id="nav-below" class="navigation">
			<div class="nav-previous"><?php next_posts_link('&laquo; Older posts'); ?></div>
			<div class="nav-next"><?php previous_posts_link('Newer posts &raquo;'); ?></div>
		</div>

		<div id="commented">
			<?php comments_template(); ?>
		</div>

    </div>

    <br clear="all" />


</div><!-- for side bar -->
<?php get_footer(); ?>