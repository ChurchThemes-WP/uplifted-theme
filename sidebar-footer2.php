<?php
/**
 * The sidebar containing the first footer widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */
?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer2') ) : ?>

<?php endif; ?>