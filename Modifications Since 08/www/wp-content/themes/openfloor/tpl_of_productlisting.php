<?php
/*
Template Name: Product Listing OpenFloor
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div class="subBodyText">
		<?php the_post(); ?>	
	    <h1><?php the_title();?></h1>
		<h6><?php the_content();?></h6>
	    <?php edit_post_link('Edit', '(', ')'); ?>
	
		<?php
		$pageChildren = $wpdb->get_results("
			SELECT *
			FROM $wpdb->posts
			WHERE post_parent = ".$post->ID."
			AND post_type = 'page'
			ORDER BY menu_order
		", 'OBJECT');

		if ( $pageChildren ) :
			foreach ( $pageChildren as $pageChild ) :
				setup_postdata( $pageChild );
				?>
			
				<?php $image = get_post_meta($pageChild->ID, 'product_image', true); ?>
				<?php $excerpt = get_post_meta($pageChild->ID, 'product_excerpt', true); ?>
			<div class="listings">
		      <a href="<?= get_permalink( $pageChild->ID );?>"><h3><?=get_the_title( $pageChild->ID );?>&#153</h3></a>
		      <p><a href="<?= get_permalink( $pageChild->ID );?>"><img src="<?php bloginfo('template_directory'); ?>/images/<?=$image;?>" alt="" class="alignleft"  /></a> <?=$excerpt;?><a href="<?= get_permalink( $pageChild->ID );?>">Learn More</a></p>
		    </div>
		
			<?php
			endforeach;
		endif;
		?>

	
	<?/*	<div class="listings">
	      <a href="<?= get_permalink(7);?>"><h3>OpenFloor&#153;</h3></a>
	      <p><a href="<?= get_permalink(7);?>"><img src="<?php bloginfo('template_directory'); ?>/images/of_listing.jpg" alt="" class="alignleft"  /></a> <?=$of_desc;?>&nbsp;&nbsp;<a href="<?= get_permalink(7);?>">Learn More</a></p>
	    </div>
	    <!--listings end-->
		<div class="listings">
	      <a href="<?= get_permalink(8);?>"><h3>OpenDebate&#153;</h3></a>
	      <p><a href="<?= get_permalink(8);?>"><img src="<?php bloginfo('template_directory'); ?>/images/od_listing.jpg" alt="" class="alignleft"  /></a><?=$od_desc;?>&nbsp;&nbsp;<a href="<?= get_permalink(8);?>">Learn More</a></p>
	    </div>
	    <!--listings end-->
	*/?>
	</div>

</div><!-- must have if using sidebar -->
<?php get_footer(); ?>