<?php
/**
 * The template for displaying posts in the Quote post format
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <div class="panel">
    <?php if( !is_single() ): ?>
    <h1 class="entry-title">
      <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __('Permanent Link to %s','amplify'), get_the_title() ) ); ?>"><?php the_title(); ?></a>
    </h1>
    <?php else: ?>
    <h2 class="entry-title">
      <?php the_title(); ?>
    </h2>
    <?php endif; ?>

    <?php the_content(); ?>
  </div>

  <div class="meta">
    <?php amplify_meta(); ?>
  </div>

</article><!-- /.hentry -->