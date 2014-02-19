<?php
// Add PressTrends Option
add_action('admin_menu', 'upthemes_pt_theme_menu');

function upthemes_pt_theme_menu() {
	add_theme_page('PressTrends', 'PressTrends', 'manage_options', 'upthemes_pt_theme_options', 'upthemes_pt_theme_options');
}

function upthemes_pt_theme_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	?>
	<form action="options.php" method="post">
	<?php settings_fields('upthemes_pt_theme_opt'); ?>
	<?php do_settings_sections('upthemes_pt_top'); ?>
	<p class="submit">
	<input name="Submit" type="submit" class="button button-primary" value="<?php esc_attr_e('Update'); ?>" />
	</p>
	</form>
	<?php
}

// PressTrends Option Settings
add_action('admin_init', 'upthemes_pt_theme_init');

function upthemes_pt_theme_init(){
	register_setting( 'upthemes_pt_theme_opt', 'upthemes_pt_theme_opt');
	add_settings_section('upthemes_pt_top', '', 'upthemes_pt_top_text', 'upthemes_pt_top');
	add_settings_field('upthemes_pt_opt_in', 'Turn on PressTrends', 'upthemes_pt_opt_string', 'upthemes_pt_top', 'upthemes_pt_top');
}

// PressTrends Section Text
function upthemes_pt_top_text() {
	echo '<p style="width:120px;float:left;"><img src="http://www.presstrends.io/_inc/images/presstrends_logo_prple.png" width="100px"/></p><p style="width:500px;float:left;color:#555;padding-top:10px;"><a href="http://www.presstrends.io" title="PressTrends" target="_blank">PressTrends</a> helps theme and plugin developers build better products and provide awesome support by retrieving aggregated stats about their products. PressTrends also provides a <a href="http://wordpress.org/extend/plugins/presstrends/" title="PressTrends Plugin for WordPress" target="_blank">sites plugin</a> that delivers stats on how your site is performing against the web and similar sites like yours with the data we aggregate. <a href="http://www.presstrends.io" title="PressTrends" target="_blank">Learn more about PressTrends</a> and our mission to make the web a better place.</p>';
}

// PressTrends Opt-In Option
function upthemes_pt_opt_string() {
	$current_key = get_option('upthemes_pt_theme_opt');
	$opt = $current_key['activated'];
	if($opt == 'on') {
		echo "<input id='upthemes_pt_opt_in' name='upthemes_pt_theme_opt[activated]' checked type='checkbox' />";
	} else {
		echo "<input id='upthemes_pt_opt_in' name='upthemes_pt_theme_opt[activated]' type='checkbox' />";
	}
}

// Add PressTrends Pointer
function be_password_pointer_enqueue( $hook_suffix ) {
	$enqueue = false;

	$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

	if ( ! in_array( 'activate_presstrends', $dismissed ) ) {
		$enqueue = true;
		add_action( 'admin_print_footer_scripts', 'be_password_pointer_print_admin_bar' );
	}

	if ( $enqueue ) {
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'wp-pointer' );
	}
}

add_action( 'admin_enqueue_scripts', 'be_password_pointer_enqueue' );


function be_password_pointer_print_admin_bar() {

	$pointer_content  = '<h3>' . 'Activate PressTrends' . '</h3>';
	$pointer_content .= '<p>' . 'Help theme authors build better themes and provide awesome support by retrieving aggregated stats.' . '</p>';

?>

	<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready( function($) {
		$('#menu-appearance').pointer({
			content: '<?php echo $pointer_content; ?>',
			position: 'bottom',
			pointerWidth: 300,
			close: function() {
				$.post( ajaxurl, {
						pointer: 'activate_presstrends',
						action: 'dismiss-wp-pointer'
				});
			}
		}).pointer('open');
	});
	//]]>
	</script>

<?php
}

// Insert your PressTrends tracking code block here
function upthemes_pt_theme() {
    // PressTrends Account API Key
    $api_key = '24mjr1pl5kjkzj8w639zm94l701sltupx';
    $auth = '';
    // Start of Metrics
    global $wpdb;
    $data = get_transient( 'upthemes_pt_theme_cache_data' );
    if ( !$data || $data == '' ) {
        $api_base = 'http://api.presstrends.io/index.php/api/sites/add?auth=';
        $url      = $api_base . $auth . '&api=' . $api_key . '';
        $count_posts    = wp_count_posts();
        $count_pages    = wp_count_posts( 'page' );
        $comments_count = wp_count_comments();
        if ( function_exists( 'wp_get_theme' ) ) {
            $theme_data    = wp_get_theme();
            $theme_name    = urlencode( $theme_data->Name );
            $theme_version = $theme_data->Version;
        } else {
            $theme_data = get_theme_data( get_stylesheet_directory() . '/style.css' );
            $theme_name = $theme_data['Name'];
            $theme_version = $theme_data['Version'];
        }
        $all_plugins = get_plugins();
        $plugin_name = '';
        foreach ( $all_plugins as $plugin_file => $plugin_data ) {
            $plugin_name .= $plugin_data['Name'];
            $plugin_name .= '&';
        }
        $posts_with_comments = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type='post' AND comment_count > 0" );
        $avg_time_btw_posts = $wpdb->get_var("SELECT TIMESTAMPDIFF(SECOND, MIN(post_date), MAX(post_date)) / (COUNT(*)-1) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'");
        $avg_time_btw_comments = $wpdb->get_var("SELECT TIMESTAMPDIFF(SECOND, MIN(comment_date), MAX(comment_date)) / (COUNT(*)-1) FROM $wpdb->comments WHERE comment_approved = '1'");
        $data                	= array(
            'url'             	=> base64_encode(site_url()),
            'posts'           	=> $count_posts->publish,
            'pages'           	=> $count_pages->publish,
            'comments'        	=> $comments_count->total_comments,
            'approved'        	=> $comments_count->approved,
            'spam'            	=> $comments_count->spam,
            'between_posts'   	=> $avg_time_btw_posts,
            'between_comments'	=> $avg_time_btw_comments,
            'pingbacks'       	=> $wpdb->get_var( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_type = 'pingback'" ),
            'post_conversion' 	=> ( $count_posts->publish > 0 && $posts_with_comments > 0 ) ? number_format( ( $posts_with_comments / $count_posts->publish ) * 100, 0, '.', '' ) : 0,
            'theme_version'   	=> $theme_version,
            'theme_name'      	=> $theme_name,
            'site_name'       	=> str_replace( ' ', '', get_bloginfo( 'name' ) ),
            'plugins'         	=> count( get_option( 'active_plugins' ) ),
            'plugin'          	=> urlencode( $plugin_name ),
            'wpversion'       	=> get_bloginfo( 'version' ),
            'api_version'	  	=> '2.4',
        );
        foreach ( $data as $k => $v ) {
            $url .= '&' . $k . '=' . $v . '';
        }
        wp_remote_get( $url );
        set_transient( 'upthemes_pt_theme_cache_data', $data, 60 * 60 * 24 );
    }
}

$current_key = get_option('upthemes_pt_theme_opt');
$opt = $current_key['activated'];

if($opt == 'on') {
	add_action('admin_init', 'upthemes_pt_theme');
}
?>