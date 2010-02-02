<?php get_header(); ?>

<div id="center">
  <div id="center-in" class="blog">
    <h2>
      <?php _e('Not Found'); ?>
    </h2>
    <p>
      <?php _e('Sorry, but the page you requested cannot be found.'); ?>
    </p>
    <br />
    <h3>
      <?php _e('Try Searching...'); ?>
    </h3>
    <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    <br clear="all" />

</div><!-- end #center -->
</div><!-- end #center-in -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
