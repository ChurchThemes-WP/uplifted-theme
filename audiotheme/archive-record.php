<?php
/**
 * The template to display list of records.
 *
 * @package WordPress
 * @subpackage ShakenEncore
 * @since 1.0.0
 */

get_header();
?>

<div id="main">

    <div id="content">
    
      <h1 class="audiotheme-archive-title"><?php the_audiotheme_archive_title(); ?></h1>
      
        <div class="album-grid">
  
      		<?php while ( have_posts() ) : the_post(); ?>
      
      			<article class="album">
      				<a href="<?php the_permalink(); ?>">
      					<?php the_post_thumbnail( 'album_cover' ); ?>
      					<?php the_title( '<h1>', '</h1>' ); ?>
      					<!-- <?php $artist = get_audiotheme_record_artist(); echo esc_html( $artist ); ?> -->
      				</a>
      			</article>
      
      		<?php endwhile; ?>
  		
        </div> <!-- /album-grid -->
		
    </div> <!-- /content -->
    
</div> <!-- /main -->

<?php get_footer(); ?>