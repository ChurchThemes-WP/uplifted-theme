<?php

  $options = array(
    "layout" => array(
    	"tab" => "general",
    	"name" => "layout",
    	"title" => "Theme Layout",
    	"description" => __( "Select the layout you want to use.", 'uplifted' ),
    	"section" => "appearance",
    	"since" => "1.0",
      "id" => "appearance",
      "type" => "radio_image",
      "default" => "default",
      "valid_options" => array(
      	"default" => array(
      		"name" => "default",
      		"image" => upfw_get_theme_options_directory_uri() . "images/layouts/right_sidebar.gif",
      		"title" => __( "Sidebar on the Right", 'uplifted' )
      	),
        "reversed" => array(
        	"name" => "reversed",
      		"image" => upfw_get_theme_options_directory_uri() . "images/layouts/left_sidebar.gif",
        	"title" => __( "Sidebar on the Left", 'uplifted' )
        ),
        "single_column" => array(
        	"name" => "single_column",
      		"image" => upfw_get_theme_options_directory_uri() . "images/layouts/no_sidebar.gif",
        	"title" => __( "No Sidebar", 'uplifted' )
        )
      )
    ),
    "is_rtl" => array(
    "tab" => "general",
    "name" => "is_rtl",
    "title" => "Enable RTL?",
    "description" => __( "Is this site in a right-to-left language?", 'uplifted' ),
    "section" => "appearance",
    "since" => "1.0",
  	"id" => "appearance",
  	"type" => "select",
   	"default" => "no",
  	"valid_options" => array(
      	"no" => array(
        	"name" => "no",
        	"title" => __( "No", 'uplifted' )
        ),
        "yes" => array(
          "name" => "yes",
          "title" => __( "Yes", 'uplifted' )
        )
      )
    ),
    'favicon' => array(
      'tab' => 'general',
      "name" => "favicon",
      "title" => "Favicon",
      'description' => __( 'Select a 16x16 favicon for your site.', 'uplifted' ),
      'section' => 'appearance',
      'since' => '1.0',
      "id" => "appearance",
      "type" => "image"
    )
  );

register_theme_options($options);

$general = array(
	"name" => "general",
	"title" => __("General",'uplifted'),
	'sections' => array(
    'appearance' => array(
    	'name' => 'appearance',
    	'title' => __( 'Appearance', 'uplifted' ),
    	'description' => __( 'Modify the visual appearance of the theme.','uplifted' )
    ),
    'text' => array(
      'name' => 'text',
      'title' => __( 'Text', 'uplifted' ),
      'description' => __( 'Modify text parts displayed within the theme.','uplifted' )
    )
	)
);

register_theme_option_tab($general);

$options = array(

  "footertext" => array(
  	"tab" => "general",
  	"name" => "footertext",
  	"title" => "Footer Text",
  	"description" => __( "Text to be displayed in the footer.", 'uplifted' ),
  	"section" => "text",
  	"since" => "1.0",
      "id" => "text",
      "type" => "textarea",
      "default" => "Copyright ".date('Y')." ".get_bloginfo('name').". All Rights Reserved."
  )
);

register_theme_options($options);
