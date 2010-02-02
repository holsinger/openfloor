

	<div class="subBody">
		<div class="subNav">
			<?php /* Creates a menu for pages beneath the level of the current page - Thanks K2 Theme*/
				if (is_page() and ($notfound != '1')) {
					$current_page = $post->ID;
					while($current_page) {
						$page_query = $wpdb->get_row("SELECT ID, post_title, post_status, post_parent FROM $wpdb->posts WHERE ID = '$current_page'");
						$current_page = $page_query->post_parent;
					}
					$parent_id = $page_query->ID;
					$parent_title = $page_query->post_title;

					if ($wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id' AND post_status != 'attachment'")) { ?>

			<!-- list Sub Pages-->
			
			<a href="<?= get_permalink($parent_id);?>"><h4><?php echo $parent_title; ?></h4></a>
	
		    <ul>
			<?/*
			  <li class="page_item <?=($post->ID==$parent_id)?'current_page_item':'';?>">
			  <a href="<?= get_permalink($parent_id);?>"><?php echo $parent_title; ?></a></l1>
			*/?>
			  <li class="divider"></li>	
		      <?php 
				$navList = wp_list_pages('sort_column=menu_order&title_li=&echo=0&child_of='. $parent_id);
				$string = '</l1><li class="divider"></li>';
				echo str_replace ('</li>',$string,$navList); 
			  ?>
		    </ul>
		    <?php } } ?>
		<?/*	
			<div class="subNavActive" onclick="window.location='subPage.html';"><a href="#">Top News</a></div>
			<div class="divider"><img src="images/subNavDivider.jpg" width="207" height="1" /></div>
			<div class="subNavItem" onmouseover="this.className='subNavActive';" onmouseout="this.className='subNavItem';" onclick="window.location='subPage.html';"><a href="#">Better Performance</a></div>
			<div class="divider"><img src="images/subNavDivider.jpg" width="207" height="1" /></div>
			<div class="subNavItem" onmouseover="this.className='subNavActive';" onmouseout="this.className='subNavItem';" onclick="window.location='subPage.html';"><a href="#">Ten New Animated Themes</a></div>
			<div class="divider"><img src="images/subNavDivider.jpg" width="207" height="1" /></div>
			<div class="subNavItem" onmouseover="this.className='subNavActive';" onmouseout="this.className='subNavItem';" onclick="window.location='subPage.html';"><a href="#">Advanced Menu Customization</a></div>
			<div class="divider"><img src="images/subNavDivider.jpg" width="207" height="1" /></div>
			<div class="subNavItem" onmouseover="this.className='subNavActive';" onmouseout="this.className='subNavItem';" onclick="window.location='subPage.html';"><a href="#">Pre-Quality Encoding</a></div>
			<div class="divider"><img src="images/subNavDivider.jpg" width="207" height="1" /></div>
		*/?>
		<br /><br />
		<?php if (get_post_meta($post->ID, 'sidebar_text', true)) $sidebar_text = get_post_meta($post->ID, 'sidebar_text', true); ?>
		<?php if (get_post_meta($post->ID, 'sidebar_image', true)) $sidebar_image = get_post_meta($post->ID, 'sidebar_image', true); ?>
		<?php if (isset($sidebar_image) && strlen($sidebar_image)>3) { ?>
			<img src="<?php bloginfo('wpurl');?>/wp-content/uploads/<?= $sidebar_image; ?>">
		<? } ?>
		<br/>		
			<div class="sideBlueBox1">
				<div id="homeBlueBox1Top"><img src="<?php bloginfo('template_directory'); ?>/images/homeBlueBox1Top.jpg" width="215" height="9" /></div>
				<div class="boxTextSide">
			<?php if (isset($sidebar_text) && strlen($sidebar_text)>3) { ?>	
				<?= $sidebar_text; ?>
			<? } else {?>
				<img src="<?php bloginfo('template_directory'); ?>/images/specialist.png" class="alignleft">
				<h6>Contact a Solution Specialist to learn more about how OpenFloor Technologies can help your business.  <a href="<?= get_permalink(4);?>">Contact Us Now</a></h6>				
			<? } ?>
				</div>
				<div id="homeBlueBox1Bottom"><img src="<?php bloginfo('template_directory'); ?>/images/homeBlueBox1Bottom.jpg" width="215" height="7" /></div>
			</div>
		
		<?/*<img src="<?php bloginfo('template_directory'); ?>/images/subPic.jpg" width="207" height="304" />*/?>
	</div>	
	
	
  
<?/*
	<!-- list Categories-->
    <h2><?php _e('Categories'); ?></h2>
    <ul>
      <?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
    </ul>

	<!-- list Archives -->
    <h2><?php _e('Archives'); ?></h2>
    <ul>
      <?php wp_get_archives('type=monthly'); ?>
    </ul>
*/?>