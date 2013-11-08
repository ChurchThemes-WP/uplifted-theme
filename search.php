<?php
/**
 * The template for displaying Search pages.
 *
 * Used to display search results.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Uplifted
 * @since 1.0.0
 */

get_header(); ?>

  <div id="main">

  	<div id="content">

			<?php if (have_posts()) : ?>

      <h1><?php echo sprintf( __('Search Results for %s','uplifted'), "<em id=\"search-terms\">'" . esc_html(get_query_var('s')) . "'" ); ?> </em></h1>

      <?php while (have_posts()) : the_post(); ?>

      <?php get_template_part( 'content', get_post_format() ); ?>

      <?php endwhile; ?>

      <?php else : ?>

      <?php get_template_part( 'content', 'none' ); ?>

      <?php endif; ?>

      <?php uplifted_pagination(); ?>

    </div><!-- /#content -->

		<?php get_sidebar() ?>

  </div><!--/#main-->

<?php get_footer(); ?>