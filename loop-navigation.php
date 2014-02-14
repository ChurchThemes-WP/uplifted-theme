<?php
/**
 * Output navigation at bottom of single and multiple loops
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// Left/right icons
$icon_left = '<span class="uplifted-button-icon ' . uplifted_get_icon_class( 'nav-left' ) . '"></span>';
$icon_right = '<span class="uplifted-button-icon ' . uplifted_get_icon_class( 'nav-right' ) . '"></span>';

/*********************************
 * ATTACHMENT - Back to Parent
 *********************************/

// No prev/next for gallery images since images can belong to multiple galleries.
// Instead, a lightbox plugin like Jetpack Carousel can be used for prev/next.

if ( is_attachment() ) :

?>

	<?php
	if ( ! empty( $post->post_parent ) && $parent_post = get_post( $post->post_parent ) ) : ?>

		<nav class="pagination attachment-pagination">
			<div class="uplifted-nav-left"><?php previous_post_link( '%link', sprintf( __( '&larr;  %s Back to %s', 'uplifted' ), $icon_left, $parent_post->post_title ) ); ?></div>
		</nav>

	<?php endif; ?>

<?php

/*********************************
 * SINGLE POST - Prev / Next
 *********************************/

elseif ( is_singular() && ! uplifted_loop_after_content_used() ) : // use Multiple Posts nav on "loop after content" pages

?>

	<?php

	// Let child themes change this
	$prev_next_title_characters = apply_filters( 'uplifted_prev_next_title_characters', 25 );

	// no nav for regular pages
	if ( ! is_page() ) :

	?>

		<nav class="uplifted-nav-left-right pagination">

			<?php if ( $prev_post = get_previous_post() ) : ?>
				<div class="uplifted-nav-left">
					<?php
					/* translators: %1$s is left arrow icon, %2$s is post title */
					previous_post_link( '%link', sprintf( _x( '&larr; %1$s %2$s', 'previous post link', 'uplifted' ), $icon_left, ctfw_shorten( $prev_post->post_title, $prev_next_title_characters ) ) );
					?>
				</div>
			<?php endif; ?>

			<?php if ( $next_post = get_next_post() ) : ?>
				<div class="uplifted-nav-right">
					<?php
					/* translators: %1$s is post title, %2$s is right arrow icon */
					next_post_link( '%link', sprintf( _x( '%1$s %2$s &rarr;', 'next post link', 'uplifted' ), ctfw_shorten( $next_post->post_title, $prev_next_title_characters ), $icon_right ) );
					?>
				</div>
			<?php endif; ?>
		</nav>

	<?php endif; ?>

<?php

/*********************************
 * MULTIPLE POSTS - Page 1 2 3
 *********************************/

else :

	// Query to use for pagination
	if ( ! ( $query = uplifted_loop_after_content_query() ) ) {  // use "loop after content" query if available
		$query = $wp_query; // otherwise use default query
	}

?>

	<?php if ( $query->max_num_pages > 1 ) : // show only if more than 1 page ?>

		<nav class="pagination">

			<?php
			echo paginate_links( array(
				'base' 		=> str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ), // for search and archives: https://codex.wordpress.org/Function_Reference/paginate_links#Examples
				'current' 	=> max( 1, ctfw_page_num() ), // ctfw_page_num() returns/corrects $paged so pagination works on static front page
				'total' 	=> $query->max_num_pages,
				'type' 		=> 'list',
				'prev_text'	=> sprintf( _x( '&larr; %s Previous', 'pagination', 'uplifted' ), $icon_left ),
				'next_text'	=> sprintf( _x( 'Next %s &rarr;', 'pagination', 'uplifted' ), $icon_right ),
			) );
			?>

		</nav>

	<?php endif; ?>

<?php endif; ?>