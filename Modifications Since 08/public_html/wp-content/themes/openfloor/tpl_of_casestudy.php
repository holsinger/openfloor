<?php
/*
Template Name: Case Study OpenFloor
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div class="subBodyText">
		<?php the_post(); ?>	
	    <h1><?php the_title();?></h1>
	
		<div><?php the_content();?></div>
	    <?php edit_post_link('Edit'); ?>
	
	</div>

</div><!-- must have if using sidebar -->
<?php get_footer(); ?>