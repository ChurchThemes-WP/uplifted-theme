<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="panel">
		<?php the_content(); ?>
	</div>
	<div class="meta">
		<!-- <a href="<?php the_permalink(); ?>">#</a> | --><?php amplify_meta(); ?>
	</div>
</article><!-- /.hentry -->