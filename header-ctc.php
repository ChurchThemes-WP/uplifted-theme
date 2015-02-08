<?php

/**
 * Church Theme Content header template.
 *
 * @package    Uplifted
 * @copyright  Copyright (c) 2014, upthemes.com
 * @link       https://upthemes.com/themes/uplifted
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      1.1.0
 */

?>

<div class="ctc-header">

	<?php if ( has_nav_menu( 'ctc' ) ) : ?>

	<nav class="ctc-nav">

		<?php get_template_part( 'menu', 'ctc' ); ?>

	</nav>

	<?php endif; ?>

</div>