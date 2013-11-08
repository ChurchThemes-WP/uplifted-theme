<?php

/**
 * Initialize our custom theme option for the jukebox player.
 *
 * @since 1.0.0
 */
function amplify_add_custom_theme_options(){
	global $pagenow;
	if( $pagenow == 'themes.php' && $_GET['page'] == 'upfw-settings' ){
		wp_enqueue_script('chosen', get_template_directory_uri() . '/inc/chosen/chosen.jquery.js', array('jquery') );
		wp_enqueue_style('chosen', get_template_directory_uri() . '/inc/chosen/chosen.css' );
		upfw_add_custom_field('jukebox','upfw_jukebox');
	}
}

add_action('admin_init','amplify_add_custom_theme_options',1);

/**
 * Get all tracks from database.
 *
 * @since 1.0.0
 */
function amplify_get_all_tracks(){
        $posts = get_posts( array(
                'post_type'   => 'audiotheme_track',
                'orderby'     => 'title',
                'order'       => 'asc',
                'numberposts' => -1,
                'meta_query'  => array(
                        array(
                                'key'     => '_audiotheme_file_url',
                                'value'   => '',
                                'compare' => '!=',
                        ),
                )
        ) );

        $tracks = array();

        foreach($posts as $track){
                $tracks[ $track->ID ] = $track->post_title;
        }

        return $tracks;
}

/**
 * Get the list of Jukebox tracks.
 *
 * Determines which tracks should be included in the Jukebox based on the
 * theme options, enqueues them for output in the footer, and returns the list
 * as an array of titles and file urls.
 *
 * @since 1.0.0
 *
 * @return array|bool List of jukebox tracks or false.
 */
function amplify_get_jukebox_tracks() {
	$options = upfw_get_options();
	$tracks = $options->jukebox;

	$track_count = count( $tracks );

	if ( $track_count ) {

		// Select the tracks.
		$posts = get_posts( array(
			'post_type'   => 'audiotheme_track',
			'numberposts' => -1,
			'post__in'    => $tracks,
			'orderby'     => 'post__in',
		) );

	}

	unset($tracks);

	// Transform the tracks into a more usable format.
	if ( $posts = apply_filters( 'amplify_jukebox_tracks', $posts ) ) {
		foreach( $posts as $post ) {
			$tracks[] = audiotheme_prepare_track_for_js( $post->ID );
		}
	}

	// Enqueue the track for data output in the footer.
	if ( ! empty( $tracks ) ) {
		enqueue_audiotheme_tracks( $tracks, 'jukebox' );
	}

	return ( ! empty( $tracks ) ) ? $tracks : false;
}

/**
 * Custom Jukebox option for UpThemes Framework.
 *
 * @since 1.0.0
 */
function upfw_jukebox($value,$attr){
    global $wpdb;

    $tracks = amplify_get_all_tracks();
?>
	<select style="width: 320px; height: 80px;" class="chosen" multiple name="theme_<?php echo upfw_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>][]" id="theme_<?php echo upfw_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>][]">
	    <?php
	    $selected = '';
	    foreach($tracks as $id => $track){
	        if( in_array($id,$value) ) {
				$selected = " selected='selected'";
	        }
	        echo "<option value='$id'$selected>$track</option>";
	        unset($selected);
	    }
	    ?>
	</select>
	<script>
	jQuery(document).ready(function($){
		$('.chosen').chosen();
	});
	</script>
<?php
}

/**
 * Grab template for jukebox player.
 *
 * @since 1.0.0
 */
function amplify_audio_player(){
	get_template_part('audiotheme/parts/jukebox');
}

/**
 * Open the custom wrapper HTML for AudioTheme.
 *
 * @since 1.0.0
 */
function amplify_audiotheme_open($content){ ?>
  <div id="main">
    <div id="content">
      <div class="inner">
  <?php
}

add_action('audiotheme_before_main_content','amplify_audiotheme_open',999);

/**
 * Close the custom wrapper HTML for AudioTheme.
 *
 * @since 1.0.0
 */
function amplify_audiotheme_close($content){
?>
      </div><!-- /.inner -->
    </div><!-- /#content -->
    <?php get_sidebar(); ?>
  </div><!-- /#main -->
<?php
}
add_action('audiotheme_after_main_content','amplify_audiotheme_close',1);