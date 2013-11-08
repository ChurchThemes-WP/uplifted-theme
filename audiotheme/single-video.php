<?php
/**
 * The template for displaying a single video.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */

get_header();
?>

<?php do_action( 'audiotheme_before_main_content' ); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'audiotheme-video-single' ); ?> role="article">

		<?php the_audiotheme_video(); ?>
		
		<div class="panel">

			<header class="audiotheme-video-header entry-header">
				<?php the_title( '<h1 class="audiotheme-video-title entry-title">', '</h1>' ); ?>
			</header>
			
			<?php if ( $tag_list = get_the_tag_list( '', ' ' ) ) : ?>
				
				<div class="audiotheme-term-list">
					<span class="audiotheme-term-list-label"><?php _e( 'Tags', 'amplify' ); ?></span>
					<span class="audiotheme-term-list-items"><?php echo $tag_list; ?></span>
				</div>
				
			<?php endif; ?>
	
			<div class="audiotheme-content entry-content">
				<?php the_content( '' ); ?>
			</div>
		
		</div> <!-- /panel -->

	</article>

<?php endwhile; ?>

<?php do_action( 'audiotheme_after_main_content' ); ?>

<?php get_footer(); ?>