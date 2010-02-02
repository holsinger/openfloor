<?php
/*
Template Name: Home Page OpenFloor
*/
?>
<?php get_header(); ?>
<?php the_post(); ?>
<?php $box1 = get_post_meta($post->ID, 'home_box_1', true); ?>
<?php $box2 = get_post_meta($post->ID, 'home_box_2', true); ?>
<?php $box3 = get_post_meta($post->ID, 'home_box_3', true); ?>
<div id="MainHome"><h1><?php the_content();?></h1></div>

<div class="GradBox">
	<div class="homeGrayBox">
		<div id="GrayBoxTop"><img src="<?php bloginfo('template_directory'); ?>/images/homeGrayBoxTop.jpg" style="border: 0px" /></div>
		<div class="boxText"><?=$box1;?></div>
		<div id="homeGrayBoxBottom"><img src="<?php bloginfo('template_directory'); ?>/images/homeGrayBoxBottom.jpg" width="330" height="9" /></div>
	</div><!--homeGrayBox -->			
				
	<div id="GradBoxSpacer"><img src="<?php bloginfo('template_directory'); ?>/images/SpacerClear.gif" width="23" height="232" /></div>
	<div class="homeBlueBox1">
		<div id="homeBlueBox1Top"><img src="<?php bloginfo('template_directory'); ?>/images/homeBlueBox1Top.jpg" width="495" height="9" /></div>
		<div class="boxText"><?=$box2;?></div>
		<div id="homeBlueBox1Bottom"><img src="<?php bloginfo('template_directory'); ?>/images/homeBlueBox1Bottom.jpg" width="495" height="7" /></div>
	</div><!--homeBlueBox1 -->
	
	<div id="blueBoxDivider"><img src="<?php bloginfo('template_directory'); ?>/images/SpacerClear.gif" height="20" /></div>
	
	<div class="homeBlueBox1">
		<div id="homeBlueBox1Top"><img src="<?php bloginfo('template_directory'); ?>/images/homeBlueBox1Top.jpg" width="495" height="9" /></div>
		<div class="boxText"><?=$box3;?></div>
		<div id="homeBlueBox1Bottom"><img src="<?php bloginfo('template_directory'); ?>/images/homeBlueBox1Bottom.jpg" width="495" height="7" /></div>
	</div><!--homeBlueBox1 -->
	
	<?/*
	
	<div id="GradBoxSpacer1"><img src="<?php bloginfo('template_directory'); ?>/images/SpacerClear.gif" width="22" height="1" /></div>
	
	<div class="homeBlueBox2">
		<div id="homeBlueBox2Top"><img src="<?php bloginfo('template_directory'); ?>/images/homeBlueBox2Top.jpg" width="495" height="7" /></div>
		<div class="boxText"><?=$box3;?></div><!--boxText -->
		<div id="homeBlueBox2Bottom"><img src="<?php bloginfo('template_directory'); ?>/images/homeBlueBox2Bottom.jpg" width="495" height="9" /></div>
	</div><!--homeBlueBox2 -->
	*/?>
	
</div><!--GradBox -->
<?php get_footer(); ?>
