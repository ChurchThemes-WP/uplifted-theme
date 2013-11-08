<?php
/**
 * The template for displaying a single gig.
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
		
			<div class="panel">
			
				<?php
					while ( have_posts() ) :
						the_post();
				
						$gig = get_audiotheme_gig();
						$venue = get_audiotheme_venue( $gig->venue->ID );
						?>
						<section id="post-<?php the_ID(); ?>" <?php post_class( 'page page-wrap post-bubble' ); ?>>
						
							<header>
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
				
							</header>
							
							<ul class="gig-details">
				
								<li>
									
									<?php echo get_audiotheme_gig_time( 'g:i A' ); ?>
								
								</li>
				
								<?php if ( $gig_tickets_price = get_audiotheme_gig_tickets_price() ) : ?>
								<li>
                  
                  <span class="bullet-sep">&bull;</span>
									<span><?php _e( 'Admission:', 'amplify' ); ?></span>
			
									<?php if ( $gig_tickets_url = get_audiotheme_gig_tickets_url() ) : ?>
										<a href="<?php echo esc_url( $gig_tickets_url ); ?>" target="_blank" class="gig-tickets-link url">
									<?php endif; ?>
			
										<?php echo esc_html( $gig_tickets_price ); ?>
			
									<?php if ( $gig_tickets_url ) : ?>
										</a>
									<?php endif; ?>
			
								</li>
								<?php endif; ?>
							
							</ul>
							
							<?php the_audiotheme_gig_description( '<div class="gig-note" itemprop="description">', '</div>' ); ?>
				
							<?php if ( audiotheme_gig_has_venue() ) : ?>
				
								<div class="gig-location">
									<?php
									$address = get_audiotheme_venue_address( $venue->ID );
									$address = ( $address ) ? $venue->name . ', ' . $address : $venue->name;
				
									$bg = add_query_arg( array(
										'center'  => rawurlencode( $address ),
										'size'    => '800x200',
										'scale'   => 2,
										'format'  => 'jpg',
										'sensor'  => 'false',
										'markers' => 'size:tiny|' . rawurlencode( $address ),
									), 'http://maps.googleapis.com/maps/api/staticmap' );
				
									printf( '<a href="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=%s" class="gig-map" style="background-image: url(\'%s\')" target="_blank"></a>',
										rawurlencode( $address ),
										esc_url( $bg )
									);
									?>
				
									<div class="gig-venue-address">
										<?php
										the_audiotheme_venue_vcard( array(
											'container'         => '',
											'show_country'      => false,
											'show_phone'        => false,
											'separator_address' => ', ',
										) );
										?>
									</div>
				
								</div>
				
							<?php endif; ?>
				
							<?php the_content( '' ); ?>
				
						</section>
				
					<?php endwhile; ?>
			
			</div> <!-- /panel -->		
		
		</div> <!-- /content -->
		
		<?php get_sidebar(); ?>
	
	</div> <!-- /main -->

</div> <!-- /audiotheme -->

<?php get_footer(); ?>