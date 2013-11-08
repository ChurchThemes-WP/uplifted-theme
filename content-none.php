<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */
?>

<article id="post-0" class="post no-results not-found">
	<div class="panel">
		<header class="entry-header">
			<h1 class="entry-title"><?php _e( 'Nothing Found', 'amplify' ); ?></h1>
		</header>

		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'amplify' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div>
	<div class="meta">
    <?php amplify_meta(); ?>
  </div>
</article><!-- #post-0 -->