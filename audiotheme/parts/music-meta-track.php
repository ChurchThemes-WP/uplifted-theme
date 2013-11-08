<?php
/**
 * The template for displaying a track sidebar.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */
?>

<?php if ( $thumbnail_id = get_audiotheme_track_thumbnail_id() ) : ?>

	<p class="record-artwork">
		<a href="<?php echo wp_get_attachment_url( $thumbnail_id ); ?>" itemprop="image">
			<?php echo wp_get_attachment_image( $thumbnail_id, 'record-thumbnail' ); ?>
		</a>
	</p>

<?php endif; ?>


<?php if ( get_audiotheme_track_purchase_url() || is_audiotheme_track_downloadable() ) : ?>

	<div class="meta-links">
		<ul>
			<?php if ( $purchase_url = get_audiotheme_track_purchase_url() ) : ?>
				<li><a href="<?php echo esc_url( $purchase_url ); ?>" itemprop="url" target="_blank"><?php _e( 'Purchase', 'amplify' ); ?></a></li>
			<?php endif; ?>

			<?php if ( $download_url = is_audiotheme_track_downloadable() ) : ?>
				<li><a href="<?php echo esc_url( $download_url ); ?>" itemprop="url" target="_blank"><?php _e( 'Download', 'amplify' ); ?></a></li>
			<?php endif; ?>
		</ul>
	</div>

<?php endif; ?>

<div class="record-info">

	<dl class="record-details cf">
	
		<?php if ( $year = get_audiotheme_record_release_year( $post->post_parent ) ) : ?>
			<dt><?php _e( 'Release', 'amplify' ); ?></dt>
			<dd itemprop="dateCreated"><?php echo esc_html( $year ); ?></dd>
		<?php endif; ?>
	
		<?php if ( $genre = get_audiotheme_record_genre( $post->post_parent ) ) : ?>
			<dt><?php _e( 'Genre', 'amplify' ); ?></dt>
			<dd itemprop="genre"><?php echo esc_html( $genre ); ?></dd>
		<?php endif; ?>
	
	</dl>
	
</div> <!-- /record-info -->