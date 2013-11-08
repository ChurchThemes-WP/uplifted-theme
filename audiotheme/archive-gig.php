<?php
/**
 * The template to display list of gigs.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */

get_header();
?>

<div class="audiotheme">

	<div id="main">
	
		<div id="content">

			<header class="gig-list-header">
				
				<h1 class="entry-title"><?php _e( 'Upcoming Shows', 'amplify' ); ?></h1>
			
			</header>
	
			<div class="gig-list">
				<?php while ( have_posts() ) : the_post(); ?>
					
					<a href="<?php echo get_permalink( $post->ID ); ?>" class="gig-permalink">
						
						<dl class="gig-summary">
						
							<dd class="gig-date">
									<time class="dtstart" datetime="<?php echo get_audiotheme_gig_time( 'c' ); ?>">
										<?php echo get_audiotheme_gig_time( 'M d' ); ?>
									</time>
							</dd>
							
							<div class="gig-meta">
							
								<dt class="gig-title">
									<?php
									$gig = get_audiotheme_gig();
									$venue = get_audiotheme_venue( $gig->venue->ID );
			
									echo ( $location = get_audiotheme_venue_location( $gig->venue->ID ) ) ? $location : '&mdash;';
									?>
								</dt>
			
								<?php if ( audiotheme_gig_has_venue() ) : ?>
			
									<dd class="gig-venue">
										<?php echo $venue->name; ?>
									</dd>
			
								<?php endif; ?>
							
							</div>
		
						</dl> <!-- end /gig-summary -->
						
					</a>
	
				<?php endwhile; ?>
			</div>
		
		</div> <!-- /content -->
		
		<?php get_sidebar(); ?>
	
	</div> <!-- /main -->

</div> <!-- /audiotheme -->

<?php get_footer(); ?>