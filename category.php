<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
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

      <div class="inner">

      <?php if (have_posts()) : ?>

      <h1 class="single-cat"><?php single_cat_title(); ?></h1>

      <?php while (have_posts()) : the_post(); ?>

      <?php get_template_part( 'content', get_post_format() ); ?>

      <?php endwhile; ?>

      <?php else : ?>

      <?php get_template_part( 'content', 'none' ); ?>

      <?php endif; ?>

      <?php amplify_pagination(); ?>

      </div><!-- /.inner -->

    </div><!-- /#content -->

	  <?php get_sidebar() ?>

  </div><!-- /#main -->

<?php get_footer() ?>