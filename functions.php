<?php

// Define variables for our theme updates
define('UPTHEMES_ITEM_NAME', 'Uplifted Theme');
define('UPTHEMES_STORE_URL', 'http://upthemes.com');

// Grab some necessary PHP includes
include_once('framework/framework.php');                            // Church Framework
include_once('includes/support-ctc.php');                           // Church Framework support declarations
include_once('includes/support-framework.php');                     // Church Framework support
include_once('includes/support-wp.php');                            // WordPress feature support
include_once('includes/icons.php');                                 // Icons
include_once('includes/sidebars.php');                              // Sidebars
include_once('includes/loop-after-content.php');                    // Loop after content
include_once('includes/content-types.php');                         // Content types
include_once('includes/gallery.php');                               // Gallery filter
include_once('includes/custom-header.php');                         // Custom header setup
include_once('includes/foundation-navbar.php');                     // Foundation navbar
include_once('includes/responsive-slider/responsive-slider.php');   // Responsive slider
include_once('includes/presstrends.php');                           // PressTrends
include_once('includes/template-tags.php');                         // Template Tags
include_once('options/options.php');                                // UpThemes Framework
include_once('includes/theme-options.php');                         // Load theme options specific to this theme

if ( !class_exists( 'UpThemes_Theme_Updater' ) ) {
	// Load our custom theme updater
	include( 'includes/UpThemes_Theme_Updater.php' );
}

if ( ! isset( $content_width ) ){
  $content_width = 560;
}

function uplifted_theme_update_check(){
	$upthemes_license = trim( get_option( 'upthemes_sl_license_key' ) );

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
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function uplifted_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'uplifted' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'uplifted_wp_title', 10, 2 );

/**
 * Google Fonts Implementation
 *
 * @package WordPress
 * @subpackage Uplifted
 * @since 1.0.0
 */

/**
 * Register Google Fonts
 */
function uplifted_register_fonts() {
  $protocol = is_ssl() ? 'https' : 'http';
  wp_register_style( 'default-font', "$protocol://fonts.googleapis.com/css?family=Open+Sans:300,500,700" );
}
add_action( 'init', 'uplifted_register_fonts' );

/**
 * Enqueue Google Fonts on Front End
 */
function uplifted_fonts() {
  wp_enqueue_style( 'default-font' );
}
add_action( 'wp_enqueue_scripts', 'uplifted_fonts' );

/**
 * Enqueue Google Fonts on Custom Header Page
 */
function uplifted_admin_fonts( $hook_suffix ) {
  if ( 'appearance_page_custom-header' != $hook_suffix )
    return;

  wp_enqueue_style( 'default-font' );
}
add_action( 'admin_enqueue_scripts', 'uplifted_admin_fonts' );

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
  		'id'            => 'footer-1',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</div>',
  		'before_title'  => '<h4>',
  		'after_title'   => '</h4>' ));

  register_sidebar( array(
  		'name'          => __('Footer Second Column','uplifted'),
  		'id'            => 'footer-2',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</div>',
  		'before_title'  => '<h4>',
  		'after_title'   => '</h4>' ));

  register_sidebar( array(
  		'name'          => __('Footer Third Column','uplifted'),
  		'id'            => 'footer-3',
  		'before_widget' => '<div id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</div>',
  		'before_title'  => '<h4>',
  		'after_title'   => '</h4>' ));
}

add_action('widgets_init','uplifted_widgets_init');

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function uplifted_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'uplifted_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function uplifted_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'uplifted' ) . '</a>';
}
add_filter( 'the_content_more_link', 'uplifted_continue_reading_link' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and uplifted_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function uplifted_auto_excerpt_more( $more ) {
	return ' &hellip;' . uplifted_continue_reading_link();
}
add_filter( 'excerpt_more', 'uplifted_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function uplifted_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= uplifted_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'uplifted_custom_excerpt_more' );

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
 * Prints the custom CSS from the theme options panel
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
      <?php the_tags('&bull; Tags: ', ', ', '<br />'); ?>

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