<?php

  $options = array(
    "layout" => array(
    	"tab" => "general",
    	"name" => "layout",
    	"title" => "Theme Layout",
    	"description" => __( "Select the layout you want to use.", "amplify" ),
    	"section" => "appearance",
    	"since" => "1.0",
      "id" => "appearance",
      "type" => "radio_image",
      "default" => "default",
      "valid_options" => array(
      	"default" => array(
      		"name" => "default",
      		"image" => upfw_get_theme_options_directory_uri() . "images/layouts/right_sidebar.gif",
      		"title" => __( "Sidebar on the Right", "amplify" )
      	),
        "reversed" => array(
        	"name" => "reversed",
      		"image" => upfw_get_theme_options_directory_uri() . "images/layouts/left_sidebar.gif",
        	"title" => __( "Sidebar on the Left", "amplify" )
        ),
        "single_column" => array(
        	"name" => "single_column",
      		"image" => upfw_get_theme_options_directory_uri() . "images/layouts/no_sidebar.gif",
        	"title" => __( "No Sidebar", "amplify" )
        )
      )
    ),
    "is_rtl" => array(
        "tab" => "general",
        "name" => "is_rtl",
        "title" => "Enable RTL?",
        "description" => __( "Is this site in a right-to-left language?", "amplify" ),
        "section" => "appearance",
        "since" => "1.0",
	"id" => "appearance",
	"type" => "select",
 	"default" => "no",
	"valid_options" => array(
        	"no" => array(
                	"name" => "no",
                	"title" => __( "No", "amplify" )
		),
                "yes" => array(
                        "name" => "yes",
                        "title" => __( "Yes", "amplify" )
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
    ),
    'jukebox' => array(
      'tab' => 'general',
      "name" => "jukebox",
      "title" => "Jukebox Tracks",
      'description' => __( 'Select tracks for your jukebox player.', 'uplifted' ),
      'section' => 'audiotheme',
      'since' => '1.0',
      "id" => "audiotheme",
      "type" => "jukebox"
    )
  );

register_theme_options($options);

$general = array(
	"name" => "general",
	"title" => __("General","amplify"),
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
    ),
    'audiotheme' => array(
      'name' => 'audiotheme',
      'title' => __( 'AudioTheme Settings', 'uplifted' ),
      'description' => __( 'Customized options for your AudioTheme player.','uplifted' )
    )
	)
);

register_theme_option_tab($general);

$options = array(

  "footertext" => array(
  	"tab" => "general",
  	"name" => "footertext",
  	"title" => "Footer Text",
  	"description" => __( "Text to be displayed in the footer.", "amplify" ),
  	"section" => "text",
  	"since" => "1.0",
      "id" => "text",
      "type" => "textarea",
      "default" => "Copyright ".date('Y')." ".get_bloginfo('name').". All Rights Reserved."
  )

);

register_theme_options($options);
