<?php
/**
 * Post Header Meta (Full and Short)
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Get data
// $address, $show_directions_link, $directions_url, $phone, $times, $map_lat, $map_lng, $map_type, $map_zoom
extract( ctfw_location_data() );

?>

<?php if ( has_post_thumbnail() ) : ?>
	<div class="uplifted-entry-image">
		<?php uplifted_post_image(); ?>
	</div>
<?php endif; ?>

<div class="location-content">

<header class="uplifted-entry-header clearfix">	

	<div class="uplifted-entry-title-meta">

		<?php if ( ctfw_has_title() ) : ?>
			<h1 class="uplifted-entry-title<?php if ( is_singular( get_post_type() ) ) : ?> uplifted-main-title<?php endif; ?>">
				<?php uplifted_post_title(); // will be linked on short ?>
			</h1>
		<?php endif; ?>

		<ul class="uplifted-entry-meta">

			<?php if ( $address ) : ?>
				<li class="uplifted-location-address uplifted-content-icon">
					<span class="<?php uplifted_icon_class( 'location-address' ); ?>"></span>
					<?php echo nl2br( wptexturize( $address ) ); ?>
				</li>
			<?php endif; ?>

			<?php if ( $phone ) : ?>
				<li class="uplifted-location-phone uplifted-content-icon">
					<span class="<?php uplifted_icon_class( 'location-phone' ); ?>"></span>
					<?php echo esc_html( $phone ); ?>
				</li>
			<?php endif; ?>

			<?php if ( $times ) : ?>
				<li class="uplifted-location-times uplifted-content-icon">
					<span class="<?php uplifted_icon_class( 'location-times' ); ?>"></span>
					<?php echo nl2br( wptexturize( $times ) ); ?>
				</li>
			<?php endif; ?>

		</ul>

	</div>

</header>
