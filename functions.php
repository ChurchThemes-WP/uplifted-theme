<?php

// Grab some necessary PHP includes
require_once 'framework/framework.php';                              // Church Framework
require_once 'includes/support-ctc.php';                             // Church Framework support declarations
require_once 'includes/support-framework.php';                       // Church Framework support
require_once 'includes/support-wp.php';                              // WordPress feature support
require_once 'includes/icons.php';                                   // Icons
require_once 'includes/banner.php';                                  // Banner
require_once 'includes/sidebars.php';                                // Sidebars
require_once 'includes/loop-after-content.php';                      // Loop after content
require_once 'includes/content-types.php';                           // Content types
require_once 'includes/gallery.php';                                 // Gallery filter
require_once 'includes/custom-header.php';                           // Custom header setup
require_once 'includes/foundation-navbar.php';                       // Foundation navbar
require_once 'includes/responsive-slider/responsive-slider.php';     // Responsive slider
require_once 'includes/presstrends.php';                             // PressTrends
require_once 'includes/template-tags.php';                           // Template Tags
require_once 'options/options.php';                                  // UpThemes Framework
require_once 'includes/theme-options.php';                           // Load theme options specific to this theme

// Define variables for our theme updater
define('UPTHEMES_ITEM_NAME', 'Uplifted Theme');
define('UPTHEMES_STORE_URL', 'http://upthemes.com');
define('UPTHEMES_LICENSE_KEY', 'uplifted_license_key');

if ( !class_exists( 'UpThemes_Theme_Updater' ) ) {
	// Load our custom theme updater
	require_once 'includes/UpThemes_Theme_Updater.php';
}

if ( ! isset( $content_width ) ){
  $content_width = 560;
}

function uplifted_theme_update_check(){
	$upthemes_license = trim( get_option( UPTHEMES_LICENSE_KEY ) );

	$edd_updater = new UpThemes_Theme_Updater( array(
			'remote_api_url' 	=> UPTHEMES_STORE_URL, 	// Our store URL that is running EDD
			'version' 			=> '1.0', 				// The current theme version we are running
			'license' 			=> $upthemes_license, 		// The license key (used get_option above to retrieve from DB)
			'item_name' 		=> UPTHEMES_ITEM_NAME,	// The name of this theme
			'author'			=> 'UpThemes'	// The author's name
		)
	);
}
add_action('admin_init','uplifted_theme_update_check',1);


/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Open Sans by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function uplifted_fonts_url() {
  $fonts_url = '';

  /* Translators: If there are characters in your language that are not
   * supported by Open Sans, translate this to 'off'. Do not translate into your
   * own language.
   */
  $open_sans = _x( 'on', 'Open Sans font: on or off', 'uplifted' );

  if ( 'off' !== $open_sans ) {
    $font_families = array();

    if ( 'off' !== $open_sans )
      $font_families[] = 'Open+Sans:300,500,700';

    $query_args = array(
      'family' => urlencode( implode( '|', $font_families ) ),
      'subset' => urlencode( 'latin,latin-ext' ),
    );
    $fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
  }

  return $fonts_url;
}

/**
 * Set up our theme widgets
 *
 */
function uplifted_widgets_init(){
  register_sidebar( array(
  		'name'          => __('Sidebar','uplifted'),
  		'id'            => 'sidebar',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</div>',
  		'before_title'  => '<h4>',
  		'after_title'   => '</h4>' ));

  register_sidebar( array(
  		'name'          => __('Footer First Column','uplifted'),
  		'id'            => 'uplifted-footer-column-one',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</div>',
  		'before_title'  => '<h4>',
  		'after_title'   => '</h4>' ));

  register_sidebar( array(
  		'name'          => __('Footer Second Column','uplifted'),
  		'id'            => 'uplifted-footer-column-two',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</div>',
  		'before_title'  => '<h4>',
  		'after_title'   => '</h4>' ));

  register_sidebar( array(
  		'name'          => __('Footer Third Column','uplifted'),
  		'id'            => 'uplifted-footer-column-three',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</div>',
  		'before_title'  => '<h4>',
  		'after_title'   => '</h4>' ));
}

add_action('widgets_init','uplifted_widgets_init');

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function uplifted_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'uplifted_page_menu_args' );

function uplifted_enqueue_scripts(){

  wp_enqueue_script( 'uplifted-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery') );
  wp_enqueue_script( 'uplifted-init', get_template_directory_uri() . '/js/init.js', array('uplifted-plugins'), false, true );
  wp_enqueue_script( 'uplifted-foundation', get_template_directory_uri() . '/js/foundation.js', array('jquery'), '5.0.0', true );
  wp_enqueue_script( 'uplifted-foundation-topbar', get_template_directory_uri() . '/js/foundation.topbar.js', array('uplifted-foundation'), '5.0.0', true );

}

add_action('wp_enqueue_scripts','uplifted_enqueue_scripts');

/**
 * Adds a theme layout based on selected admin option
 *
 */
function uplifted_set_layout($body_class){

  $up_options = upfw_get_options();

	if( isset($up_options->layout) && $up_options->layout ){

	  $body_class[] = "layout_" . esc_attr($up_options->layout);

	}

	return $body_class;

}

add_filter('body_class','uplifted_set_layout');

/**
 * Outputs theme footer option text.
 *
 */
function uplifted_theme_footer() {

  $up_options = upfw_get_options();

  echo $up_options->footertext;

}

/**
 * Outputs built-in pagination links
 *
 * @uses add_query_arg()
 * @uses get_query_var()
 * @uses paginate_links()
 *
 */
function uplifted_pagination( $type = 'plain', $endsize = 1, $midsize = 1 ) {

  echo '  <div class="paging">'."\n";

    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

    // Sanitize input argument values
    if ( ! in_array( $type, array( 'plain', 'list', 'array' ) ) ) $type = 'plain';
    $endsize = (int) $endsize;
    $midsize = (int) $midsize;

    // Setup argument array for paginate_links()
    $pagination = array(
        'base' => @add_query_arg('paged','%#%'),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'show_all' => false,
        'end_size' => $endsize,
        'mid_size' => $midsize,
        'type' => $type,
        'prev_text' => __('&larr; Previous','uplifted'),
        'next_text' => __('Next &rarr;','uplifted')
    );

    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

    echo paginate_links( $pagination );

  echo '  </div>'."\n";
}

/**
 * Outputs post metadata for each post.
 *
 */
function uplifted_meta(){

?>
    <div class="meta-group left">

      <div class="date">
        <i class="genericon genericon-month"></i>
        <a href="<?php the_permalink(); ?>"><?php the_time( get_option('date_format') ); ?></a>
      </div>
      <div class="post-author">
        &#8901; <?php the_author_posts_link(); ?>
      </div>

    </div> <!-- /left -->

    <div class="meta-group right">

      <?php the_category(', ') ?>
      <?php the_tags( __( '&bull; Tags: ','uplifted'), ', ', '<br />'); ?>

    </div> <!-- /right -->

<?php

}

if ( ! function_exists( 'uplifted_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own uplifted_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function uplifted_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'uplifted' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'uplifted' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo '<div class="avatar-wrap">' . get_avatar( $comment, $avatar_size ) . '</div>';
					?>

					<?php edit_comment_link( __( 'Edit', 'uplifted' ), '<span style="clear:both;display:block;"></span><div class="edit-link">', '</div>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'uplifted' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content">
        <div class="author-name">
        <?php
        /* translators: 1: comment author, 2: date and time */
        printf( __( '%1$s <span class="says">says:</span>', 'uplifted' ),
          sprintf( '<span class="fn">%s</span>', get_comment_author_link() ));

        ?>
      </div>
        <?php

        comment_text();

        printf( __( '%1$s', 'uplifted' ),
          sprintf( '<a class="comment-date" href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
            esc_url( get_comment_link( $comment->comment_ID ) ),
            get_comment_time( 'c' ),
            /* translators: 1: date, 2: time */
            sprintf( __( '%1$s at %2$s', 'uplifted' ), get_comment_date(), get_comment_time() )
          ));

        ?>

        <div class="reply">
          <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<span>&#171;</span> Reply', 'uplifted' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div><!-- .reply -->
      </div>
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for uplifted_comment()

function uplifted_responsive_slider(){
  if( is_home() ){
    echo '<div id="homepage-slider">';
    echo '<div class="inner">';
    echo do_shortcode( '[responsive_slider]' );
    echo "</div>";
    echo "</div>";
  }
}

add_action('after_header','uplifted_responsive_slider');

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
require_once dirname( __FILE__ ) . '/includes/plugin-activation/tgm-plugin-activation/class-tgm-plugin-activation.php';

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
      'name'    => 'Church Theme Content',
      'slug'    => 'church-theme-content',
      'force-activation' => true,
      'required'  => true,
    ),

    array(
      'name'    => 'Page Builder by SiteOrigin',
      'slug'    => 'siteorigin-panels',
      'required'  => false,
    ),

    array(
      'name'    => 'Black Studio TinyMCE Widget',
      'slug'    => 'black-studio-tinymce-widget',
      'required'  => false,
    ),

    array(
      'name'    => 'Responsive WordPress Slider - Soliloquy Lite',
      'slug'    => 'soliloquy-lite',
      'required'  => false,
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