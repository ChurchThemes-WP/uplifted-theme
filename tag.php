<?php
/**
 * The template for displaying Tag pages.
 *
 * Used to display archive-type pages for posts with a certain tag.
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

    <?php if (have_posts()) : ?>

		<header class="archive-header">
			<h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', 'amplify' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>

		<?php if ( tag_description() ) : // Show an optional tag description ?>
			<div class="archive-meta"><?php echo tag_description(); ?></div>
		<?php endif; ?>
		</header><!-- .archive-header -->

    <?php while (have_posts()) : the_post(); ?>

    <?php get_template_part( 'content', get_post_format() ); ?>

    <?php endwhile; ?>

    <?php else : ?>

    <?php get_template_part( 'content', 'none' ); ?>

    <?php endif; ?>

    <?php amplify_pagination(); ?>

    </div><!-- /#content -->

	  <?php get_sidebar() ?>

  </div><!-- /#main -->

<?php get_footer() ?>