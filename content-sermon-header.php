<?php
/**
 * Post Header Meta (Full and Short)
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<header class="uplifted-entry-header uplifted-clearfix">

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="uplifted-entry-image">
			<?php uplifted_post_image(); ?>
		</div>
	<?php endif; ?>

	<div class="uplifted-entry-title-meta">

		<?php if ( ctfw_has_title() ) : ?>
			<h1 class="uplifted-entry-title<?php if ( is_singular( get_post_type() ) ) : ?> uplifted-main-title<?php endif; ?>">
				<?php uplifted_post_title(); // will be linked on short ?>
			</h1>
		<?php endif; ?>

		<ul class="uplifted-entry-meta">

			<li class="uplifted-entry-date uplifted-content-icon">
				<span class="<?php uplifted_icon_class( 'entry-date' ); ?>"></span>
				<time datetime="<?php esc_attr( the_time( 'c' ) ); ?>"><?php ctfw_post_date(); ?></time>
			</li>

			<?php if ( $speakers = get_the_term_list( $post->ID, 'ctc_sermon_speaker', '', __( ', ', 'uplifted' ) ) ) : ?>
				<li class="uplifted-entry-byline uplifted-sermon-speaker uplifted-content-icon">
					<span class="<?php uplifted_icon_class( 'sermon-speaker' ); ?>"></span>
					<?php echo $speakers; ?>
				</li>
			<?php endif; ?>

			<?php if ( $topics = get_the_term_list( $post->ID, 'ctc_sermon_topic', '', __( ', ', 'uplifted' ) ) ) : ?>
				<li class="uplifted-entry-category uplifted-sermon-topic uplifted-content-icon">
					<span class="<?php uplifted_icon_class( 'sermon-topic' ); ?>"></span>
					<?php echo $topics; ?>
				</li>
			<?php endif; ?>

			<?php if ( $books = get_the_term_list( $post->ID, 'ctc_sermon_book', '', __( ', ', 'uplifted' ) ) ) : ?>
				<li class="uplifted-entry-category uplifted-sermon-book uplifted-content-icon">
					<span class="<?php uplifted_icon_class( 'sermon-book' ); ?>"></span>
					<?php echo $books; ?>
				</li>
			<?php endif; ?>

			<?php if ( uplifted_show_comments() ) : ?>
				<li class="uplifted-entry-comments-link uplifted-content-icon">
					<span class="<?php uplifted_icon_class( 'comments-link' ); ?>"></span>
					<?php uplifted_comments_link(); ?>
				</li>
			<?php endif; ?>

		</ul>

	</div>

</header>
