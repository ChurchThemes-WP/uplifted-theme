<?php

// Define variables for our theme updates
define('UPTHEMES_ITEM_NAME', 'Uplifted Theme');
define('UPTHEMES_STORE_URL', 'http://upthemes.com');

// Grab some necessary PHP includes
include_once('options/options.php');							// UpThemes Framework
include_once('inc/theme-options.php');							// Load theme options specific to this theme
include_once('inc/custom-header.php');							// Custom header setup
//include_once('inc/audiotheme-shim.php');						// AudioTheme support
//include_once('inc/audiotheme-player.php');						// AudioTheme support
include_once('inc/foundation-navbar.php');						// Foundation navbar
include_once('inc/responsive-slider/responsive-slider.php');				// Responsive slider
include_once('inc/presstrends.php');               					// PressTrends
include_once('inc/church-framework/framework.php');					// Church Framework

if ( !class_exists( 'UpThemes_Theme_Updater' ) ) {
	// Load our custom theme updater
	include( 'inc/UpThemes_Theme_Updater.php' );
}

function uplifted_add_ctc_support() {

    /**
     * Plugin Support
     *
     * Tell plugin theme supports it. This leaves all features disabled so they can
     * be enabled explicitly below. When support not added, all features are revealed
     * so user can access content (in case switched to an unsupported theme).
     *
     * This also removes the plugin's "not using compatible theme" message.
     */

    add_theme_support( 'church-theme-content' );

    /**
     * Plugin Features
     *
     * When array of arguments not given, plugin defaults are used (enabling all taxonomies
     * and fields for feature). It is recommended to explicitly specify taxonomies and
     * fields used by theme so plugin updates don't reveal unsupported features.
     */
    add_theme_support( 'ctc-sermons' );
    add_theme_support( 'ctc-events' );
    add_theme_support( 'ctc-people' );
    add_theme_support( 'ctc-locations' );

}

add_action( 'after_setup_theme', 'uplifted_add_ctc_support' );

/**
 * Set up our theme
 *
 * This function allows us to initialize core components of our theme,
 * include localization, menus, feed links, post formats, and custom
 * backgrounds and header styles.
 *
 */
function uplifted_theme_setup() {

  if ( ! isset( $content_width ) ) $content_width = 560;

  add_theme_support( 'nav-menus' );

	load_theme_textdomain( 'uplifted', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
  if( function_exists('register_nav_menu') )
  	register_nav_menu( 'main_menu', __( 'Main Menu','uplifted' ) );
    register_nav_menu( 'secondary_menu', __( 'Secondary Menu','uplifted' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'video', 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	// Add support for custom backgrounds
	add_theme_support('custom-background');

	add_editor_style();

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	add_image_size('featured-image',2000,600,true);

}

add_action( 'after_setup_theme', 'uplifted_theme_setup' );

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

  wp_enqueue_script( 'plugins', get_template_directory_uri() . '/scripts/plugins.js', array('jquery') );
  wp_enqueue_script( 'init', get_template_directory_uri() . '/scripts/init.js', array('plugins'), false, true );
  wp_enqueue_script( 'foundation', get_template_directory_uri() . '/scripts/foundation.js', array('jquery') );
  wp_enqueue_script( 'foundation-topbar', get_template_directory_uri() . '/scripts/foundation.topbar.js', array('jquery') );
  wp_enqueue_script( 'jquery-jplayer' );
  wp_enqueue_script( 'jquery-jplayer-playlist' );

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

add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
    $GLOBALS['current_theme_template'] = basename($t);
    return $t;
}

function get_current_template( $echo = false ) {
    if( !isset( $GLOBALS['current_theme_template'] ) )
        return false;
    if( $echo )
        echo $GLOBALS['current_theme_template'];
    else
        return $GLOBALS['current_theme_template'];
}

/**
 * The Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post.
 *
 * @since 2.5.0
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 */

//deactivate WordPress function
remove_shortcode('gallery', 'gallery_shortcode');

//activate custom function
add_shortcode('gallery', 'uplifted_gallery_shortcode');

//custom gallery function
function uplifted_gallery_shortcode($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr, 'gallery'));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$valid_tags = wp_kses_allowed_html( 'post' );
	$itemtag = 'div';
	$captiontag = 'div';
	$icontag = 'span';

	$columns = intval($columns);
	/* $itemwidth = $columns > 0 ? floor(100/$columns) : 100; */
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	$output = $gallery_div;

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		if ( ! empty( $attr['link'] ) && 'file' === $attr['link'] )
			$image_output = wp_get_attachment_link( $id, $size, false, false );
		elseif ( ! empty( $attr['link'] ) && 'none' === $attr['link'] )
			$image_output = wp_get_attachment_image( $id, $size, false );
		else
			$image_output = wp_get_attachment_link( $id, $size, true, false );

		$image_meta  = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) )
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
	}

	$output .= "
		</div>\n";

	return $output;
}

function uplifted_set_rtl($classes){
	$options = upfw_get_options();

	if( $options->is_rtl == 'yes' )
		$classes[] = 'is-rtl';

	return $classes;
}

add_filter('body_class','uplifted_set_rtl');
