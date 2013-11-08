<?php
/*
Template Name: Sitemap Page
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */
?>

<?php get_header() ?>

	<div id="main">

		<div id="content">
		
  		<div class="panel">
  
  			<div <?php post_class("inner"); ?>>
  
          <h1><?php _e('Sitemap','amplify'); ?></h1>
          
      		<h4><?php _e('Blog / News Monthly Archives','amplify'); ?></h4>
      		<ul><?php wp_get_archives('type=monthly&limit=12'); ?> </ul>
        
      		<h4><?php _e('Pages','amplify'); ?></h4>
      		<ul><?php wp_list_pages('sort_column=menu_order&depth=0&title_li='); ?></ul>
        
        
        	<h4><?php _e('Blog / News Categories','amplify'); ?></h4>
        	<ul><?php wp_list_categories('depth=0&title_li=&show_count=1'); ?></ul>
  
  			</div><!-- /.inner -->
  			
  		</div><!-- /.panel -->

		</div><!-- /#content -->

	<?php get_sidebar() ?>

	</div><!-- /#main -->

<?php get_footer() ?>