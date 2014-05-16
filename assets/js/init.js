jQuery(function($) {

	// Reponsify videos.
	$('#content').fitVids();

	// Initialize any flexslider objects
	$('.flexslider').flexslider();

	if ( 'ontouchstart' in window || 'onmsgesturechange' in window ) {
		$('body').addClass('touch');
	}

	$('.oembed').oembed(null, {embedMethod: "append"});

	$(document).ready(function() {
		$('.oembed').on('click',function(e){
			e.preventDefault();
			var $slide = $(this).parents('li'),
				slideHeight = $slide.height();

			$slide.height(slideHeight);

			$(this).parent().fitVids().find('.oembed-container').addClass('visible');
			$('.flexslider').flexslider('pause');
		});
	});

});