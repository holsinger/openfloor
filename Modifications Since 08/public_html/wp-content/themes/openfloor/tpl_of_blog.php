<?php
/*
Template Name: Blog OpenFloor
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
	<div class="subBodyText">
    <?php the_post(); ?>	
    <h1><?php the_title();?></h1>
   

		<?php query_posts('cat=-3'); ?>
		<?php while(have_posts()) : the_post(); ?>	

		<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
      	<div class="post-date clearfix"><!-- Posted by <?php the_author(); ?> on <?php the_time('F jS, Y') ?> --></div>

				<?php the_content('Read more...'); ?>
				<?php edit_post_link('Edit', '<p>', '</p>'); ?>
				<!-- <?php trackback_rdf(); ?> -->

		<div class="post-footer cleafix"> 
			<span class="post-cat"><?php the_category(', ') ?></span> 
			<span class="post-comments"><?php comments_popup_link('Post a comment', '1 Comment', '% Comments'); ?></span> 
		</div>

		<?php endwhile; ?>

		<div id="nav-below" class="navigation">
			<div class="nav-previous"><?php next_posts_link('&laquo; Older posts'); ?></div>
			<div class="nav-next"><?php previous_posts_link('Newer posts &raquo;'); ?></div>
		</div>

    

    <br clear="all" />

	</div>
	
</div><!-- must have if using sidebar -->
<?php get_footer(); ?>