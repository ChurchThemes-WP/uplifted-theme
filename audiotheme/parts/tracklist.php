<?php
/**
 * The template for displaying the tracks that belong to a record.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */
?>

<?php if ( $tracks = get_audiotheme_record_tracks() ) : ?>

	<div class="tracklist-section">

		<ul class="tracklist audiotheme-tracklist">
			<?php foreach ( $tracks as $track ) : ?>
				<li id="track-<?php echo $track->ID; ?>" class="track audiotheme-track" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">
					<span class="track-cell audiotheme-track-cell">
						<a href="<?php echo get_permalink( $track->ID ); ?>" itemprop="url" class="track-title"><span itemprop="name"><?php echo apply_filters( 'the_title', $track->post_title ); ?></span></a>

						<span class="track-meta audiotheme-track-meta">
							<span class="jp-current-time">-:--</span>
						</span>
					</span>
				</li>
			<?php endforeach ?>
		</ul>

	</div> <!-- /tracklist -->

	<?php enqueue_audiotheme_tracks( wp_list_pluck( $tracks, 'ID' ), 'record' ); ?>

<?php endif; ?>