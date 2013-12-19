<?php
/**
 * Icon Functions
 *
 * @package    Uplifted
 * @subpackage Functions
 * @copyright  Copyright (c) 2013, upthemes.com
 * @link       http://upthemes.com/themes/uplifted
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      1.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/***********************************
 * ICON FONT
 ***********************************

/**
 * Get icon class
 *
 * Return icon class for specific element, for easy filtering to replace icons in specific areas.
 *
 * For social icons to filter, see uplifted_social_icon_map() below.
 *
 * @since 1.0
 * @param string $element Element icon used with
 * @return string Icon class
 */
function uplifted_get_icon_class( $element ) {

	// Elements and their classes
	$classes = array(
		'footer-phone'			=> 'el-icon-phone-alt',
		'footer-address'		=> 'el-icon-map-marker',
		'search-button'			=> 'el-icon-search', 		// top bar and widget
		'nav-left'				=> 'el-icon-arrow-left', 	// prev/next navigation
		'nav-right'				=> 'el-icon-arrow-right', 	// prev/next navigation
		'comments-link'			=> 'el-icon-comment', 		// "(icon) 5 Comments"
		'comment-reply'			=> 'el-icon-comment-alt', 	// "Reply" button on comment
		'comment-edit'			=> 'el-icon-edit', 			// "Edit" button on comment
		'edit-post'				=> 'el-icon-edit',			// edit button for any post type
		'gallery'				=> 'el-icon-camera',
		'quote'					=> 'el-icon-quotes-alt',
		'quote-link'			=> 'el-icon-share-alt',
		'chat'					=> 'el-icon-comment-alt',
		'link'					=> 'el-icon-share-alt',
		'image'					=> 'el-icon-photo',
		'entry-date'			=> 'el-icon-calendar',
		'entry-byline'			=> 'el-icon-user',
		'entry-parent'			=> 'el-icon-paper-clip',
		'entry-category'		=> 'el-icon-folder-open',
		'entry-tag'				=> 'el-icon-tags',
		'download'				=> 'el-icon-download', 	// generic download
		'read'					=> 'el-icon-book', 		// sermon
		'video-play'			=> 'el-icon-video',		// sermon
		'audio-play'			=> 'el-icon-headphones', // sermon
		'video-download'		=> 'el-icon-download', 	// sermon
		'audio-download'		=> 'el-icon-download', 	// sermon
		'pdf-download'			=> 'el-icon-download', 	// sermon
		'sermon-topic'			=> 'el-icon-folder-open',
		'sermon-book'			=> 'el-icon-book',
		'sermon-series'			=> 'el-icon-forward-alt',
		'sermon-speaker'		=> 'el-icon-mic',
		'event-date'			=> 'el-icon-calendar',
		'event-address'			=> 'el-icon-map-marker',
		'event-time'			=> 'el-icon-time',
		'event-directions'		=> 'el-icon-road',
		'event-venue'			=> 'el-icon-flag',
		'location-phone'		=> 'el-icon-phone-alt',
		'location-address'		=> 'el-icon-map-marker',
		'location-times'		=> 'el-icon-time',
		'location-directions'	=> 'el-icon-road',
		'person-position'		=> 'el-icon-adult',
		'person-phone'			=> 'el-icon-phone-alt',
		'person-email'			=> 'el-icon-envelope',
	);

	// Make array filterable
	$classes = apply_filters( 'uplifted_icon_classes', $classes, $element );

	// Get class for element
	$class = '';
	if ( ! empty( $classes[$element] ) ) {
		$class = $classes[$element];
	}

	// Return filterable
	return apply_filters( 'uplifted_get_icon_class', $class, $element );

}

/**
 * Output icon class
 *
 * Output contents of uplifted_get_icon_class()
 *
 * @since 1.0
 * @param string $element Element icon used with
 * @param bool $return Whether or not to return (false echos)
 * @return string If echoing class
 */
function uplifted_icon_class( $element, $return = false ) {

	$class = apply_filters( 'uplifted_icon_class', uplifted_get_icon_class( $element ) );

	if ( $return ) {
		return $class;
	} else {
		echo $class;
	}

}

/***********************************
 * SOCIAL ICONS (Header/Footer)
 ***********************************

/**
 * Icons available
 *
 * This is used in displaying icons with uplifted_social_icons() and
 * to tell which social networks are supported with uplifted_social_icon_sites().
 *
 * @since 1.0
 * @return array Icon map
 */
function uplifted_social_icon_map() {

	 // Social media sites with icons
	$icon_map = array(

		// CSS Class 								// Match in URL 	// Site Name
		'el-icon-facebook'		=> array(	'facebook',			'Facebook' ),
		'el-icon-twitter'		=> array(	'twitter',			'Twitter' ),
		'el-icon-googleplus'	=> array(	'plus.google',		'Google+' ),
		'el-icon-pinterest'		=> array( 	'pinterest',		'Pinterest' ),
		'el-icon-youtube'		=> array( 	'youtube',			'YouTube' ),
		'el-icon-vimeo'			=> array( 	'vimeo', 			'Vimeo' ),
		'el-icon-flickr'		=> array( 	'flickr',			'Flickr' ),
		'el-icon-picasa'		=> array( 	'picasa',			'Picasa' ),
		'el-icon-instagram'		=> array( 	'instagram',		'Instagram' ),
		'el-icon-foursquare'	=> array( 	'foursquare',		'Foursquare' ),
		'el-icon-tumblr'		=> array( 	'tumblr',			'Tumblr' ),
		'el-icon-skype'			=> array( 	'skype', 			'Skype' ),
		'el-icon-soundcloud'	=> array( 	'soundcloud', 		'SoundCloud' ),
		'el-icon-linkedin'		=> array( 	'linkedin', 		'LinkedIn' ),
		'el-icon-github'		=> array( 	'github',			'GitHub' ),
		'el-icon-dribble'		=> array( 	'dribbble',			'Dribbble' ),
		'el-icon-podcast'		=> array( 	array( 'itunes', 'podcast' ),	'Podcast' ),
		'el-icon-rss'			=> array( 	array( 'rss', 'feed', 'atom' ), 'RSS' ),
		'el-icon-website-alt'	=> array( 	'http', 			'Website' ), // anything not matching the above will show a generic website icon

	);

	// Return filtered
	return apply_filters( 'uplifted_social_icon_map', $icon_map );

}

/**
 * List of sites with icons
 *
 * Shown to user in Theme Customizer
 *
 * @since 1.0
 * @param bool $or True to use "or"; otherwise "and"
 * @return string List of sites with icons
 */
function uplifted_social_icon_sites( $or = false ) {

	$icon_map = uplifted_social_icon_map();

	$sites_with_icons = '';
	$sites_with_icons_count = count( $icon_map );

	$i = 0;

	foreach ( $icon_map as $site_data ) { // make list of sites with icons

		$i++;

		if ( $i > 1 ) { // not first one
			if ( $i < $sites_with_icons_count ) { // not last one
				$sites_with_icons .= _x( ', ', 'social icons list', 'uplifted' );
			} else { // last one
				if ( ! empty( $or ) ) {
					$sites_with_icons .= _x( ' or ', 'social icons list', 'uplifted' );
				} else {
					$sites_with_icons .= _x( ' and ', 'social icons list', 'uplifted' );
				}
			}
		}

		$sites_with_icons .= $site_data[1];

	}

	return apply_filters( 'uplifted_social_icon_sites', $sites_with_icons );

}

/**
 * Show icons
 *
 * @since 1.0
 * @param array $urls URLs set in Customizer
 * @param bool $return Return or echo
 * @return string Icons HTML if not echoing
 */
function uplifted_social_icons( $urls, $return = false ) {

	$icon_list = '';

	// Social media URLs defined in Customizer
	if ( ! empty( $urls ) ) {

		// Available Icons
		$icon_map = uplifted_social_icon_map();

		// Loop URLs (in order entered by user) to build icon list
		$icon_items = '';
		$url_array = explode( "\n", $urls );
		foreach ( $url_array as $url ) {

			$url = trim( $url );

			// URL is valid
			if ( ! empty( $url ) && ( '[ctcom_rss_url]' == $url || preg_match( '/^(http(s*)):\/\/(.+)\.(.+)|skype:(.+)/i', $url ) ) ) { // basic URL check

				// Find matching icon
				foreach ( $icon_map as $icon_class => $site_data ) {

					$url_checks = (array) $site_data[0];
					$url_matched = false;

					foreach ( $url_checks as $url_match ) {
						if ( preg_match( '/' . preg_quote( $url_match ) . '/i', $url ) && ! $url_matched ) {
							$url_matched = true;
							$icon_items .= '	<li><a href="' . esc_attr( $url ) . '" class="' . esc_attr( $icon_class ) . '" title="' . esc_attr( $site_data[1] ) . '" target="' . apply_filters( 'uplifted_social_icons_link_target', '_blank' ) . '"></a></li>' . "\n";
						}
					}

					if ( $url_matched ) {
						break;
					}

				}

			}

		}

		// Wrap with <ul> tags and apply shortcodes
		if ( ! empty( $icon_items ) ) {
			$icon_list = '<ul class="uplifted-list-icons">' . "\n";
			$icon_list .= do_shortcode( $icon_items ); // for [ctcom_rss_url]
			$icon_list .= '</ul>';
		}

	}

	// Echo or return filtered
	$icon_list = apply_filters( 'uplifted_social_icons', $icon_list, $urls );
	if ( $return ) {
		return $icon_list;
	} else {
		echo $icon_list;
	}

}

