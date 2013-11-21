<?php
/**
 * Post Header Meta (Full and Short)
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Get data
// $date (localized range), $start_date, $end_date, $time, $venue, $address, $show_directions_link, $directions_url, $map_lat, $map_lng, $map_type, $map_zoom
extract( ctfw_event_data() );

?>

<header class="resurrect-entry-header resurrect-clearfix">

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="resurrect-entry-image">
			<?php resurrect_post_image(); ?>
		</div>
	<?php endif; ?>

	<div class="resurrect-entry-title-meta">

		<?php if ( ctfw_has_title() ) : ?>
			<h1 class="resurrect-entry-title<?php if ( is_singular( get_post_type() ) ) : ?> resurrect-main-title<?php endif; ?>">
				<?php resurrect_post_title(); // will be linked on short ?>
			</h1>
		<?php endif; ?>

		<?php if ( $date || $time || $venue || $address ) : ?>

			<ul class="resurrect-entry-meta">

				<?php if ( $date ) : ?>
					<li class="resurrect-entry-date resurrect-event-full-date resurrect-icon-content">
						<span class="<?php resurrect_icon_class( 'event-date' ); ?>"></span>
						<?php echo esc_html( $date ); ?>
					</li>
				<?php endif; ?>

				<?php if ( $time ) : ?>
					<li class="resurrect-event-full-time resurrect-icon-content">
						<span class="<?php resurrect_icon_class( 'event-time' ); ?>"></span>
						<?php echo nl2br( wptexturize( $time ) ); ?>
					</li>
				<?php endif; ?>

				<?php if ( $venue ) : ?>
					<li class="resurrect-event-full-venue resurrect-icon-content">
						<span class="<?php resurrect_icon_class( 'event-venue' ); ?>"></span>
						<?php echo esc_html( $venue ); ?>
					</li>
				<?php endif; ?>

				<?php if ( $address ) : ?>
					<li class="resurrect-event-full-address resurrect-icon-content">
						<span class="<?php resurrect_icon_class( 'event-address' ); ?>"></span>
						<?php echo nl2br( wptexturize( $address ) ); ?>
					</li>
				<?php endif; ?>

			</ul>
			
		<?php endif; ?>

	</div>

</header>
