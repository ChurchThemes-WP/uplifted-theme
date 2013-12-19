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

<header class="uplifted-entry-header uplifted-clearfix">

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="uplifted-entry-image">
			<?php uplifted_post_image(); ?>
		</div>
	<?php endif; ?>

	<div class="uplifted-entry-title-meta">

		<?php if ( ctfw_has_title() ) : ?>
			<h1 class="uplifted-entry-title<?php if ( is_singular( get_post_type() ) ) : ?> uplifted-main-title<?php endif; ?>">
				<?php uplifted_post_title(); // will be linked on short ?>
			</h1>
		<?php endif; ?>

		<?php if ( $date || $time || $venue || $address ) : ?>

			<ul class="uplifted-entry-meta">

				<?php if ( $date ) : ?>
					<li class="uplifted-entry-date uplifted-event-full-date uplifted-icon-content">
						<span class="<?php uplifted_icon_class( 'event-date' ); ?>"></span>
						<?php echo esc_html( $date ); ?>
					</li>
				<?php endif; ?>

				<?php if ( $time ) : ?>
					<li class="uplifted-event-full-time uplifted-icon-content">
						<span class="<?php uplifted_icon_class( 'event-time' ); ?>"></span>
						<?php echo nl2br( wptexturize( $time ) ); ?>
					</li>
				<?php endif; ?>

				<?php if ( $venue ) : ?>
					<li class="uplifted-event-full-venue uplifted-icon-content">
						<span class="<?php uplifted_icon_class( 'event-venue' ); ?>"></span>
						<?php echo esc_html( $venue ); ?>
					</li>
				<?php endif; ?>

				<?php if ( $address ) : ?>
					<li class="uplifted-event-full-address uplifted-icon-content">
						<span class="<?php uplifted_icon_class( 'event-address' ); ?>"></span>
						<?php echo nl2br( wptexturize( $address ) ); ?>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

	</div>

</header>
