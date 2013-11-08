<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #container and #wrapper div elements.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */
?>
  </div><!-- /#container -->
  <div id="footer">
    <div class="row">

      <div class="small-12 large-4 columns">
			<?php if( !dynamic_sidebar('footer-1') ) ?>
      </div>

      <div class="small-12 large-4 columns">
			<?php if( !dynamic_sidebar('footer-2') ) ?>
      </div>

      <div class="small-12 large-4 columns">
			<?php if( !dynamic_sidebar('footer-3') ) ?>
      </div>

    </div><!-- /#row-->
  </div><!-- /#footer-->

</div><!-- /#wrapper -->

<?php get_template_part( 'audiotheme/parts/jukebox' ); ?>

<?php wp_footer() ?>

<script>
jQuery(document).foundation();
</script>

</body>
</html>