<?php
/*
Template Name: Archives Page
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
  */
?>

<?php get_header(); ?>

  <div id="main">

    <div id="content">
    
      <div class="panel">
  
  			<h1 class="entry-title"><?php the_title(); ?></h1>
  
        <div class="row">
  
            <div class="small-6 large-6 columns">
  
                <h3><?php _e("Categories","amplify"); ?></h3>
  
                <ul>
                    <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
                </ul>
  
            </div>
  
            <div class="small-6 large-6 columns">
  
                <h3><?php _e('Monthly archives','amplify'); ?></h3>
  
                <ul>
                    <?php wp_get_archives('type=monthly&show_post_count=1') ?>
                </ul>
  
            </div>
  
        </div>
  
  			<?php if (function_exists('wp_tag_cloud')) { ?>
  
        <div id="tag-cloud" class="buffer">
  
          <h3><?php _e('Popular tags','amplify'); ?></h3>
  
          <ul class="list1">
            <?php wp_tag_cloud('smallest=10&largest=18'); ?>
          </ul>
  
  			</div><!--/#tag-cloud -->
  
        <?php } ?>
  
  			<div class="last-thirty-posts">
  
  				<h3><?php _e('The last 30 posts','amplify'); ?></h3>
  
          <ul>
          <?php $query = new WP_Query('showposts=30'); ?>
          <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> - <?php the_time(get_option('date_format')); ?></li>
          <?php endwhile; endif; ?>
          </ul>
  
  			</div><!--/#last-thirty-posts -->
  			
      </div> <!-- /.panel -->

    </div><!-- /#content -->

	  <?php get_sidebar() ?>

  </div><!-- /#main -->

<?php get_footer() ?>