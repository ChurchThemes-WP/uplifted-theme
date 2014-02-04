<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Uplifted
 * @since 1.0.0
 */

$up_options = upfw_get_options();

//get_current_template(true);

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title( '|', true, 'right' ); ?></title>

<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">

<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/print.css" media="print" />

<?php if( isset( $up_options->favicon ) && $up_options->favicon ): ?>
<link rel="icon" type="image/png" href="<?php echo $up_options->favicon; ?>">
<?php endif; ?>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<div id="wrapper">

  <?php do_action('before_header'); ?>

  <header id="masthead">

    <div class="top-bar-container fixed">
        <nav class="top-bar">

            <ul class="title-area">
              <li class="name">
                <h1 id="title">
                  <a class="title" href="<?php echo esc_attr( home_url('/') ); ?>">
                  <?php $header_image = get_header_image();
                  if ( ! empty( $header_image ) ) : ?>
                    <img src="<?php echo esc_attr( $header_image ); ?>" alt="" />
                  <?php endif; ?>
                  <?php if( display_header_text() ): ?>
                    <?php bloginfo('name'); ?>
                  <?php endif; ?>
                  </a>
                </h1>
              </li>
              <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
            </ul>

            <section class="top-bar-section">
                <?php foundation_top_bar_l(); ?>

                <?php foundation_top_bar_r(); ?>
            </section>
        </nav>
    </div>

  </header>

  <?php do_action('after_header'); ?>

  <?php uplifted_breadcrumbs( 'content' ); ?>

  <div id="container" class="clearfix">