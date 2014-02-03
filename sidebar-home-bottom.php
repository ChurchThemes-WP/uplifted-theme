<?php
/**
 * Homepage Bottom Widgets "Sidebar"
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<?php if ( is_active_sidebar( 'ctcom-home-bottom' ) ) : ?>

	<div id="uplifted-home-bottom-widgets">

		<div class="wall">

			<?php dynamic_sidebar( 'ctcom-home-bottom' ); ?>

		</div>

	</div>

<?php endif; ?>