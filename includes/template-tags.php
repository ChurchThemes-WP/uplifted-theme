<?php
/**
 * Template Tags
 *
 * These output common elements for different post types. Use in content-*.php templates.
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

/********************************
 * TITLE
 ********************************/

/**
 * Post title for full or short
 *
 * If short/multiple view (not singular), title is linked.
 *
 * @since 1.0
 * @return string Post title with page number or linked
 */
function uplifted_post_title() {

	// Full/Single - Not Linked
	if ( is_singular( get_post_type() ) ) {
		$title = uplifted_title_paged( false, 'return' ); // show with (Page #) if multipage
	}

	// Short/Multiple - Linked
	else {
		$title = '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( the_title_attribute( array( 'echo' => false ) ) ) . '">' . get_the_title() . '</a>';
	}

	echo apply_filters( 'uplifted_post_title', $title );

}

/**
 * Output page title with "(Page #)" as needed
 *
 * @since 1.0
 * @param string $title Title of page
 * @param bool $return Return or echo title with page number
 * @return string Page title woth number if not echoing
 */
function uplifted_title_paged( $title = '', $return = false ) {

	// Default title if none passed in
	if ( empty( $title ) ) {
		$title = get_the_title();
	}

	// Get page number
	$show_number = ctfw_page_num();

	// Title format if on page 2 or greater
	/* translators: %s is page title, %d is page number */
	if ( $show_number > 1 ) {
		$title_paged = sprintf( __( '%s <span>(Page %d)</span>', 'uplifted' ), $title, $show_number );
	}

	// Default title for Page 1 (or no number found)
	else {
		$title_paged = $title;
	}

	// Make filterable
	$output = apply_filters( 'uplifted_title_paged', $title_paged, $title );

	// Echo or return
	if ( $return ) {
		return $output;
	} else {
		echo $output;
	}

}

/********************************
 * BREADCRUMBS
 ********************************/

/**
 * Output breadcrumb path
 *
 * @since 1.0
 * @param string $location $location is either content or banner
 */
function uplifted_breadcrumbs( $location ) {

	$upfw_options = upfw_get_options();

	$breadcrumbs = '';

	// Breadcrumbs are enabled
	if ( $upfw_options->show_breadcrumbs == 'enabled' ) {

		$breadcrumbs = new CTFW_Breadcrumbs();

	}

	// Return filtered
	echo apply_filters( 'uplifted_breadcrumbs', $breadcrumbs, $location );

}

/********************************
 * CONTENT
 ********************************/

/**
 * Post featured image for full or short
 *
 * If short/multiple view (not singular), image is linked.
 *
 * @since 1.0
 * @return string Featured image HTML
 */
function uplifted_post_image() {

	// Featured image
	$image = get_the_post_thumbnail( null, 'post-thumbnail', array(
		'class' => 'uplifted-image' )
	);

	// Link if short / multiple
	if ( ! is_singular( get_post_type() ) ) {
		$image = '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( the_title_attribute( array( 'echo' => false ) ) ) . '">' . $image . '</a>';
	}

	echo apply_filters( 'uplifted_post_image', $image );

}

/**
 * Comments showing?
 *
 * Useful for checking if comments link should be shown.
 *
 * @since 1.0
 * @return bool True if comments are to be shown
 */
function uplifted_show_comments() {

	$show = false;

	// True if comments open or closed but already have comments; hide if password protected
	if ( ( comments_open() || get_comments_number() > 0 ) && ! post_password_required() ) {
		$show = true;
	}

	return apply_filters( 'uplifted_show_comments', $show );

}

if ( ! function_exists( 'uplifted_comments_link' ) ) : // pluggable since not filterable
/**
 * Comments link
 *
 * @since 1.0
 */
function uplifted_comments_link() {

	// Show if comments open or closed but already have comments; hide if password protected
	if ( uplifted_show_comments() ) {

		$scroll_class = is_singular() ? 'uplifted-scroll-to-comments' : ''; // full post only

		comments_popup_link(
			__( '0 Comments', 'uplifted' ),
			__( '1 Comment', 'uplifted' ),
			__( '% Comments', 'uplifted' ),
			$scroll_class,
			'' // show nothing when comments off
		);

	}

}
endif;

if ( ! function_exists( 'uplifted_short_content' ) ) : // pluggable since not filterable
/**
 * Output excerpt or post content up until <!--more--> quicktag
 *
 * @since 1.0
 * @global object Post object
 */
function uplifted_short_content() {

	global $post;

	$post_format = get_post_format();

	// Author used <!--more--> quicktag
	if ( ctfw_has_more_tag() ) {

		// Make it work in pages / "loop after content"
		// See this: http://codex.wordpress.org/Customizing_the_Read_More#How_to_use_Read_More_in_Pages
		global $more;
		$more = 0;

		the_content( '' ); // no automatic "more" link; use footer template's link

	}

	// Show excerpt only
	else {
		the_excerpt();
	}

}
endif;
