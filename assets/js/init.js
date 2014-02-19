jQuery(function($) {

	// Reponsify videos.
	$('#content').fitVids();

	// Initialize any flexslider objects
	$('.flexslider').flexslider();

	if ( 'ontouchstart' in window || 'onmsgesturechange' in window ) {
		$('body').addClass('touch');
	}

});
