<?php
/*
Template Name: Product DQQ OpenFloor
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div class="subBodyText">
		<?php the_post(); ?>	
	    <h1>OpenFloor Dynamic Question Queue</h1>
		<img src="<?php bloginfo('template_directory'); ?>/images/product_top_of.png" alt="" title="OpenFloor Dynamic Question Queue" alt="OpenFloor Dynamic Question Queue" />
		<br/><br/>
		<p><?= get_post_meta($post->ID, 'product_excerpt', true); ?></p>
		
		<div class="clientlist"> 
	    	<?php the_content();?>
		</div>
		<div style="clear:both;">

	      <!--#end-->
	    </div>
	</div>

</div><!-- must have if using sidebar -->
<?php get_footer(); ?>