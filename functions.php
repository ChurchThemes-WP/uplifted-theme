<?php
/**
 * Primary functions.php file
 *
 * Loads all our important PHP functions and classes.
 *
 * @package WordPress
 * @subpackage Uplifted
 * @since 1.0.0
 */

// Remove Theme Options page to use Theme Customizer method instead
define('UPFW_NO_THEME_OPTIONS_PAGE',true);

/**
 * automatic updater initialization
 */

require_once 'includes/UpThemes_Theme_Updater.php';

// Define variables for our theme updates
define('UPTHEMES_LICENSE_KEY','uplifted_theme');
define('UPTHEMES_ITEM_NAME', 'Uplifted Theme');
define('UPTHEMES_STORE_URL', 'https://upthemes.com');

/**
 * Check for available theme updates
 *
 */
function uplifted_theme_update_check(){

	$upthemes_license = trim( get_option( UPTHEMES_LICENSE_KEY ) );

	$edd_updater = new UpThemes_Theme_Updater(
		array(
			'remote_api_url'  => UPTHEMES_STORE_URL,  // Our store URL that is running EDD
			'license'         => $upthemes_license, // The license key (used get_option above to retrieve from DB)
			'item_name'       => UPTHEMES_ITEM_NAME,  // The name of this theme
			'author'          => 'UpThemes'
		)
	);
}
add_action('admin_init','uplifted_theme_update_check',1);

/* end Uplifted automatic updater init script */

// Grab some necessary PHP includes
require_once 'framework/framework.php';                              // Church Framework
require_once 'includes/support-ctc.php';                             // Church Framework support declarations
require_once 'includes/support-framework.php';                       // Church Framework support
require_once 'includes/support-wp.php';                              // WordPress feature support
require_once 'includes/foundation-navbar.php';                       // Foundation Navbar Walker
require_once 'includes/sidebars.php';                                // Sidebars
require_once 'includes/images.php';                                  // Images
require_once 'includes/loop-after-content.php';                      // Loop after content
require_once 'includes/content-types.php';                           // Content types
require_once 'includes/gallery.php';                                 // Gallery filter
require_once 'includes/custom-header.php';                           // Custom header setup
require_once 'includes/template-tags.php';                           // Template Tags
require_once 'options/options.php';                                  // UpThemes Framework
require_once 'includes/style-generator.php';                         // Style regeneration
require_once 'includes/theme-options.php';                           // Load theme options specific to this theme

if ( ! isset( $content_width ) ){
	$content_width = 560;
}

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Asap by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function uplifted_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Asap or Oswald, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$asap = _x( 'on', 'Asap font: on or off', 'uplifted' );

	$oswald = _x( 'on', 'Oswald font: on or off', 'uplifted' );

	if ( 'off' !== $asap && 'off' !== $oswald ) {
		$font_families = array();

		if ( 'off' !== $asap )
			$font_families[] = 'Asap:400,700';

		if ( 'off' !== $oswald )
			$font_families[] = 'Oswald:300,400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function uplifted_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'uplifted_page_menu_args' );

/**
 * Register our nav menu locations
 *
 */
function uplifted_register_menus() {
	/**
	 * Register Menus
	 * http://codex.wordpress.org/Function_Reference/register_nav_menus#Examples
	 */
	register_nav_menus(array(
			'top-left' => 'Left Top Menu',
			'top-right' => 'Right Top Menu',
			'social'    => 'Social Menu'
	));
}

add_action('after_setup_theme','uplifted_register_menus');

/**
 * Enqueue required scripts and styles for theme
 *
 */
function uplifted_enqueue_scripts(){

	wp_enqueue_script( 'uplifted-fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js', array('jquery') );
	wp_enqueue_script( 'uplifted-flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider.js', array('jquery') );
	wp_enqueue_script( 'uplifted-oembed', get_template_directory_uri() . '/assets/js/jquery.oembed.js', array('jquery'), false, true );
	wp_enqueue_script( 'uplifted-init', get_template_directory_uri() . '/assets/js/init.js', array('uplifted-fitvids','uplifted-flexslider'), false, true );
	wp_enqueue_script( 'uplifted-foundation', get_template_directory_uri() . '/assets/js/foundation.js', array('jquery'), '5.0.0', true );
	wp_enqueue_script( 'uplifted-foundation-topbar', get_template_directory_uri() . '/assets/js/foundation.topbar.js', array('uplifted-foundation'), '5.0.0', true );
	wp_enqueue_style( 'uplifted-fonts', uplifted_fonts_url() );
	wp_enqueue_style( 'uplifted-style', get_stylesheet_uri() );
	wp_enqueue_style( 'uplifted-flexslider', get_template_directory_uri() . '/assets/css/flexslider-fonts.css' );

}

add_action('wp_enqueue_scripts','uplifted_enqueue_scripts');

/**
 * The following code enables us to recommend some plugins that work well or are
 * required for this theme to be more awesome.
 *
 * @author     Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author     Gary Jones <gamajo@gamajo.com>
 * @copyright  Copyright (c) 2012, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/includes/plugin-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'uplifted_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function uplifted_register_required_plugins() {

	/**
	 * Array of plugin arrays.
	 */
	$plugins = array(

		array(
			'name'    		=> 'MP Stacks',
			'slug'    		=> 'mp-stacks',
			'source' 		=> 'http://moveplugins.com/repo/mp-stacks/?downloadfile=true',
			'required'  	=> false,
			'external_url'	=> 'https://github.com/moveplugins/mp-stacks',
		),

		array(
			'name'    		=> 'The Events Calendar',
			'slug'    		=> 'the-events-calendar',
		),

	);

	$theme_text_domain = 'uplifted';

	$config = array(
		'domain'            => $theme_text_domain,
		'parent_menu_slug'  => 'themes.php',
		'parent_url_slug'   => 'themes.php',
		'menu'              => 'install-required-plugins',
		'has_notices'       => true,
		'is_automatic'      => false,
		'message'           => __('We recommend installing the following plugins that work with this theme to enhance your WordPress website.', $theme_text_domain ),
		'strings'           => array(
			'page_title'                            => __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                            => __( 'Install Plugins', $theme_text_domain ),
			'installing'                            => __( 'Installing Plugin: %s', $theme_text_domain ),
			'oops'                                  => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'           => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
			'notice_can_install_recommended'        => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
			'notice_cannot_install'                 => _n_noop( 'This theme works well with the %s plugin, however, you do not have the correct permissions to install it. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
			'notice_can_activate_required'          => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
			'notice_can_activate_recommended'       => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
			'notice_cannot_activate'                => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
			'notice_ask_to_update'                  => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
			'notice_cannot_update'                  => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
			'install_link'                          => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                         => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                                => __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                      => __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete'                              => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'                              => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}

/**
 * Adds a class to the body if the page has a sidebar or not.
 *
 */
function uplifted_sidebar_body_class($body_classes){
	$body_classes[] = uplifted_sidebar_enabled() ? 'uplifted-has-sidebar' : 'uplifted-no-sidebar';

	return $body_classes;
}

add_filter('body_class','uplifted_sidebar_body_class');

/**
 * Change map marker location from Church Theme Framework default.
 */
function uplifted_return_map_marker($map_icon_url){
	return get_template_directory_uri() . '/assets/images/map-icon.png';
}

add_filter('ctfw_maps_icon_color_file','uplifted_return_map_marker',999);
add_filter('ctfw_maps_icon_shadow_color_file','uplifted_return_map_marker',999);