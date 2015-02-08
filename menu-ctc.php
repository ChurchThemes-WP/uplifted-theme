<?php if ( has_nav_menu( 'ctc' ) ) {

	do_action( 'uplifted_before_ctc_menu' );

	wp_nav_menu(
		array(
			'theme_location'  => 'ctc',
			'container'       => 'div',
			'container_id'    => 'menu-ctc',
			'container_class' => 'ctc',
			'menu_id'         => 'menu-ctc-items',
			'menu_class'      => 'menu-items',
			'depth'           => 1,
			'link_before'     => '<span class="screen-reader-text">',
			'link_after'      => '</span>',
			'fallback_cb'     => '',
		)
	);

	do_action( 'uplifted_after_ctc_menu' );

} ?>