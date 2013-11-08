<?php
/**
 * The template for displaying a record sidebar.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */
?>

<?php if ( has_post_thumbnail() ) : ?>

	<p class="record-artwork">
		<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" itemprop="image">
			<?php the_post_thumbnail( 'record-thumbnail' ); ?>
		</a>
	</p>

<?php endif; ?>


<div class="record-info">
	
	<dl class="record-details cf">
	
		<?php if ( $artist = get_audiotheme_record_artist() ) : ?>
			<dt><?php _e( 'Artist:', 'amplify' ); ?></dt>
			<dd itemprop="byArtist"><?php echo esc_html( $artist ); ?></dd>
		<?php endif; ?>
	
		<?php if ( $year = get_audiotheme_record_release_year() ) : ?>
			<dt><?php _e( 'Release:', 'amplify' ); ?></dt>
			<dd itemprop="dateCreated"><?php echo esc_html( $year ); ?></dd>
		<?php endif; ?>
	
		<?php if ( $genre = get_audiotheme_record_genre() ) : ?>
			<dt><?php _e( 'Genre:', 'amplify' ); ?></dt>
			<dd itemprop="genre"><?php echo esc_html( $genre ); ?></dd>
		<?php endif; ?>
	
	</dl>
	
	
	<?php if ( $links = get_audiotheme_record_links() ) : ?>
	
		<div class="meta-links">
			<!-- <h2><?php _e( 'Purchase', 'amplify' ); ?></h2> -->
			<ul>
				<?php
				foreach( $links as $link ) {
					printf( '<li><a href="%s"%s itemprop="url">%s</a></li>',
						$link['url'],
						( false === strpos( $link['url'], home_url() ) ) ? ' target="_blank"' : '',
						$link['name']
					);
				}
				?>
			</ul>
		</div>
	
	<?php endif; ?>

</div> <!-- /record-info -->