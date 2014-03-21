<?php
/**
 * Template Name: Stack
 *
 * This template exists in order for the MP Stacks plugin to be associated with a page.
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

get_header(); // header.php ?>

<div id="uplifted-content">

	<div id="uplifted-content-inner">

		<div class="uplifted-content-block uplifted-content-block-close uplifted-clearfix">

			<?php the_content(); ?>

		</div>

	</div>

</div>

<?php get_footer(); // footer.php ?>