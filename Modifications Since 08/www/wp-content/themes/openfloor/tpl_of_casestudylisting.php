<?php
/*
Template Name: Case Study Listing OpenFloor
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div class="subBodyText">
		<?php the_post(); ?>	
	    <h1><?php the_title();?></h1>
	
		<div><?php the_content();?></div>
	    <?php edit_post_link('Edit'); ?>
	
		<div class="mainlist">
	      <div class="mainlist_twopart alignleft pro-box">
	        <p><a href="#"><h5>Lorme ipsum dolor</h5></a>
	          case study short desc</p>
	      </div>
		<div class="mainlist_twopart alignleft pro-box">
	        <p><a href="#"><h5>Lorme ipsum dolor</h5></a>
	          case study short desc</p>
	      </div>
	    </div>
	    <!--Mainlist end -->
	
	</div>

</div><!-- must have if using sidebar -->
<?php get_footer(); ?>