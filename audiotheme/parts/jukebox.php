<?php
/**
 * The template for displaying the audio player bar across the bottom of the
 * site when it's enabled.
 *
 * @package Amplify
 * @since 1.0.0
 */
?>

<?php

$options = upfw_get_options();
$tracks = $options->jukebox;

$track_count = count( $tracks );

if ( is_audiotheme_active() && $track_count ) : amplify_get_jukebox_tracks(); ?>

  <div id="jukebox" class="jukebox">
    <span class="jp-controls">
      <a class="jp-previous icon-previous"></a>
      <a class="jp-play icon-play"></a>
      <a class="jp-pause icon-pause"></a>
      <a class="jp-next icon-next"></a>
    </span>

    <span class="track-details">
      <img src="img/icon-arrow-white.png" id="jukebox-artwork" alt="" >
      <span class="jp-title"></span>
    </span>

    <span class="jp-time">
      <span class="jp-current-time"></span> / <span class="jp-duration"></span>
    </span>

    <div class="jp-progress">
      <div class="jp-seek-bar"></div>
      <div class="jp-play-bar"></div>
    </div>

    <div class="jukebox-group jukebox-group--volume group-drop">
      <span class="group-drop-trigger"><i class="icon-volume-high"></i></span>

      <div class="group-drop-panel">
        <span class="jp-volume-bar">
          <span class="jp-volume-bar-value"></span>
        </span>
        <i class="icon-volume-high"></i>
      </div>
    </div>

    <div class="jukebox-group jukebox-group--playlist group-drop">
      <span class="group-drop-trigger"><i class="icon-list"></i></span>

      <div class="group-drop-panel">
        <div class="jp-playlist"><ul><li></li></ul></div>
      </div>
    </div>

    <span class="jukebox-toggle"><i class="icon-angle-left"></i></span>

    <div class="jp-player"></div>
  </div>

<?php endif; ?>