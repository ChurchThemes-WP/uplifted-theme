<?php
/**
 * The template for displaying a single record.
 *
 * @package WordPress
 * @subpackage Amplify
 * @since 1.0.0
 */

get_header();
?>

<div class="audiotheme-record-single" role="main" itemscope itemtype="http://schema.org/MusicAlbum">

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
		
			<div class="audiotheme">
			
				<div id="main">
				
					<div class="secondary-area entry-meta">
						
						<header class="entry-header">
							<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
						</header>
	
						<?php get_template_part( 'audiotheme/parts/music-meta', 'record' ); ?>
		
					</div> <!-- /secondary-area -->

					<div class="primary-area">
						
						<header class="entry-header">
							<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
						</header>
		
						<?php get_template_part( 'audiotheme/parts/tracklist' ); ?>
		
						<div class="content entry-content" itemprop="description">
							<?php the_content( '' ); ?>
						</div>
		
					</div> <!-- /primary-area -->
			
				</div> <!-- /main -->
				
			</div> <!-- /audiotheme -->

		</article>

	<?php endwhile; ?>

</div>


<?php get_footer(); ?>