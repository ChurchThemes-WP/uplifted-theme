<?php

$appearance = array(
	"name" => "appearance",
	"title" => __("Appearance",'uplifted'),
	'sections' => array(
		'colors' => array(
			'name' => 'colors',
			'title' => __( 'Colors', 'uplifted' ),
			'description' => __( 'Custom colors for this theme.','uplifted' )
		)
	)
);

register_theme_option_tab($appearance);

/**
 * Custom color option array.
 */
$color_options = array(
	"enable_custom_styles" => array(
		"tab" => "appearance",
		"name" => "enable_custom_styles",
		"title" => "Enable Custom Styles",
		"description" => __( "Do you want to enable custom styles?", 'uplifted' ),
		"section" => "colors",
		"since" => "1.0",
		"id" => "colors",
		"type" => "select",
		"default" => "yes",
		"valid_options" => array(
			"yes" => array(
				"name" => "yes",
				"title" => __( "Yes", 'uplifted' )
			),
			"no" => array(
				"name" => "no",
				"title" => __( "No", 'uplifted' )
			),
		),
	),
	"color_scheme_toggle" => array(
		"tab" => "appearance",
		"name" => "color_scheme_toggle",
		"title" => "Custom Color Type",
		"description" => __( "Do you want to select a pre-defined color scheme or define your own colors?", 'uplifted' ),
		"section" => "colors",
		"since" => "1.0",
		"id" => "colors",
		"type" => "radio",
		"default" => "yes",
		"valid_options" => array(
			"scheme" => array(
				"name" => "scheme",
				"title" => __( "Pre-defined color schemes", 'uplifted' )
			),
			"hex" => array(
				"name" => "hex",
				"title" => __( "My own colors", 'uplifted' )
			),
		),
	),
);

/**
 * Register our custom color options in the UpThemes Framework.
 */
register_theme_options($color_options);


/**
 * Custom color option array.
 */
$custom_styles = array(
	"color_schemes" => array(
		"tab" => "appearance",
		"name" => "color_schemes",
		"title" => "Color Schemes",
		"description" => __( "Select the color scheme you want to use.", 'uplifted' ),
		"section" => "colors",
		"since" => "1.0",
		"id" => "colors",
		"type" => "colors",
		"default" => "scheme_1",
		"valid_options" => array(
			"scheme_1" => array(
				"name" => "scheme_1",
				"title" => __( "Color Scheme #1", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#0fcfc5',
					"secondary"	=> '#e8665a',
					"panel"	=> '#ffffff',
					"background"	=> '#f8f9fb',
				)
			),
			"scheme_2" => array(
				"name" => "scheme_2",
				"title" => __( "Color Scheme #2", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#acbb70',
					"secondary"	=> '#c3d47f',
					"panel"	=> '#555555',
					"background"	=> '#333333',
				)
			),
			"scheme_3" => array(
				"name" => "scheme_3",
				"title" => __( "Color Scheme #3", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#97e2b1',
					"secondary"	=> '#e55b2c',
					"panel"	=> '#fbfbfb',
					"background"	=> '#232e2e',
				)
			),
			"scheme_4" => array(
				"name" => "scheme_4",
				"title" => __( "Color Scheme #4", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#4e526a',
					"secondary"	=> '#d97159',
					"panel"	=> '#ebe9e7',
					"background"	=> '#f7f6f5',
				)
			),
			"scheme_5" => array(
				"name" => "scheme_5",
				"title" => __( "Color Scheme #5", 'uplifted' ),
				"colors" => array(
					"primary"	=> '#e65e2d',
					"secondary"	=> '#ae956b',
					"panel"	=> '#efefef',
					"background"	=> '#e1dfe0',
				)
			)
		)
	)
);

register_theme_options($custom_styles);

/**
 * Custom color option array.
 */
$custom_hex_colors = array(
	"primary_color" => array(
		"tab" => "appearance",
		"name" => "primary_color",
		"title" => "Primary Color",
		"description" => __( "The primary color will be used for link and button highlights, accents, and active states.", 'uplifted' ),
		"section" => "colors",
		"since" => "1.0",
		"id" => "colors",
		"type" => "color",
		"default" => "0fcfc5",
	),
	"secondary_color" => array(
		"tab" => "appearance",
		"name" => "secondary_color",
		"title" => "Secondary Color",
		"description" => __( "The secondary color will be used to signify clickable items like links, headings, and buttons.", 'uplifted' ),
		"section" => "colors",
		"since" => "1.0",
		"id" => "colors",
		"type" => "color",
		"default" => "e8665a",
	),
	"panel_color" => array(
		"tab" => "appearance",
		"name" => "panel_color",
		"title" => "Panel Color",
		"description" => __( "The panel color is the background color of the navigation bar, widgets, and the main content area. If the Panel color is set to a light color the text inside will be dark, if the Panel color is set to a darker color the text inside will be white.", 'uplifted' ),
		"section" => "colors",
		"since" => "1.0",
		"id" => "colors",
		"type" => "color",
		"default" => "ffffff",
	),
	"background_color" => array(
		"tab" => "appearance",
		"name" => "background_color",
		"title" => "Background Color",
		"description" => __( "Select your background color for this site.", 'uplifted' ),
		"section" => "colors",
		"since" => "1.0",
		"id" => "colors",
		"type" => "color",
		"default" => "f8f9fb",
	),
);

register_theme_options($custom_hex_colors);

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

	if( $up_options->enable_custom_styles == 'yes' && $up_options->color_scheme_toggle != 'hex' ){

		$valid_options = $upfw_option_parameters['color_schemes']['valid_options'];

		$colors = $valid_options[$color_scheme]['colors'];

		if( is_array($valid_options) ){

			$variables .= '$primary-color:' . $colors['primary'] . ';';
			$variables .= '$secondary-color:' . $colors['secondary'] . ';';
			$variables .= '$panel-bg:' . $colors['panel'] . ';';
			$variables .= '$body-bg:' . $colors['background'] . ';';

		}

	} else if( $up_options->enable_custom_styles == 'yes' && $up_options->color_scheme_toggle == 'hex' ){

		$variables .= '$primary-color:' . $up_options->primary_color . ';';
		$variables .= '$secondary-color:' . $up_options->secondary_color . ';';
		$variables .= '$panel-bg:' . $up_options->panel_color . ';';
		$variables .= '$body-bg:' . $up_options->background_color . ';';

	}

	return $variables;

}

add_filter('uplifted_style_variables','uplifted_update_custom_color_vars');

function uplifted_customize_register($wp_customize) {
	$up_options = upfw_get_options();

	if ( $wp_customize->is_preview() && ! is_admin() ){
	    add_action( 'wp_footer', 'uplifted_customize_preview', 21);
	}

}
add_action( 'customize_register', 'uplifted_customize_register' );

function uplifted_customize_preview(){
	$up_options = upfw_get_options();

	if( $up_options->enable_custom_styles == 'yes' ){
		$styles = uplifted_css_regenerate('inline');
		echo '<style type="text/css" id="custom-styles">';
		echo $styles;
		echo '</style>';
	}

	echo '<script type="text/javascript">';
	echo 'parent.preview_loaded();';
	echo '</script>';
}

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
function uplifted_css_regenerate( $format = 'file' ){

	try {

		require get_template_directory() . "/includes/scssphp/scss.inc.php";
		require get_template_directory() . "/includes/scssphp-compass/compass.inc.php";

		$base_import_path = apply_filters('uplifted_base_import_path',get_template_directory() . '/assets/sass/');

		$scss = new scssc();
		$scss->setImportPaths($base_import_path);

		new scss_compass($scss);

		$scss->setFormatter("scss_formatter");

		$style_overrides = apply_filters('uplifted_style_variables','');
		$style_scss_imports = apply_filters('uplifted_style_scss_imports',"@import 'style.scss';");

		$style_content = $scss->compile("
			$style_overrides
			$style_scss_imports
		");

		$old_file = get_option('uplifted-style-override');

		if( $format === 'file' ){

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

		} elseif( $format === 'inline' ) {
			return $style_content;
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
	$up_options = upfw_get_options();

	if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' && $up_options->enable_custom_styles == 'yes' ) {
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
	$up_options = upfw_get_options();

	if( $up_options->enable_custom_styles == 'yes' ){
		uplifted_css_regenerate();
	}
}

add_action('customize_save_after','uplifted_customizer_save_regenerate_css',1);

/**
 * Remove default stylesheet and enqueue new one.
 *
 * @since 1.0.0
 */
function uplifted_override_default_styles(){
	$up_options = upfw_get_options();
	$custom_style = get_option( 'uplifted-style-override' );

	if( $up_options->enable_custom_styles == 'yes' ){
		wp_dequeue_style('uplifted-style');
		wp_enqueue_style('uplifted-style-override',$custom_style['url'],false,$custom_style['date']);
	}
}

add_action('wp_enqueue_scripts','uplifted_override_default_styles',9999);

/**
 * Initialize our custom theme option for color schemes.
 *
 * @since 1.0.0
 */
function uplifted_add_custom_theme_options(){
	global $pagenow;

	if( $pagenow == 'themes.php' && !empty($_GET['page']) && $_GET['page'] == 'upfw-settings' ){
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

			wp_enqueue_script(
				'uplifted-customize-theme',
				get_template_directory_uri() . '/assets/js/customize-theme.js'
			);
		}

}

}