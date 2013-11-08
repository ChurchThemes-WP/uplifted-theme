<?php
/**
 * The template for displaying a single track.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */

get_header();
?>


<div class="audiotheme-record-single" role="main" itemscope itemtype="http://schema.org/MusicRecording">

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
		
			<div class="audiotheme">
			
				<div id="main">
				
					<div class="secondary-area entry-meta">

						<?php get_template_part( 'audiotheme/parts/music-meta', 'track' ); ?>
		
					</div> <!-- /secondary-area -->
					
					<div class="primary-area">
						
						<header class="entry-header">
							
							<div>
								
								<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
								
								<h2 class="subtitle">
									<span class="sep"><?php _e( 'from', 'amplify' ); ?></span>
									<a href="<?php echo get_permalink( $post->post_parent ); ?>"><em itemprop="inAlbum"><?php echo get_the_title( $post->post_parent ); ?></em></a>
								</h2>
							
							</div>
						
						</header>
		
						<div class="tracklist-section">
						
							<ul class="tracklist audiotheme-tracklist">
								
								<li id="track-<?php the_ID(); ?>" class="track audiotheme-track">
									<span class="track-cell audiotheme-track-cell">
										<span class="track-title"><?php the_title(); ?></span>
		
										<span class="track-meta audiotheme-track-meta">
											<span class="jp-current-time">-:--</span>
										</span>
									</span>
								
								</li>
							</ul>
		
							<?php enqueue_audiotheme_tracks( get_the_ID(), 'record' ); ?>
						</div>
		
						<div class="content entry-content" itemprop="description">
							<?php the_content( '' ); ?>
						</div>
		
					</div> <!-- /primary-area -->
				
				</div> <!-- /main -->
			
			</div> <!-- /audiotheme -->

		</article>

	<?php endwhile; ?>

</div>


<?php get_footer(); ?>