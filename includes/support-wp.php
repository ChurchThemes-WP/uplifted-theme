<?php
/**
 * WordPress Feature Support
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

/**
 * Add theme support for WordPress features
 *
 * @since 1.0
 */
function uplifted_add_theme_support_wp() {

	add_theme_support( 'nav-menus' );

	load_theme_textdomain( 'uplifted', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'video', 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	// Add support for custom backgrounds
	add_theme_support('custom-background');

	add_editor_style();

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// Custom background with defaults
	add_theme_support( 'custom-background', array(
		'default-color' => '888888', // default color for Customizer (somewhere between light and dark)
	) );

}

add_action( 'after_setup_theme', 'uplifted_add_theme_support_wp' );