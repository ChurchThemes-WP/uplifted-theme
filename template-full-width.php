<?php
/*
Template Name: Full Width Page
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

  <div id="main">

    <div id="content">

  		<?php if( have_posts() ): while( have_posts() ) : the_post(); ?>

  		<?php get_template_part( 'content', 'page' ); ?>

  		<?php endwhile; else: ?>

      <?php get_template_part( 'content', 'none' ); ?>

  		<?php endif; ?>

    </div><!-- /#content -->

  </div><!-- /#main -->

<?php get_footer() ?>