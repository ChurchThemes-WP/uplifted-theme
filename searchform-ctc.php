<?php
/**
 * The template for displaying the header search form.
 *
 * @package Uplifted
 * @since 1.1.0
 */
?>

<form class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<input type="search" placeholder="<?php esc_attr_e( 'Search', 'uplifted' ); ?>">

</form>