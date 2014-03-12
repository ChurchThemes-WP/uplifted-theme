<?php

/**
 * Custom color option array.
 */
$color_options = array(

	"color_schemes" => array(
		"tab" => "general",
		"name" => "color_schemes",
		"title" => "Color Schemes",
		"description" => __( "Select the color scheme you want to use.", 'uplifted' ),
		"section" => "appearance",
		"since" => "1.0",
		"id" => "appearance",
		"type" => "colors",
		"default" => "scheme_1",
		"valid_options" => array(
			"scheme_1" => array(
				"name" => "scheme_1",
				"title" => __( "Color Scheme #1", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#0fcfc5',
					"secondary"	=> '#e8665a',
					"tertiary"	=> '#ece67a',
					"panel"	=> '#fff',
					"background"	=> '#f8f9fb',
				)
			),
			"scheme_2" => array(
				"name" => "scheme_2",
				"title" => __( "Color Scheme #2", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#333333',
					"secondary"	=> '#c3d47f',
					"tertiary"	=> '#999999',
					"panel"	=> '#555555',
					"background"	=> '#333333',
				)
			),
			"scheme_3" => array(
				"name" => "scheme_3",
				"title" => __( "Color Scheme #3", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#F7B928',
					"secondary"	=> '#54786f',
					"tertiary"	=> 'green',
					"panel"	=> '#b1b36b',
					"background"	=> '#1b5469',
				)
			),
			"scheme_4" => array(
				"name" => "scheme_4",
				"title" => __( "Color Scheme #4", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#4e526a',
					"secondary"	=> '#d97159',
					"tertiary"	=> 'green',
					"panel"	=> '#ebe9e7',
					"background"	=> '#f7f6f5',
				)
			),
			"scheme_5" => array(
				"name" => "scheme_5",
				"title" => __( "Color Scheme #5", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#f1e19f',
					"secondary"	=> '#d2d9e1',
					"tertiary"	=> 'pink',
					"panel"	=> '#ebe9e7',
					"background"	=> '#fbfbfb',
				)
			),
			"scheme_6" => array(
				"name" => "scheme_6",
				"title" => __( "Color Scheme #6", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#e65e2d',
					"secondary"	=> '#ae956b',
					"tertiary"	=> '#222',
					"panel"	=> '#efefef',
					"background"	=> '#e1dfe0',
				)
			)
		)
	)
);

/**
 * Register our custom color options in the UpThemes Framework.
 */
register_theme_options($color_options);

/**
 * Add CSS mime type to allowed upload mime types.
 *
 * @since 1.0.0
 */
function uplifted_custom_upload_mimes( $existing_mimes ) {
	// add webm to the list of mime types
	$existing_mimes['css'] = 'text/css';

	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'upload_mimes', 'uplifted_custom_upload_mimes' );

/**
 * Generates Scss variables for custom colors.
 *
 * @since 1.0.0
 */
function uplifted_update_custom_color_vars($variables){

	$up_options = upfw_get_options();

	$upfw_option_parameters = upfw_get_option_parameters();

	$color_scheme = $up_options->color_schemes;

	$valid_options = $upfw_option_parameters['color_schemes']['valid_options'];

	$colors = $valid_options[$color_scheme]['colors'];

	if( is_array($valid_options) ){

		$variables .= '$primary-color:' . $colors['primary'] . ';';
		$variables .= '$secondary-color:' . $colors['secondary'] . ';';
		$variables .= '$tertiary-color:' . $colors['tertiary'] . ';';
		$variables .= '$panel-bg:' . $colors['panel'] . ';';
		$variables .= '$body-bg:' . $colors['background'] . ';';

	}

	return $variables;

}

add_filter('uplifted_style_variables','uplifted_update_custom_color_vars');

/**
 * Success message when CSS file is saved.
 *
 * @since 1.0.0
 */
function uplifted_customizations_saved_notice() {
    ?>
    <div class="updated">
        <p><?php _e( 'Your custom theme styles were saved and a new CSS file was generated successfully.', 'uplifted' ); ?></p>
    </div>
    <?php
}

/**
 * Error message when CSS file cannot be saved.
 *
 * @since 1.0.0
 */
function uplifted_customizations_not_saved_notice() {
	global $uplifted_error;
    ?>
    <div class="error">
    	<?php if( $uplifted_error ) : ?>
    		<p><?php echo $uplifted_error; ?>
    	<?php else: ?>
        	<p><?php _e( 'Your custom theme styles were not saved. Please check your settings and try again.', 'uplifted' ); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Regenerate CSS stylesheet.
 *
 * @since 1.0.0
 */
function uplifted_css_regenerate(){

	try {

		require get_template_directory() . "/includes/scssphp/scss.inc.php";

		$base_import_path = apply_filters('uplifted_base_import_path',get_template_directory() . '/assets/sass/');

		$scss = new scssc();
		$scss->setImportPaths($base_import_path);
		$scss->setFormatter("scss_formatter");

		$style_overrides = apply_filters('uplifted_style_variables','');
		$style_scss_imports = apply_filters('uplifted_style_scss_imports',"@import 'style.scss';");

		$style_content = $scss->compile("
			$style_overrides
			$style_scss_imports
		");

		$old_file = get_option('uplifted-style-override');

		if( $old_file['file'] && file_exists( $old_file['file'] ) ){

			unlink( $old_file['file'] );

		}

		if( $style_scss = wp_upload_bits('style.css',null,$style_content) ){

			$style_scss['date'] = date('Y-m-d');

			$updated = update_option('uplifted-style-override',$style_scss);

			if( isset( $updated ) ){
				add_action( 'admin_notices', 'uplifted_customizations_saved_notice' );
			} else {
				global $uplifted_error;
				$uplifted_error = __('The option could not be saved.','uplifted');
				add_action( 'admin_notices', 'uplifted_customizations_not_saved_notice' );
			}

		} else {
			add_action( 'admin_notices', 'uplifted_customizations_not_saved_notice' );
		}

	} catch (Exception $e) {
		global $uplifted_error;
		$uplifted_error = $e->getMessage();
		add_action( 'admin_notices', 'uplifted_customizations_not_saved_notice' );
	}
}

/**
 * Save new stylesheet when Theme Options page is saved.
 *
 * @since 1.0.0
 */
function uplifted_options_save_regenerate_css(){
	if( $_GET['settings-updated'] == 'true' ) {
		uplifted_css_regenerate();
	}
}

add_action('load-appearance_page_upfw-settings','uplifted_options_save_regenerate_css',1);

/**
 * Save new stylesheet when Theme Customizer is saved.
 *
 * @since 1.0.0
 */
function uplifted_customizer_save_regenerate_css(){
	uplifted_css_regenerate();
}

add_action('customize_save_after','uplifted_customizer_save_regenerate_css',1);

/**
 * Remove default stylesheet and enqueue new one.
 *
 * @since 1.0.0
 */
function uplifted_override_default_styles(){
	if( $custom_style = get_option( 'uplifted-style-override' ) ){
		wp_dequeue_style('uplifted-style');
		wp_enqueue_style('uplifted-style-override',$custom_style['url'],false,$custom_style['date']);
	}
}

add_action('wp_enqueue_scripts','uplifted_override_default_styles',50);

/**
 * Initialize our custom theme option for color schemes.
 *
 * @since 1.0.0
 */
function uplifted_add_custom_theme_options(){
	global $pagenow;

	if( $pagenow == 'themes.php' && $_GET['page'] == 'upfw-settings' ){
		wp_enqueue_style('uplifted-color-schemes', get_template_directory_uri() . '/assets/css/color-schemes.css' );
		upfw_add_custom_field('colors','upfw_colors');
	}
}

add_action('admin_init','uplifted_add_custom_theme_options',1);

/**
 * Sanitize our color scheme input.
 *
 * @todo check against valid options.
 *
 * @since 1.0.0
 */
function upfw_sanitize_color_scheme( $input ) {
	return $input;
}

add_filter( 'upfw_sanitize_colors', 'upfw_sanitize_color_scheme' );

/**
 * Custom color scheme option for UpThemes Framework.
 *
 * @since 1.0.0
 */
function upfw_colors($value,$attr){
    global $wpdb;

    $selected = $value;

?>
<div class="color-schemes">
<?php
	if ( isset( $attr['valid_options'] ) ) :
		$options = $attr['valid_options'];
		foreach( $options as $option ) :
?>
	<label class="radio_image">
		<input type="radio" name="theme_<?php echo esc_attr( upfw_get_current_theme_id() ); ?>_options[<?php echo esc_attr( $attr['name'] ); ?>]" value="<?php echo esc_attr( $option['name'] ); ?>" <?php checked( $option['name'], $selected ); ?>>
		<div class="color-scheme-box table">
			<div class="row"><?php
			foreach( $option['colors'] as $colors => $value ){
				echo "<div class='cell' style='background-color: $value;'></div>";
			}
			?></div>
		</div>
	</label>
<?php
		endforeach;
	else:
		_e("This option has no valid options. Please create valid options as an array inside the UpThemes Framework.","upfw");
	endif;
?>
</div>
<?php
}

/**
 * Register custom colors in the Theme Customizer.
 *
 * @since 1.0.0
 */
function upfw_customize_color_register($wp_customize) {

	/**
	 * Globalize the variable that holds
	 * the Settings Page tab definitions
	 *
	 * @global	array	Settings Page Tab definitions
	 */
	global $up_tabs;

	$upfw_options = upfw_get_options();

	$upfw_option_parameters = upfw_get_option_parameters();

	foreach( $upfw_option_parameters as $option ){

		if( $option['type'] != 'colors' ){
			continue;
		}

		$optionname = $option['name'];
		$theme_id = upfw_get_current_theme_id();
		$optiondb = "theme_{$theme_id}_options[{$optionname}]";
		$option_section_name =  $option['section'];

		$wp_customize->add_setting( $optiondb, array(
			'default'		=> $option['default'],
			'type'			=> 'option',
			'capabilities'	=> 'edit_theme_options'
		) );

		$wp_customize->add_control(
			new UpThemes_Color_Scheme_Radio_Control(
				$wp_customize,
				$option['name'],
				array(
					'label'    => $option['title'],
					'section'  => $option_section_name,
					'settings' => $optiondb,
					'choices'  => upfw_extract_valid_options_radio_colors($option['valid_options'])
				)
			)
		);
	}
}

add_action( 'customize_register', 'upfw_customize_color_register' );

/**
 * Utility function to add color array to customizer option for preview.
 *
 * @since 1.0.0
 */
function upfw_extract_valid_options_radio_colors($options){
	$new_options = array();
	foreach($options as $option){
		$new_options[$option['name']] = array( 'title' => $option['title'], 'colors' => $option['colors'] );
	}
	return $new_options;
}

if ( class_exists( 'WP_Customize_Image_Control' ) && ! class_exists( 'UpThemes_Color_Scheme_Radio_Control' ) ) {

/**
 * Creates Customizer control for radio replacement images fields
 *
 * @since 1.0.0
 */
class UpThemes_Color_Scheme_Radio_Control extends WP_Customize_Control {

		public $type = 'colors_radio';

		public function render_content() {
			if ( empty( $this->choices ) )
				return;

			?>

			<div class="color-schemes">

				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

				<?php
				foreach ( $this->choices as $value => $choice ) {
					?>
					<label class="radio_image" for="<?php echo esc_html( $this->id ); ?>_<?php echo esc_html( $value ); ?>">
						<input id="<?php echo esc_html( $this->id ); ?>_<?php echo esc_html( $value ); ?>" class="image-radio" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_html( $this->id ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
						<div class="color-scheme-box table">
							<div class="row"><?php
							foreach( $choice['colors'] as $colors => $value ){
								echo "<div class='cell' style='background-color: $value;'></div>";
							}
							?></div>
						</div>
					</label>
					<?php
				} // end foreach ?>

			</div>
<?php

        }

		public function enqueue() {
			wp_enqueue_style(
				'uplifted-color-schemes',
				get_template_directory_uri() . '/assets/css/color-schemes.css'
			);
		}

}

}