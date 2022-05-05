<?php 
/**
 * Recommended way to include parent theme styles
 * 
 * @link https://developer.wordpress.org/themes/advanced-topics/child-themes/
 */
function starter_child_theme_scripts() {

    wp_enqueue_style( 'starter-parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'starter-child-style', get_stylesheet_directory_uri() . '/style.css', array( 'starter-parent-style' ), '' );

}
add_action( 'wp_enqueue_scripts', 'starter_child_theme_scripts', 999 );
