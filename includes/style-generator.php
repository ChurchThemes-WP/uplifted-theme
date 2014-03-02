<?php

function uplifted_custom_upload_mimes( $existing_mimes ) {
	// add webm to the list of mime types
	$existing_mimes['css'] = 'text/css';

	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'upload_mimes', 'uplifted_custom_upload_mimes' );

function uplifted_css_redirect(){
    if( $_REQUEST['sass'] == 'style.css' ) {

		require get_template_directory() . "/inc/scssphp/scss.inc.php";

		$base_import_path = get_template_directory() . '/assets/sass/';

		try {

			$scss = new scssc();
			$scss->setImportPaths($base_import_path);
			$scss->setFormatter("scss_formatter_compressed");

			$style_overrides = apply_filters('uplifted-style-variables','');

			$style_content = $scss->compile("
				$style_overrides
				@import 'style.scss';
			");

			$style_scss = wp_upload_bits('style.css',null,$style_content);

			echo $style_scss['url'];
			update_option('uplifted-style-override',$style_scss['url']);

		} catch (Exception $e) {
		    echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

        exit();
    }
}
add_action( 'template_redirect', 'uplifted_css_redirect', 2 );

function uplifted_override_default_styles(){
	if( $custom_style = get_option( 'uplifted-style-override' ) ){
		wp_dequeue_style('uplifted-style');
		wp_enqueue_style('uplifted-style-override',$custom_style);
	}
}

add_action('wp_enqueue_scripts','uplifted_override_default_styles',50);



$general = array(
	"name" => "colors",
	"title" => __("Colors",'uplifted'),
	'sections' => array(
		'appearance' => array(
			'name' => 'appearance',
			'title' => __( 'Appearance', 'uplifted' ),
			'description' => __( 'Modify the visual appearance of the theme.','uplifted' )
		)
	)
);

register_theme_option_tab($general);
