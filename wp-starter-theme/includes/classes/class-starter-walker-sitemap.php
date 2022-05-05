<?php 
/**
 * Clean Html Page Walker
 * 
 * @link https://codex.wordpress.org/Class_Reference/Walker
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Walker_Sitemap extends Walker_Page {

    // Displays start of a level. E.g '<ul>'
    public function start_lvl( &$output, $depth=0, $args=array() ) {
        $level = $depth + 1;
        $output .= '<ul class="sub-sitemap depth-'. $level .'">';
    }

    // Displays end of a level. E.g '</ul>'
    public function end_lvl( &$output, $depth=0, $args=array() ) {
        $output .= '</ul>';
    }

    // Displays start of an element. E.g '<li> Item Name'
    public function start_el( &$output, $page, $depth=0, $args=array(), $current_page=0 ) {
        $output .= ( $depth == 0 ) ? '<li class="sitemap-item column">' : '<li class="sitemap-item">';
            $output .= '<a class="sitemap-link" href="'. get_permalink($page->ID) .'" itemprop="url">';
                $output .= '<span itemprop="name">'. $page->post_title .'</span>';
            $output .= '</a>';
    }

    // Displays end of an element. E.g '</li>'
    public function end_el( &$output, $page, $depth=0, $args=array() ) {
        $output .= '</li>';
    }

}