<?php
/**
 * The template for displaying page content
 *
 * @package WordPress
 * @subpackage Uplifted
 * @since 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <?php if( has_post_thumbnail() ): ?>
    <div class="featured-image"><?php the_post_thumbnail("featured-image") ?></div>
  <?php endif; ?>

  <div class="panel">
    <?php if( !is_single() ): ?>
    <h1 class="entry-title">
      <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __('Permanent Link to %s','uplifted'), get_the_title() ) ); ?>"><?php the_title(); ?></a>
    </h1>
    <?php else: ?>
    <h2 class="entry-title">
      <?php the_title(); ?>
    </h2>
    <?php endif; ?>

	  <?php the_content(); ?>

    <?php wp_link_pages(); ?>

  </div>
  <div class="meta">
    <?php uplifted_meta(); ?>
  </div>

</article><!-- /.hentry -->