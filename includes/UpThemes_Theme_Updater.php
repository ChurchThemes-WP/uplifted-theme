<?php
/**
 * Theme updater for UpThemes themes.
 *
 * Allows users to activate their license key and receive automatic updates and activates Typekit fonts, when available.
 *
 * @package upthemes_theme_updater
 */

/**
* Create a sub-page for our theme license key
*
* @uses add_submenu_page()
*
* @return void
*
* @since 0.1
*/
function upthemes_sl_license_menu() {
	$page = add_submenu_page('index.php', 'UpThemes Theme Activation', 'UpThemes', 'manage_options', 'upthemes_sl_license', 'upthemes_sl_license_page');
}
add_action('admin_menu', 'upthemes_sl_license_menu');

/**
* Display a license key management page
*
* @uses get_option()
* @uses settings_fields()
* @uses wp_nonce_field()
* @uses submit_button()
*
* @return void
*
* @since 0.1
*/
function upthemes_sl_license_page() {
	$license = get_option( UPTHEMES_LICENSE_KEY );
	$status  = get_option( UPTHEMES_LICENSE_KEY . '_status' );

	?>
	<div class="wrap">
		<h2>UpThemes Activation &amp; Support</h2>

		<p>Your UpThemes license key enables you to receive premium features and email support directly from our development team. If you purchased a theme directly from <a href="https://upthemes.com">UpThemes.com</a>, you should have received an email with your license key included.</p>

		<hr>

		<form method="post" action="options.php">

			<?php settings_fields('upthemes_sl_license'); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="<?php echo UPTHEMES_LICENSE_KEY; ?>" name="<?php echo UPTHEMES_LICENSE_KEY; ?>" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="<?php echo UPTHEMES_LICENSE_KEY; ?>"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php if( $license ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>
								<?php if( $status == 'valid' ) { ?>

									<span style="color:green; line-height: 29px; padding: 0 10px; display: inline-block; background-color: #d9edd6; border-radius: 4px; margin-right: 5px;"><?php _e('active'); ?></span>
									<?php wp_nonce_field( 'upthemes_sl_nonce', 'upthemes_sl_nonce' ); ?>
									<input type="submit" class="button-secondary" name="upthemes_sl_license_deactivate" value="<?php esc_attr_e('Deactivate License'); ?>"/>

									<br><br>

								<?php } else {
									wp_nonce_field( 'upthemes_sl_nonce', 'upthemes_sl_nonce' ); ?>
									<input type="submit" class="button-secondary" name="upthemes_sl_license_activate" value="<?php esc_attr_e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>

						<?php if( $status == 'valid' ) { ?>

							<?php if ( get_theme_mod('typekit-id') ): ?>

							<tr valign="top">
								<th scope="row" valign="top">
									<?php _e( 'Custom Typekit ID' ); ?>
								</th>
								<td>
									<p>Your site currently uses custom fonts from Typekit. <br>Use your own kit ID (ex. jfr3det) by entering it here:</p>
									<br>
									<input id="typekit_id_custom" name="typekit_id_custom" type="text" value="<?php echo get_option( 'typekit_id_custom' ); ?>">
									<button class="secondary button" id="reset-typekit">Clear Kit</button>
									<p class="small" style="visibility: hidden;">Please click <em>Save Changes</em> to reset your Typekit settings.</p>
									<script>
									jQuery( '#reset-typekit' ).on( 'click', function(e){
										jQuery( 'input[id="typekit_id_custom"]' ).val('').parents('form').submit();
									});
									</script>
								</td>
							</tr>

							<?php endif; ?>

							<tr valign="top">
								<th>WordPress Training</th>
								<td>
									<p>Need help learning WordPress? Check out our 20+ WordPress training videos:</p>
									<br>
									<a class="button" href="https://upthemes.com/knowledgebase/wp-101/">Learn WordPress</a>
								</td>
							</tr>

							<tr valign="top">
								<th>Theme Documentation</th>
								<td>
									<p>Need help getting started with <?php echo UPTHEMES_ITEM_NAME; ?>?</p>
									<br>
									<a class="button" href="https://upthemes.com/knowledgebase/">Theme Knowledgebase</a>
								</td>
							</tr>

							<tr valign="top">
								<th>Customer Support</th>
								<td>
									<p>Support hours are Monday - Friday between 8 AM and 5 PM eastern.</p>
									<br>
									<a class="button" href="https://upthemes.com/contact/">Contact Us</a>
								</td>

						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
			<?php submit_button(); ?>

		</form>
	<?php
}

/**
* Register our license key options
*
* @uses register_setting()
*
* @return void
*
* @since 0.1
*/
function upthemes_sl_register_option() {
	// creates our settings in the options table
	register_setting('upthemes_sl_license', UPTHEMES_LICENSE_KEY, 'upthemes_sl_sanitize_license' );
	register_setting('upthemes_sl_license', 'typekit_id_custom', 'sanitize_text_field' );
}
add_action('admin_init', 'upthemes_sl_register_option');

/**
* Sanitize the license key
*
* @uses get_option()
* @uses delete_option()
*
* @return string $new license key
*
* @since 0.1
*/
function upthemes_sl_sanitize_license( $new ) {
	$old = get_option( UPTHEMES_LICENSE_KEY );
	if( $old && $old != $new ) {
		delete_option( UPTHEMES_LICENSE_KEY . '_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

/**
* Activate license key on remote server
*
* We send a remote request to activate the license key
* being used on the current domain.
*
* @uses check_admin_referer()
* @uses get_option()
* @uses delete_option()
* @uses urlencode()
* @uses wp_remote_get()
* @uses add_query_arg()
* @uses is_wp_error()
* @uses json_decode()
* @uses wp_remote_retrieve_body()
* @uses update_option()
*
* @return void
*
* @since 0.1
*/
function upthemes_sl_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['upthemes_sl_license_activate'] ) ) {

		// run a quick security check
		if( ! check_admin_referer( 'upthemes_sl_nonce', 'upthemes_sl_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( UPTHEMES_LICENSE_KEY ) );

		if( !$license || $license == '' ){
			delete_option( UPTHEMES_LICENSE_KEY . '_status' );
			return;
		}

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( UPTHEMES_ITEM_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, UPTHEMES_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		update_option( UPTHEMES_LICENSE_KEY . '_status', $license_data->license );

		if( isset( $license_data->typekit_id ) ){
			set_theme_mod( 'typekit-id', $license_data->typekit_id );
		}

	}
}
add_action('admin_init', 'upthemes_sl_activate_license');


/**
* Deactivate license key on remote server
*
* We send a remote request to deactivate the license key
* being used on the current domain.
*
* @uses check_admin_referer()
* @uses get_option()
* @uses delete_option()
* @uses urlencode()
* @uses wp_remote_get()
* @uses add_query_arg()
* @uses is_wp_error()
* @uses json_decode()
* @uses wp_remote_retrieve_body()
* @uses update_option()
*
* @return void
*
* @since 0.1
*/
function upthemes_sl_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['upthemes_sl_license_deactivate'] ) ) {

		// run a quick security check
		if( ! check_admin_referer( 'upthemes_sl_nonce', 'upthemes_sl_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( UPTHEMES_LICENSE_KEY ) );

		if( !$license || $license == '' ){
			delete_option( UPTHEMES_LICENSE_KEY . '_status' );
			return;
		}

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( UPTHEMES_ITEM_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, UPTHEMES_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' ){
			delete_option( UPTHEMES_LICENSE_KEY . '_status' );
		}

	}
}
add_action('admin_init', 'upthemes_sl_deactivate_license');


/**
* Check license on server
*
* We send a remote request to check the validity of the
* license and update the status based on the response.
*
* @global $wp_version
*
* @uses get_option()
* @uses wp_remote_get()
* @uses add_query_arg()
* @uses is_wp_error()
* @uses json_decode()
* @uses wp_remote_retrieve_body()
*
* @return string valid or invalid
*
* @since 0.1
*/
function upthemes_sl_check_license() {

	global $wp_version;

	$license = trim( get_option( UPTHEMES_LICENSE_KEY ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( UPTHEMES_ITEM_NAME )
	);

	// Call the custom API.
	$response = wp_remote_get( add_query_arg( $api_params, UPTHEMES_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		return 'valid';
		// this license is still valid
	} else {
		return 'invalid';
		// this license is no longer valid
	}
}

function upthemes_sl_enforce_license(){
	$license_status = upthemes_sl_check_license();

	if( $license_status !== 'valid' )
		delete_option( UPTHEMES_LICENSE_KEY . '_status' );
}

function upthemes_sl_license_expired( $plugin_data, $r ) {
		echo 'Your license key has expired. Please <a href="https://upthemes.com">purchase a new license key</a> to enable theme support and automatic updates.';
}

class UpThemes_Theme_Updater {
	private $remote_api_url;
	private $request_data;
	private $response_key;
	private $theme_slug;
	private $license_key;
	private $version;
	private $author;

	function __construct( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'remote_api_url' => 'https://upthemes.com',
			'request_data'   => array(),
			'theme_slug'     => get_template(),
			'item_name'      => '',
			'license'        => '',
			'version'        => '',
			'author'         => ''
		) );
		extract( $args );

		$theme                = wp_get_theme( sanitize_key( $theme_slug ) );
		$this->license        = $license;
		$this->item_name      = $item_name;
		$this->version        = ! empty( $version ) ? $version : $theme->get( 'Version' );
		$this->theme_slug     = sanitize_key( $theme_slug );
		$this->author         = $author;
		$this->remote_api_url = $remote_api_url;
		$this->response_key   = $this->theme_slug . '-update-response';


		add_filter( 'site_transient_update_themes', array( &$this, 'theme_update_transient' ) );
		add_filter( 'delete_site_transient_update_themes', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-update-core.php', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-themes.php', array( &$this, 'delete_theme_update_transient' ) );
		add_action( 'load-themes.php', array( &$this, 'load_themes_screen' ) );
	}

	function load_themes_screen() {
		add_thickbox();
		add_action( 'admin_notices', array( &$this, 'update_nag' ) );
	}

	function update_nag() {
		$theme = wp_get_theme( $this->theme_slug );

		$api_response = get_transient( $this->response_key );

		if( false === $api_response )
			return;

		$update_url = wp_nonce_url( 'update.php?action=upgrade-theme&amp;theme=' . urlencode( $this->theme_slug ), 'upgrade-theme_' . $this->theme_slug );
		$update_onclick = ' onclick="if ( confirm(\'' . esc_js( __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update." ) ) . '\') ) {return true;}return false;"';

		if ( version_compare( $this->version, $api_response->new_version, '<' ) ) {

			echo '<div id="update-nag">';
				printf( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.',
					$theme->get( 'Name' ),
					$api_response->new_version,
					'#TB_inline?width=640&amp;inlineId=' . $this->theme_slug . '_changelog',
					$theme->get( 'Name' ),
					$update_url,
					$update_onclick
				);
			echo '</div>';
			echo '<div id="' . $this->theme_slug . '_' . 'changelog" style="display:none;">';
				echo wpautop( $api_response->sections['changelog'] );
			echo '</div>';
		}
	}

	function theme_update_transient( $value ) {
		$update_data = $this->check_for_update();
		if ( $update_data ) {
			$value->response[ $this->theme_slug ] = $update_data;
		}
		return $value;
	}

	function delete_theme_update_transient() {
		delete_transient( $this->response_key );
	}

	function check_for_update() {

		$theme = wp_get_theme( $this->theme_slug );

		$update_data = get_transient( $this->response_key );
		if ( false === $update_data ) {
			$failed = false;

			if( empty( $this->license ) )
				return false;

			$api_params = array(
				'edd_action'    => 'get_version',
				'license'       => $this->license,
				'name'          => $this->item_name,
				'slug'          => $this->theme_slug,
				'author'        => $this->author
			);

			$response = wp_remote_post( $this->remote_api_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			// make sure the response was successful
			if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
				$failed = true;
			}

			$update_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( ! is_object( $update_data ) ) {
				$failed = true;
			}

			// if the response failed, try again in 30 minutes
			if ( $failed ) {
				$data = new stdClass;
				$data->new_version = $this->version;
				set_transient( $this->response_key, $data, strtotime( '+30 minutes' ) );
				return false;
			}

			// if the status is 'ok', return the update arguments
			if ( ! $failed ) {
				$update_data->sections = maybe_unserialize( $update_data->sections );
				set_transient( $this->response_key, $update_data, strtotime( '+12 hours' ) );
			}
		}

		if ( version_compare( $this->version, $update_data->new_version, '>=' ) ) {
			return false;
		}

		return (array) $update_data;
	}
}

/**
 * Throws up a pointer to remind users to activate theme license.
 */
function upthemes_license_advisor(){


	$license = get_option( UPTHEMES_LICENSE_KEY );
	$status  = get_option( UPTHEMES_LICENSE_KEY . '_status' );

	if( $license && $status === 'valid' )
		return;

	add_action( 'admin_enqueue_scripts', 'upthemes_admin_pointers_header' );

}

add_action( 'admin_init', 'upthemes_license_advisor' );

/**
 * Adds scripts needed for admin pointers
 */
function upthemes_admin_pointers_header() {
	 if ( upthemes_admin_pointers_check() ) {
			add_action( 'admin_print_footer_scripts', 'upthemes_admin_pointers_footer' );

			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_style( 'wp-pointer' );
	 }
}

/**
 * Check if admin pointers are active
 */
function upthemes_admin_pointers_check() {
	 $admin_pointers = upthemes_admin_pointers();
	 foreach ( $admin_pointers as $pointer => $array ) {
			if ( $array['active'] )
				 return true;
	 }
}

/**
 * Print footer script for custom admin pointers
 */
function upthemes_admin_pointers_footer() {
	 $admin_pointers = upthemes_admin_pointers();
	 ?>
<script type="text/javascript">
/* <![CDATA[ */
( function($) {
	 <?php
	 foreach ( $admin_pointers as $pointer => $array ) {
			if ( $array['active'] ) {
				 ?>
				 $( '<?php echo $array['anchor_id']; ?>' ).pointer( {
						content: '<?php echo $array['content']; ?>',
						position: {
						edge: '<?php echo $array['edge']; ?>',
						align: '<?php echo $array['align']; ?>'
				 },
						close: function() {
							 $.post( ajaxurl, {
									pointer: '<?php echo $pointer; ?>',
									action: 'dismiss-wp-pointer'
							 } );
						}
				 } ).pointer( 'open' );
				 <?php
			}
	 }
	 ?>
} )(jQuery);
/* ]]> */
</script>
	 <?php
}

/**
 * Creates our admin pointers.
 */
function upthemes_admin_pointers() {

	global $current_screen;

	$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	$version   = '1_0'; // replace all periods in 1.0 with an underscore
	$prefix    = 'upthemes_admin_pointers' . $version . '_';
	$anchor_id = '#menu-dashboard';
	$message   = '<h3>' . __( 'Activate Theme License' ) . '</h3><p>' . sprintf( __( 'Thanks for installing the %s. Please <a href="%s">activate your theme license</a> to enable special features and customer support.' ), UPTHEMES_ITEM_NAME, 'themes.php?page=upthemes_sl_license' ) . '</p>';

	if( $current_screen->id === 'dashboard_page_upthemes_sl_license' ){

		$license = get_option( UPTHEMES_LICENSE_KEY );
		$status  = get_option( UPTHEMES_LICENSE_KEY . '_status' );

		if( isset( $license ) && $status === 'valid' )
			return array();

		$renewal_url = 'https://upthemes.com/themes/';

		if( defined( 'UPTHEMES_RENEWAL_URL' ) )
			$renewal_url = UPTHEMES_RENEWAL_URL;

		$anchor_id = '#uplifted_theme';
		$message   = '<h3>' . __( 'Enter Your Theme License' ) . '</h3><p>' . sprintf( __( 'Add your theme license key here to activate features and support for %s. You can find your license key in your email receipt or <a href="%s">purchase one here</a>.' ), UPTHEMES_ITEM_NAME, $renewal_url ) . '</p>';

	}

	return array(
		$prefix . 'new_items' => array(
			'content' => $message,
			'anchor_id' => $anchor_id,
			'edge' => 'bottom',
			'align' => 'left',
			'active' => ( ! in_array( $prefix . 'new_items', $dismissed ) )
		),
	);
}
