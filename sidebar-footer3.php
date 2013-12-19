<?php
/**
 * The sidebar containing the first footer widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Uplifted
 * @since 1.0.0
 */
?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer3') ) : ?>

<?php endif; ?>