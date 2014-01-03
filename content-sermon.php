<?php
/**
 * Sermon content for:
 *
 * 1. Full / Single
 * 2. Short / Multiple
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Get sermon data:
// $has_full_text		True if full text of sermon was provided as post content
// $video_player		Embed code generated from uploaded file, URL for file on other site, page on oEmbed-supported site such as YouTube, or manual embed code (HTML or shortcode)
// $video_download_url 	URL for download link (available only for local files, "Save As" will be forced)
// $audio_player		Same as video
// $audio_download_url 	Same as video
// $pdf_download_url 	URL for download link (local or externally hosted, but "Save As" forced only if local)
extract( ctfw_sermon_data() );

// Show buttons if need to switch between video and audio players or have at least one download link
$show_buttons = false;
if ( ( $video_player && $audio_player ) || $video_download_url || $audio_download_url || $pdf_download_url ) {
	$show_buttons = true;
}

/*************************************
 * 1. FULL / SINGLE
 *************************************/

if ( is_singular( get_post_type() ) ) :

	// Player request (?player=audio or ?player=video)
	// Optionally show and scroll to a specific player
	$player_request = '';
	if (
		isset( $_GET['player'] ) // query string is requesting a specific player
		&& (
			( 'video' == $_GET['player'] && $video_player )		// request is for video player and video player exists
			|| ( 'audio' == $_GET['player'] && $audio_player )	// request is for audio player and audio player exists
		)
	) {
		$player_request = $_GET['player'];
	}

	// Determine which player to show
	$show_player = '';
	if ( $player_request ) {
		$show_player = $player_request;
	} elseif ( $video_player ) {
		$show_player = 'video';
	} elseif ( $audio_player ) {
		$show_player = 'audio';
	}

	// Scroll to player requested, if any
	if ( $player_request ) {

		add_action( 'wp_footer', 'uplifted_sermon_player_scroll' );

		function uplifted_sermon_player_scroll() {

echo <<< HTML
<script>
jQuery(document).ready(function($) {
	$.smoothScroll({
		scrollTarget: '#uplifted-sermon-full-media',
		offset: -60,
		easing: 'swing',
		speed: 800
	});
});
</script>
HTML;

		}

	}

?>
  <!-- a single sermon page -->
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'uplifted-entry-full uplifted-sermon-full' ); ?>>
    
		<?php get_template_part( 'content-sermon-header' ); ?>

		<?php
		// Show media player and buttons only if post is not password protected
		if ( ( $show_player || $show_buttons ) && ! post_password_required() ) :
		?>

			<div id="uplifted-sermon-full-media">

				<?php
				// Show player if have video or audio player
				if ( $show_player ) : ?>

					<div id="uplifted-sermon-full-player">

						<?php if ( 'video' == $show_player ) : ?>
						<div id="uplifted-sermon-full-video-player">
							<?php echo $video_player; ?>
						</div>
						<?php endif; ?>

						<?php if ( 'audio' == $show_player ) : ?>
						<div id="uplifted-sermon-full-audio-player">
							<?php echo $audio_player ?>
						</div>
						<?php endif; ?>

					</div>

				<?php endif; ?>

				<?php
				// Show buttons if need to switch between video and audio players or have at least one download link
				if ( $show_buttons ) :
				?>

					<ul id="uplifted-sermon-full-buttons" class="uplifted-list-buttons">

						<?php

						// Make sure there is no whitespace between items since they are inline-block

						if ( $video_player && 'audio' == $show_player ) : // have video player but currently showing audio
							?><li id="uplifted-sermon-full-video-player-button">
								<a href="?player=video">
									<span class="uplifted-button-icon <?php uplifted_icon_class( 'video-play' ); ?>"></span>
									<?php _e( 'Show Video Player', 'uplifted' ); ?>
								</a>
							</li><?php
						endif;

						if ( $audio_player && 'video' == $show_player ) : // have audio player but currently showing video
							?><li id="uplifted-sermon-full-audio-player-button">
								<a href="?player=audio">
									<span class="uplifted-button-icon <?php uplifted_icon_class( 'audio-play' ); ?>"></span>
									<?php _e( 'Show Audio Player', 'uplifted' ); ?>
								</a>
							</li><?php
						endif;

						if ( $video_download_url ) :
							?><li id="uplifted-sermon-full-video-download-button">
								<a href="<?php echo esc_url( $video_download_url ); ?>" title="<?php echo esc_attr( __( 'Download Video', 'uplifted' ) ); ?>">
									<span class="uplifted-button-icon <?php uplifted_icon_class( 'video-download' ); ?>"></span>
									<?php _e( 'Save Video', 'uplifted' ); ?>
								</a>
							</li><?php
						endif;

						if ( $audio_download_url ) :
							?><li id="uplifted-sermon-full-audio-download-button">
								<a href="<?php echo esc_url( $audio_download_url ); ?>" title="<?php echo esc_attr( __( 'Download Audio', 'uplifted' ) ); ?>">
									<span class="uplifted-button-icon <?php uplifted_icon_class( 'audio-download' ); ?>"></span>
									<?php _e( 'Save Audio', 'uplifted' ); ?>
								</a>
							</li><?php
						endif;

						if ( $pdf_download_url ) :
							?><li id="uplifted-sermon-full-pdf-download-button">
								<a href="<?php echo esc_url( $pdf_download_url ); ?>" title="<?php echo esc_attr( __( 'Download PDF', 'uplifted' ) ); ?>">
									<span class="uplifted-button-icon <?php uplifted_icon_class( 'pdf-download' ); ?>"></span>
									<?php _e( 'Save PDF', 'uplifted' ); ?>
								</a
							></li><?php
						endif;

						?>

					</ul>

				<?php endif; ?>

			</div>

		<?php endif; ?>

		<?php if ( ctfw_has_content() || ctfw_has_excerpt() ) : ?>

			<div class="uplifted-entry-content uplifted-clearfix">

				<?php the_content(); ?>

				<?php if ( ! ctfw_has_content() ) the_excerpt(); // if no content, show excerpt if there is one ?>

				<?php do_action( 'uplifted_after_content' ); ?>

			</div>

		<?php endif; ?>

		<?php get_template_part( 'content-footer-full' ); // multipage nav, term lists, "Edit" button, etc. ?>

	</article>

<?php

/*************************************
 * 2. SHORT / MULTIPLE
 *************************************/

else :

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'uplifted-entry-short uplifted-sermon-short' ); ?>>

		<?php get_template_part( 'content-sermon-header' ); ?>

		<?php if ( ctfw_has_excerpt() || ctfw_has_more_tag() ) : ?>
			<div class="uplifted-entry-content uplifted-clearfix">
				<?php uplifted_short_content(); // output excerpt or post content up until <!--more--> quicktag used ?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'content-footer-short' ); // show appropriate button(s) ?>

	</article>

<?php endif; ?>