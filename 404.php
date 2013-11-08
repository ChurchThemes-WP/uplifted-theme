<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Uplifted
 * @since 1.0.0
 */

get_header(); ?>

  <div id="main">

    <div id="content">

      <div class="inner">

  			<article id="post-0" class="post error404 no-results not-found">
  				<header class="entry-header">
  					<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'uplifted' ); ?></h1>
  				</header>

  				<div class="entry-content">
  					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'uplifted' ); ?></p>
  					<?php get_search_form(); ?>
  				</div><!-- .entry-content -->
  			</article><!-- #post-0 -->

      </div><!-- /.inner -->

    </div><!-- /#content -->

	  <?php get_sidebar(); ?>

  </div><!-- /#main -->

<?php get_footer(); ?>