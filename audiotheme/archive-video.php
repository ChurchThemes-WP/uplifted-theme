<?php
/**
 * The template to display list of videos.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */

get_header();
?>

<?php do_action( 'audiotheme_before_main_content' ); ?>

<h1 class="audiotheme-archive-title"><?php the_audiotheme_archive_title(); ?></h1>

<?php the_audiotheme_archive_description( '<div class="audiotheme-archive-intro content">', '</div>' ); ?>

<ul class="audiotheme-videos audiotheme-grid audiotheme-clearfix">

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<a class="audiotheme-featured-image" href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'video-thumbnail' ); ?></a>

			<?php the_title( '<h2 class="audiotheme-video-title entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
			
		</li>

	<?php endwhile; ?>

</ul>

<?php audiotheme_archive_nav(); ?>

<?php do_action( 'audiotheme_after_main_content' ); ?>

<?php get_footer(); ?>