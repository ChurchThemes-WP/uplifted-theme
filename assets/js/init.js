(function( $ ){

	$(document).ready(function() {


		// Reponsify videos.
		$('#content').fitVids();

		// Initialize any flexslider objects
		$('.flexslider').flexslider();

		if ( 'ontouchstart' in window || 'onmsgesturechange' in window ) {
			$('body').addClass('touch');
		}

		$('.oembed').oembed(null, {embedMethod: "append"});

		$('.oembed').on('click',function(e){
			e.preventDefault();
			var $slide = $(this).parents('li'),
				slideHeight = $slide.height();

			$slide.height(slideHeight);

			$(this).parent().sliderVids({slideHeight: slideHeight}).find('.oembed-container').parents('li').addClass('visible');
			$('.flexslider').flexslider('pause');
		});
	});


	$.fn.sliderVids = function( options ) {
		var settings = {
			customSelector: null,
			slideHeight: '400px'
		};

		if(!document.getElementById('fit-vids-style')) {

			var div = document.createElement('div'),
					ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0],
					cssStyles = '&shy;<style>.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style>';

			div.className = 'fit-vids-style';
			div.id = 'fit-vids-style';
			div.style.display = 'none';
			div.innerHTML = cssStyles;

			ref.parentNode.insertBefore(div,ref);

		}

		if ( options ) {
			$.extend( settings, options );
		}

		console.log(options);

		return this.each(function(){
			var selectors = [
				"iframe[src*='player.vimeo.com']",
				"iframe[src*='youtube.com']",
				"iframe[src*='youtube-nocookie.com']",
				"iframe[src*='kickstarter.com'][src*='video.html']",
				"object",
				"embed"
			];

			if (settings.customSelector) {
				selectors.push(settings.customSelector);
			}

			var $allVideos = $(this).find(selectors.join(','));
			$allVideos = $allVideos.not("object object"); // SwfObj conflict patch

			$allVideos.each(function(){
				var $this = $(this);
				if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }

				var height = settings.slideHeight,
					width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width();

				if(!$this.attr('id')){
					var videoID = 'fitvid' + Math.floor(Math.random()*999999);
					$this.attr('id', videoID);
				}
				$this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', height);
				$this.removeAttr('height').removeAttr('width');
			});
		});
	};
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );