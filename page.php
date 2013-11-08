<?php
/**
 * The template for displaying pages.
 *
 * Used to display standard pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */

get_header(); ?>

  <div id="main">

  	<div id="content">

		<?php if( have_posts() ): while( have_posts() ) : the_post(); ?>

    <?php get_template_part( 'content', 'page' ); ?>

    <?php comments_template(); ?>

    <?php endwhile; else : ?>

    <?php get_template_part( 'content', 'none' ); ?>

    <?php endif; ?>

    </div><!-- /#content -->

    <?php get_sidebar() ?>

  </div><!-- /#main -->

<?php get_footer() ?>