<?php
/**
 * The template for displaying Author Archive pages.
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

      <div class="inner">

        <?php if (have_posts()) : the_post(); ?>

  			<header class="archive-header">
  				<h1 class="archive-title"><?php printf( __( 'Author Archives for %s', 'uplifted' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
  			</header><!-- .archive-header -->

  			<?php
  				/* Since we called the_post() above, we need to
  				 * rewind the loop back to the beginning that way
  				 * we can run the loop properly, in full.
  				 */
  				rewind_posts();
  			?>

  			<?php
  			// If a user has filled out their description, show a bio on their entries.
  			if ( get_the_author_meta( 'description' ) ) : ?>
  			<div class="author-info">
  				<div class="author-avatar">
  					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'uplifted_author_bio_avatar_size', 90 ) ); ?>
  				</div><!-- .author-avatar -->
  				<div class="author-description">
  					<h2><?php printf( __( 'About %s', 'uplifted' ), get_the_author() ); ?></h2>
  					<p><?php the_author_meta( 'description' ); ?></p>
  				</div><!-- .author-description	-->
  			</div><!-- .author-info -->
  			<?php endif; ?>

  			<?php /* Start the Loop */ ?>
  			<?php while ( have_posts() ) : the_post(); ?>
  				<?php get_template_part( 'content', get_post_format() ); ?>
  			<?php endwhile; ?>

  			<?php uplifted_pagination(); ?>

  		<?php else : ?>
  			<?php get_template_part( 'content', 'none' ); ?>
  		<?php endif; ?>

      </div><!-- /.inner -->

    </div><!-- /#content -->

	  <?php get_sidebar() ?>

  </div><!-- /#main -->

<?php get_footer() ?>