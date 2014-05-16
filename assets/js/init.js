jQuery(function($) {

	// Reponsify videos.
	$('#content').fitVids();

	// Initialize any flexslider objects
	$('.flexslider').flexslider();

	if ( 'ontouchstart' in window || 'onmsgesturechange' in window ) {
		$('body').addClass('touch');
	}

	$(document).ready(function() {
		$('.oembed').on('click',function(e){
			e.preventDefault();
			$(this).oembed(null, {embedMethod: "append"});
			$('.flexslider').flexslider('pause');
		});
	});

});