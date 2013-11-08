/*global americanauraL10n:true, AudiothemeJplayer:true, AudiothemeTracks:true, jPlayerPlaylist:true */

jQuery(function($) {
	'use strict';

	var Jukebox;

	// Reponsify videos.
	$('#content, .audiotheme-video').fitVids();

	// Open the flyout panel in the action group component.
	$('.action-group').hoverIntent({
		over: function() {
			$(this).addClass('is-open');
		},
		out: function() {
			$(this).removeClass('is-open');
		},
		timeout: 250
	});

	// Set up track lists.
	$('.audiotheme-record-single').each(function() {
		var $tracklist = $('.audiotheme-tracklist'),
			$tracks = $tracklist.find('.audiotheme-track'),
			$playableTracks;

		if ( 'undefined' === typeof AudiothemeTracks || null === AudiothemeTracks || ! ( 'record' in AudiothemeTracks ) ) {
			return;
		}

		// Loop through enqueued tracks and set up any that have an mp3.
		$.each( AudiothemeTracks.record, function( index, item ) {
			var $player, $track;

			if ( '' === item.mp3 ) {
				return;
			}

			$.jPlayer.timeFormat.padMin = false;
			$track = $( $tracks[ index ] ).addClass('is-playable');
			$track.find('.audiotheme-track-meta').append('<span class="sep-jp-duration"> / </span><span class="jp-duration">--:--</span>').find('.jp-duration, .sep-jp-duration').hide();
			$player = $track.append('<span class="jplayer"></span>').find('.jplayer');

			$player.jPlayer({
				ready: function () {
					$player.jPlayer('setMedia', { mp3: AudiothemeTracks.record[ index ].mp3 });
				},
				swfPath: AudiothemeJplayer.swfPath,
				solution: 'html, flash',
				supplied: 'mp3',
				wmode: 'window',
				cssSelectorAncestor: '#' + $track.attr('id'),
				play: function() {
					$track.addClass('is-playing').find('.jp-duration, .sep-jp-duration').show();
					$player.jPlayer('pauseOthers');
				},
				pause: function() {
					$track.removeClass('is-playing');
				},
				ended: function() {
					var playableIndex = $playableTracks.index( $track );

					$track.removeClass('is-playing');

					// Play the next track.
					if ( playableIndex < $playableTracks.length - 1 ) {
						$playableTracks.eq( playableIndex + 1 ).find('.jplayer').jPlayer('play');
					}
				}
			});

			$playableTracks = $tracks.filter('.is-playable');
		});

		$tracklist.on('click', '.is-playable', function() {
			var $track = $(this),
				$player = $track.find('.jplayer');

			// Determine if the track should start playing.
			if ( $track.hasClass('is-playing') ) {
				$player.jPlayer('pause');
			} else {
				$player.jPlayer('play');
			}
		}).on('click', '.is-playable a', function(e) {
			// Clicks on links shouldn't affect player behavior.
			e.stopPropagation();
		});
	});

	// Toggle "group drop" components.
	$('.group-drop').on('click', '.group-drop-trigger', function(e) {
		var $this = $(this),
			$group = $this.closest('.group-drop');

		e.preventDefault();

		$('.group-drop').not( $group ).removeClass('is-open').end().filter( $group ).toggleClass('is-open');
		$('.nav-toggle').addClass('is-closed');
	});

	/**
	 * Jukebox.
	 *
	 * The Jukebox is the jPlayer bar fixed to the bottom of the screen.
	 */
	Jukebox = {
		config: {
			options: {
				displayTime: 0,
				enableRemoveControls: false,
				solution: 'html, flash',
				supplied: 'mp3',
				swfPath: AudiothemeJplayer.swfPath,
				wmode: 'window', // For flash in Firefox, consider setting dynamically.
				ready: function() {
					var method = 'playing' === Jukebox.getStatus() ? 'play' : 'pause';

					$('body').addClass('has-jukebox');

					Jukebox.playlist.select( Jukebox.getResumeIndex() );
					Jukebox.setupPlaylist();

					$(this).jPlayer( method, Jukebox.getResumeTime() );
				},
				play: function(e) {
					var title = Jukebox.player.addClass('is-playing').find('a.jp-playlist-current').text(),
						index = Jukebox.player.find('a.jp-playlist-item').index( $('a.jp-playlist-current')[0] );

					$(this).jPlayer('pauseOthers');
					Jukebox.setTitle( title );
					Jukebox.setArtwork( 'artwork' in e.jPlayer.status.media ? e.jPlayer.status.media.artwork : null );

					// Save the index of the current item.
					Jukebox.state.jukeboxPlaylistIndex = index;
					Jukebox.setStatus('playing');
				},
				pause: function() {
					Jukebox.player.removeClass('is-playing');
					Jukebox.setStatus('paused');
				},
				ended: function() {
					Jukebox.player.removeClass('is-playing');
				},
				timeupdate: function(e) {
					if ( e.jPlayer.status.currentTime ) {
						Jukebox.state.jukeboxCurrentTime = e.jPlayer.status.currentTime;
					}
				}
			},
			selectors: {
				jPlayer: '#jukebox .jp-player',
				cssSelectorAncestor: '#jukebox'
			}
		},

		init: function() {
			if ( 'undefined' === typeof AudiothemeTracks || null === AudiothemeTracks || ! ( 'jukebox' in AudiothemeTracks ) ) {
				return;
			}

			$.extend( this.config, { playlist: AudiothemeTracks.jukebox } );

			this.state = sessionStorage || {};
			this.player = $('#jukebox');
			this.player.artwork = this.player.find('#jukebox-artwork');
			this.player.title = this.player.find('.jp-title');
			this.setVisibility();

			this.playlist = new jPlayerPlaylist( this.config.selectors, this.config.playlist, this.config.options );

			$('.jukebox-toggle').on('click', function() {
				Jukebox.toggleVisibility();
			});
		},

		getResumeIndex: function() {
			var index = 0;

			if ( 'undefined' !== typeof this.state.jukeboxPlaylistIndex && 'jukeboxPlaylistIndex' in this.state ) {
				index = parseInt( Jukebox.state.jukeboxPlaylistIndex, 10 );
			}

			return index;
		},

		getResumeTime: function() {
			var time = 0;

			if ( 'undefined' !== typeof Jukebox.state.jukeboxCurrentTime && 'jukeboxCurrentTime' in Jukebox.state ) {
				time = parseInt(Jukebox.state.jukeboxCurrentTime, 10);
			}

			return time;
		},

		getStatus: function() {
			var status = ''; // playing|paused

			if ( 'undefined' !== typeof this.state.jukeboxStatus && 'jukeboxStatus' in Jukebox.state ) {
				status = this.state.jukeboxStatus;
			}

			return status;
		},

		setupPlaylist: function() {
			var $playlist = this.player.find('.jp-playlist'),
				track = AudiothemeTracks.jukebox[ this.getResumeIndex() ];

			$playlist.find('li').each(function( i, item ) {
				$(item).find('.jp-playlist-item').before('<span class="jp-playlist-item-order icon-play"><i>' + ( i + 1 ) + '.</i></span>');
			});

			this.setTitle( track.title );
			this.setArtwork( track.artwork );
		},

		setArtwork: function( url ) {
			if ( url ) {
				this.player.artwork.attr( 'src', url ).show();
			} else {
				this.player.artwork.hide();
			}
		},

		setStatus: function( status ) {
			this.state.jukeboxStatus = status;
		},

		setTitle: function( title ) {
			if ( title ) {
				this.player.title.text( title ).show();
			} else {
				this.player.title.text('').hide();
			}
		},

		setVisibility: function( visibility ) {
			if ( ! visibility ) {
				visibility = 'jukeboxVisibility' in this.state ? this.state.jukeboxVisibility : 'open';
			}

			this.state.jukeboxVisibility = visibility;
			this.player.toggleClass( 'is-closed', ( 'closed' === visibility ) );
		},

		toggleVisibility: function() {
			this.setVisibility( 'open' === this.state.jukeboxVisibility ? 'closed' : 'open' );
		}
	};

	$('document').ready(function(e){

		Jukebox.init();

	});

});