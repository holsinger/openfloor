<?php get_header(); ?>
<?php get_sidebar(); ?>

    <div class="subBodyText">

		<?php while(have_posts()) : the_post(); ?>	

		<h1 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>
      	<div class="post-date clearfix">Posted by <?php the_author(); ?> on <?php the_time('F jS, Y') ?></div>

			<?php the_content(); ?>
			<?php wp_link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
			<?php edit_post_link('Edit', '<p>', '</p>'); ?>

		<div class="post-footer cleafix"> 
			<span class="post-cat"><?php the_category(', ') ?></span> 
			<span class="post-comments"><?php comments_popup_link('Post a comment', '1 Comment', '% Comments'); ?></span> 
		</div>

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

</div><!--for sidebar -->

<?php get_footer(); ?>